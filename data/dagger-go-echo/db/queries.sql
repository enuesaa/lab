-- name: ListTasks :many
SELECT * FROM tasks ORDER BY created_at DESC;

-- name: CreateTask :execresult
INSERT INTO tasks (title, description) VALUES (?, ?);
