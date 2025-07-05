package main

import (
	"github.com/enuesaa/lab/data/dagger-go-echo/db"

	"github.com/labstack/echo/v4"
)

func main() {
	dbq, err := db.Open()
	if err != nil {
		panic(err)
	}
	defer dbq.Close()

	// routes
	e := echo.New()
	e.GET("/", func(c echo.Context) error {
		tasks, err := dbq.ListTasks(c.Request().Context())
		if err != nil {
			return err
		}
		return c.JSON(200, tasks)
	})
	e.Logger.Fatal(e.Start(":8080"))
}
