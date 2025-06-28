package main

import (
	"database/sql"
	"log"
	"net/http"
	"os"

	"github.com/enuesaa/lab/data/dagger-go-echo/db"
	_ "github.com/go-sql-driver/mysql"
	"github.com/labstack/echo/v4"
)

func main() {
	dbConn, err := sql.Open("mysql", os.Getenv("DATABASE_URL"))
	if err != nil {
		log.Fatal(err)
	}
	defer dbConn.Close()

	queries := db.New(dbConn)

	e := echo.New()
	e.GET("/", func(c echo.Context) error {
		tasks, err := queries.ListTasks(c.Request().Context())
		if err != nil {
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": err.Error()})
		}
		return c.JSON(http.StatusOK, tasks)
	})
	e.Logger.Fatal(e.Start(":8080"))
}
