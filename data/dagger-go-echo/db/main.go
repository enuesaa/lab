package db

import (
	"database/sql"
	"fmt"
	"os"

	_ "github.com/go-sql-driver/mysql"
)

type DB struct {
	*Queries
	Conn *sql.DB
}

func Open() (*DB, error) {
	dsn := os.Getenv("DATABASE_URL")
	if dsn == "" {
		return nil, fmt.Errorf("DATABASE_URL is empty")
	}

	conn, err := sql.Open("mysql", dsn)
	if err != nil {
		return nil, err
	}

	return &DB{
		Queries: New(conn),
		Conn:    conn,
	}, nil
}

func (db *DB) Close() error {
	return db.Conn.Close()
}
