mod cli;
mod db;
mod service;

use anyhow::Result;
use clap::Parser;

#[tokio::main]
async fn main() -> Result<()> {
    let args = cli::Args::parse();
    let db = db::connect(args.dbpath).await?;

    match args.command.unwrap_or(cli::Command::List) {
        // メモ一覧
        cli::Command::List => cli::handler::list(&db).await?,
        // メモ作成
        cli::Command::New => cli::handler::new(&db).await?,
        // メモ削除
        cli::Command::Delete => cli::handler::delete(&db).await?,
    }
    Ok(())
}
