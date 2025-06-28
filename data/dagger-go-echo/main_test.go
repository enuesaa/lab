package main

import (
	"net/http"
	"net/http/httptest"
	"testing"

	"github.com/enuesaa/playground-2025/dagger-go-echo-sqlc/db"
	_ "github.com/go-sql-driver/mysql"
	"github.com/stretchr/testify/assert"
	"github.com/stretchr/testify/require"
)

func TestAPIEndpoint(t *testing.T) {
	queries, err := db.Open()
	require.NoError(t, err)

	e := setupRouter(queries)

	req := httptest.NewRequest("GET", "/", nil)
	rec := httptest.NewRecorder()
	e.ServeHTTP(rec, req)

	assert.Equal(t, http.StatusOK, rec.Code)
}
