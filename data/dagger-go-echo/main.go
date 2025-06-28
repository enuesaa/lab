package main

import (
	"github.com/enuesaa/playground-2025/dagger-go-echo-sqlc/db"

	"github.com/labstack/echo/v4"
)

func main() {
	queries, err := db.Open()
	if err != nil {
		panic(err)
	}

	e := setupRouter(queries)
	e.Logger.Fatal(e.Start(":8080"))
}

func setupRouter(queries *db.Queries) *echo.Echo {	
	e := echo.New()
	e.GET("/", func(c echo.Context) error {
		tasks, err := queries.ListTasks(c.Request().Context())
		if err != nil {
			return c.JSON(500, err)
		}
		return c.JSON(200, tasks)
	})
	return e
}
