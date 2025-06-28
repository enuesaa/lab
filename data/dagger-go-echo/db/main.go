package db

import (
	"database/sql"
	"os"

	_ "github.com/go-sql-driver/mysql"
)

func Open() (*Queries, error) {
	dburl := os.Getenv("DATABASE_URL")

	conn, err := sql.Open("mysql", dburl)
	if err != nil {
		return nil, err
	}
	return New(conn), nil
}

// func Close(q *Queries) {
// 	q.db.Close()
// }
