package db

import (
	"context"
	"database/sql"
	"fmt"
	"os"
	"testing"

	_ "github.com/go-sql-driver/mysql"
	"github.com/stretchr/testify/assert"
	"github.com/stretchr/testify/require"
)

func setupTestDB() (*sql.DB, *Queries, error) {
	dbHost := os.Getenv("DB_HOST")
	dbPort := os.Getenv("DB_PORT")
	dbUser := os.Getenv("DB_USER")
	dbPassword := os.Getenv("DB_PASSWORD")
	dbName := os.Getenv("DB_NAME")

	if dbHost == "" {
		dbHost = "localhost"
	}
	if dbPort == "" {
		dbPort = "3306"
	}
	if dbUser == "" {
		dbUser = "root"
	}
	if dbPassword == "" {
		dbPassword = "password"
	}
	if dbName == "" {
		dbName = "app"
	}

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true", dbUser, dbPassword, dbHost, dbPort, dbName)
	
	dbConn, err := sql.Open("mysql", dsn)
	if err != nil {
		return nil, nil, err
	}

	if err := dbConn.Ping(); err != nil {
		return nil, nil, err
	}

	queries := New(dbConn)
	return dbConn, queries, nil
}

func TestListTasks(t *testing.T) {
	dbConn, queries, err := setupTestDB()
	require.NoError(t, err)
	defer dbConn.Close()

	ctx := context.Background()
	
	result, err := queries.CreateTask(ctx, CreateTaskParams{
		Title: "Test Task 1",
		Description: sql.NullString{String: "Test Description 1", Valid: true},
	})
	require.NoError(t, err)
	
	id, err := result.LastInsertId()
	require.NoError(t, err)

	tasks, err := queries.ListTasks(ctx)
	require.NoError(t, err)
	assert.GreaterOrEqual(t, len(tasks), 1)

	defer queries.DeleteTask(ctx, id)
}

func TestUpdateTask(t *testing.T) {
	dbConn, queries, err := setupTestDB()
	require.NoError(t, err)
	defer dbConn.Close()

	ctx := context.Background()
	
	result, err := queries.CreateTask(ctx, CreateTaskParams{
		Title: "Test Task",
		Description: sql.NullString{String: "Test Description", Valid: true},
	})
	require.NoError(t, err)
	
	id, err := result.LastInsertId()
	require.NoError(t, err)

	err = queries.UpdateTask(ctx, UpdateTaskParams{
		ID: id,
		Title: "Updated Task",
		Description: sql.NullString{String: "Updated Description", Valid: true},
	})
	require.NoError(t, err)

	task, err := queries.GetTask(ctx, id)
	require.NoError(t, err)
	assert.Equal(t, "Updated Task", task.Title)
	assert.Equal(t, "Updated Description", task.Description.String)

	defer queries.DeleteTask(ctx, id)
}

func TestDeleteTask(t *testing.T) {
	dbConn, queries, err := setupTestDB()
	require.NoError(t, err)
	defer dbConn.Close()

	ctx := context.Background()
	
	result, err := queries.CreateTask(ctx, CreateTaskParams{
		Title: "Test Task",
		Description: sql.NullString{String: "Test Description", Valid: true},
	})
	require.NoError(t, err)
	
	id, err := result.LastInsertId()
	require.NoError(t, err)

	err = queries.DeleteTask(ctx, id)
	require.NoError(t, err)

	_, err = queries.GetTask(ctx, id)
	assert.Error(t, err)
	assert.Equal(t, sql.ErrNoRows, err)
}