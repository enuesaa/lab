-- +goose Up
INSERT INTO tasks (id, title, description) VALUES (1, 'タスク1', '');

-- +goose Down
DELETE FROM tasks WHERE id = 1;
