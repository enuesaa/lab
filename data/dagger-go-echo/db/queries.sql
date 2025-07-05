-- name: ListTasks :many
SELECT * FROM tasks ORDER BY created_at DESC;
