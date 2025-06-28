package main

import (
	"database/sql"
	"log"
	"os"

	"github.com/enuesaa/lab/data/dagger-go-echo/db"
	_ "github.com/go-sql-driver/mysql"
	"net/http"

	"github.com/labstack/echo/v4"
)

func main() {
	dbConn, err := sql.Open("mysql", os.Getenv("DATABASE_URL"))
	if err != nil {
		log.Fatal(err)
	}
	defer dbConn.Close()

	queries := db.New(dbConn)
	e := setupRouter(queries)
	e.Logger.Fatal(e.Start(":8080"))
}

func setupRouter(queries *db.Queries) *echo.Echo {
	e := echo.New()
	
	e.GET("/", func(c echo.Context) error {
		tasks, err := queries.ListTasks(c.Request().Context())
		if err != nil {
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": err.Error()})
		}
		return c.JSON(http.StatusOK, tasks)
	})
	
	return e
}