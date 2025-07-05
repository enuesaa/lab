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
		WithExec([]string{"go", "tool", "goose", "mysql", "root:password@tcp(mysql:3306)/test", "-dir", "./migrations", "up"})

	return app.WithExec([]string{"go", "test", "-v", "./..."}).Stdout(ctx)
}
