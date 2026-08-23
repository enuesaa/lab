mod cli;
mod commands;
mod db;
mod editor;
mod paths;

use anyhow::Result;
use clap::Parser;

#[tokio::main]
async fn main() -> Result<()> {
    let args = cli::Args::parse();
    let db = db::connect(paths::db_uri()?).await?;

    match args.command.unwrap_or(cli::Command::List) {
        cli::Command::List => commands::list(&db).await?,
        cli::Command::New => commands::new(&db).await?,
        cli::Command::Delete => commands::delete(&db).await?,
    }
    Ok(())
}
