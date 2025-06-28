package main

import (
	"context"
	"dagger/app/internal/dagger"
)

type App struct{}

// app container
func (m *App) AppContainer() *dagger.Container {
	src := dag.CurrentModule().Source().Directory("..")
	buildops := dagger.ContainerBuildOpts{
		Dockerfile: "Dockerfile",
		Target: "builder",
	}

	return dag.Container().
		Build(src, buildops).
		WithExposedPort(8080)
}

// mysql container
func (m *App) MySQLContainer() *dagger.Container {
	return dag.Container().
		From("mysql:8.0").
		WithEnvVariable("MYSQL_ROOT_PASSWORD", "password").
		WithEnvVariable("MYSQL_DATABASE", "test").
		WithExposedPort(3306)
}

// up dev server
func (m *App) Up(ctx context.Context) error {
	mysql := m.MySQLContainer().AsService()
	app := m.AppContainer().
		WithServiceBinding("mysql", mysql).
		WithEnvVariable("DATABASE_URL", "root:password@tcp(mysql:3306)/test?parseTime=true").		
		WithExec([]string{"go", "install", "-tags", "mysql", "github.com/golang-migrate/migrate/v4/cmd/migrate@latest"}).
		WithExec([]string{"migrate", "-path", "migrations", "-database", "mysql://root:password@tcp(mysql:3306)/test", "up"}).
		AsService()
	return app.Up(ctx)
}

// sqlc generate
func (m *App) Sqlc(ctx context.Context) (string, error) {
	return m.AppContainer().
		WithExec([]string{"go", "install", "github.com/sqlc-dev/sqlc/cmd/sqlc@latest"}).
		WithExec([]string{"sqlc", "generate"}).
		Stdout(ctx)
}

// // migrate
// func (m *App) Migrate(ctx context.Context,
// 	container *dagger.Container,
// 	// +optional 
// 	// +default="mysql://root:password@tcp(mysql:3306)/app"
// 	databaseUrl string,
// 	// +optional
// 	// +default="version"
// 	command string,
// ) (string, error) {
// 	return container.
// 		WithExec([]string{"go", "install", "-tags", "mysql", "github.com/golang-migrate/migrate/v4/cmd/migrate@latest"}).
// 		WithExec([]string{"migrate", "-path", "migrations", "-database", databaseUrl, command}).
// 		Stdout(ctx)
// }

// lint
func (m *App) Lint(ctx context.Context) (string, error) {
	return m.AppContainer().
		WithExec([]string{"go", "install", "honnef.co/go/tools/cmd/staticcheck@latest"}).
		WithExec([]string{"staticcheck", "./..."}).
		Stdout(ctx)
}

// test
func (m *App) Test(ctx context.Context) (string, error) {
	mysql := m.MySQLContainer().AsService()
	app := m.AppContainer().
		WithServiceBinding("mysql", mysql).
		WithEnvVariable("DATABASE_URL", "root:password@tcp(mysql:3306)/test?parseTime=true").
		WithExec([]string{"go", "install", "-tags", "mysql", "github.com/golang-migrate/migrate/v4/cmd/migrate@latest"}).
		WithExec([]string{"migrate", "-path", "migrations", "-database", "mysql://root:password@tcp(mysql:3306)/test", "up"})

	return app.WithExec([]string{"go", "test", "-v", "./..."}).Stdout(ctx)
}
