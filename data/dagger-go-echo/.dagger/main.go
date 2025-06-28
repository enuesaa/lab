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

// このコメントがそのまま説明になる
func (m *App) Echo(ctx context.Context, stringArg string) (string, error) {
	return dag.Container().From("alpine:latest").WithExec([]string{"echo", stringArg}).Stdout(ctx)
}
