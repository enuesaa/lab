package main

import (
	"context"
	"dagger/app/internal/dagger"
)

type App struct{}

// container
func (m *App) Container() *dagger.Container {
	src := dag.CurrentModule().Source().Directory("..")
	container := dag.Container().Build(src, dagger.ContainerBuildOpts{
		Dockerfile: "Dockerfile",
		Target: "builder",
	})
	return container
}

// sqlc generate
func (m *App) Sqlc(ctx context.Context) (string, error) {
	return m.Container().
		WithExec([]string{"go", "install", "github.com/sqlc-dev/sqlc/cmd/sqlc@latest"}).
		WithExec([]string{"sqlc", "generate"}).
		Stdout(ctx)
}

// migrate up
func (m *App) Migrate(ctx context.Context) (string, error) {
	mysql := dag.Container().
		From("mysql:8.0").
		WithEnvVariable("MYSQL_ROOT_PASSWORD", "password").
		WithEnvVariable("MYSQL_DATABASE", "app").
		WithExposedPort(3306).
		AsService()

	src := dag.CurrentModule().Source().Directory("..")
	
	return m.Container().
		WithServiceBinding("mysql", mysql).
		WithDirectory("/app", src).
		WithWorkdir("/app").
		WithExec([]string{"go", "install", "-tags", "mysql", "github.com/golang-migrate/migrate/v4/cmd/migrate@latest"}).
		WithExec([]string{"migrate", "-path", "./migrations", "-database", "mysql://root:password@mysql:3306/app", "up"}).
		Stdout(ctx)
}

// lint
func (m *App) Lint(ctx context.Context) (string, error) {
	return m.Container().
		WithExec([]string{"go", "install", "honnef.co/go/tools/cmd/staticcheck@latest"}).
		WithExec([]string{"staticcheck", "./..."}).
		Stdout(ctx)
}

// test with mysql
func (m *App) Test(ctx context.Context) (string, error) {
	mysql := dag.Container().
		From("mysql:8.0").
		WithEnvVariable("MYSQL_ROOT_PASSWORD", "password").
		WithEnvVariable("MYSQL_DATABASE", "app").
		WithExposedPort(3306).
		AsService()

	src := dag.CurrentModule().Source().Directory("..")
	
	container := m.Container().
		WithServiceBinding("mysql", mysql).
		WithDirectory("/app", src).
		WithEnvVariable("DB_HOST", "mysql").
		WithEnvVariable("DB_PORT", "3306").
		WithEnvVariable("DB_USER", "root").
		WithEnvVariable("DB_PASSWORD", "password").
		WithEnvVariable("DB_NAME", "app").
		WithExec([]string{"go", "install", "-tags", "mysql", "github.com/golang-migrate/migrate/v4/cmd/migrate@latest"}).
		WithExec([]string{"migrate", "-path", "./migrations", "-database", "mysql://root:password@mysql:3306/app", "up"})
	
	return container.WithExec([]string{"go", "test", "-v", "./..."}).Stdout(ctx)
}
