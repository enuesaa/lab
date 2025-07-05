package main

import (
	"net/http/httptest"
	"testing"

	"github.com/enuesaa/lab/data/dagger-go-echo/db"
	"github.com/labstack/echo/v4"
	"github.com/stretchr/testify/assert"
	"github.com/stretchr/testify/require"
)

func TestGetTasksHandler(t *testing.T) {
	dbq, err := db.Open()
	if err != nil {
		t.Fatalf("error: %v", err)
	}
	defer dbq.Close()

	// handler
	handler := Handler{dbq: dbq}

	// req
	req := httptest.NewRequest("GET", "/", nil)
	rec := httptest.NewRecorder()
	c := echo.New().NewContext(req, rec)

	// test
	err = handler.ListTasks(c)
	require.NoError(t, err)
	assert.Equal(t, 200, rec.Code)
}
