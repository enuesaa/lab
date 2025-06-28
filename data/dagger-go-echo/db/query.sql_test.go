package db

import (
	"context"
	"database/sql"
	"testing"

	_ "github.com/go-sql-driver/mysql"
	"github.com/stretchr/testify/assert"
	"github.com/stretchr/testify/require"
)

func TestListTasks(t *testing.T) {
	queries, err := Open()
	require.NoError(t, err)

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
	queries, err := Open()
	require.NoError(t, err)

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
	queries, err := Open()
	require.NoError(t, err)

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
