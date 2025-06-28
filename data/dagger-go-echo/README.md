# dagger with Go echo app

- 開発時はどうするのか微妙にわからない
- プログラムでかけるのでその点はいい
- https://zenn.dev/kun432/scraps/0a11ae01660805

## Commands
```bash
# ブラウザが立ち上がりログインできる
dagger login

# そのユーザー名でログインできる
dagger login <username>

# セットアップ
# dagger.json と .dagger が作成される。 .dagger は Go のアプリだがモジュールは別になっている模様
dagger init --sdk=go
```

## Functions
funcitons を表示する

```console
➜ dagger functions
▶ connect 0.3s
▶ load module: . 2.9s

Name             Description
container-echo   Returns a container that echoes whatever string argument is provided
grep-dir         Returns lines that match a pattern in the files of the provided Directory
```

これが functions
```go
type DaggerGoEchoTry struct{}

// これが関数。このコメントがそのまま説明になる
func (m *DaggerGoEchoTry) ContainerEcho(stringArg string) *dagger.Container {
	return dag.Container().From("alpine:latest").WithExec([]string{"echo", stringArg})
}

// hello
func (m *DaggerGoEchoTry) Hello(ctx context.Context,) (string, error) {
	return dag.Container().From("alpine:latest").WithExec([]string{"echo", "hello"}).Stdout(ctx)
}
```

呼び方
```console
$ dagger call hello
▶ connect 0.3s
▶ load module: . 0.9s
● parsing command line arguments 0.0s

● daggerGoEchoTry: DaggerGoEchoTry! 0.0s
▶ .hello: String! 1.1s

hello
```
