package main

import (
	"github.com/enuesaa/.devdev/go-fx-httpcall/clientfx"
	"github.com/enuesaa/.devdev/go-fx-httpcall/cmdfx"
	"go.uber.org/fx"
)

func main() {
	fxapp := fx.New(
		cmdfx.Module,
		clientfx.Module,

		// エントリポイント
		fx.Invoke(func(cmd cmdfx.ICmd, client clientfx.IClient, shutdowner fx.Shutdowner) error {
			// fx.App をシャットダウン
			defer shutdowner.Shutdown()

			// メインロジック
			// コマンドライン引数をパース
			if err := cmd.Parse(); err != nil {
				return err
			}
			// http request
			if err := cmd.Run(); err != nil {
				return err
			}
			return nil
		}),

		// fx.App のロガー。Err のみ出力する
		fx.WithLogger(NewLogger),
	)
	fxapp.Run()
}
