// A generated module for App functions
//
// This module has been generated via dagger init and serves as a reference to
// basic module structure as you get started with Dagger.
//
// Two functions have been pre-created. You can modify, delete, or add to them,
// as needed. They demonstrate usage of arguments and return types using simple
// echo and grep commands. The functions can be called from the dagger CLI or
// from one of the SDKs.
//
// The first line in this comment block is a short description line and the
// rest is a long description with more detail on the module's purpose or usage,
// if appropriate. All modules should have a short description.

package main

import (
	"context"
	"dagger/app/internal/dagger"
)

type App struct{}

// build scratch
func (m *App) BuildScratch() *dagger.Container {
	src := dag.CurrentModule().Source().Directory("..")
	builder := dag.Container().
		From("golang:1.24").
		WithMountedDirectory("/app", src).
		WithWorkdir("/app").
		WithExec([]string{"go", "build", "-o", "build/app"})

	container := dag.Container().
		From("debian:stable-slim").
		WithDirectory("/app", builder.Directory("/app/build")).
		WithWorkdir("/app").
		WithEntrypoint([]string{"./app"})

	return container
}

func (m *App) Build() *dagger.Container {
	src := dag.CurrentModule().Source().Directory("..")
	container := dag.Container().Build(src, dagger.ContainerBuildOpts{
		Dockerfile: "Dockerfile",
	})
	return container
}

// Generate runs sqlc generate
func (m *App) Generate(ctx context.Context) *dagger.Directory {
	src := dag.CurrentModule().Source().Directory("..")
	return dag.Container().
		From("golang:1.24").
		WithMountedDirectory("/app", src).
		WithWorkdir("/app").
		WithExec([]string{"go", "install", "github.com/sqlc-dev/sqlc/cmd/sqlc@latest"}).
		WithExec([]string{"sqlc", "generate"}).
		Directory("/app")
}

// このコメントがそのまま説明になる
func (m *App) Echo(ctx context.Context, stringArg string) (string, error) {
	return dag.Container().From("alpine:latest").WithExec([]string{"echo", stringArg}).Stdout(ctx)
}
