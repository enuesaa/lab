package db

import (
	"testing"

	_ "github.com/go-sql-driver/mysql"
	"github.com/stretchr/testify/assert"
	"github.com/stretchr/testify/require"
)

func TestListTasks(t *testing.T) {
	dbq, err := Open()
	require.NoError(t, err)

	task := CreateTaskParams{
		Title: "Test Task 1",
	}
	_, err = dbq.CreateTask(t.Context(), task)
	require.NoError(t, err)

	tasks, err := dbq.ListTasks(t.Context())
	require.NoError(t, err)
	assert.Equal(t, len(tasks), 1)
}
