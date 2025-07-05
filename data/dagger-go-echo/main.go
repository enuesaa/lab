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

	// handler
	handler := Handler{dbq: dbq}

	// routing
	e := echo.New()
	e.GET("/", handler.ListTasks)

	// start
	e.Logger.Fatal(e.Start(":8080"))
}

type Handler struct {
	dbq *db.DB
}

func (h *Handler) ListTasks(c echo.Context) error {
	tasks, err := h.dbq.ListTasks(c.Request().Context())
	if err != nil {
		return err
	}
	return c.JSON(200, tasks)
}
