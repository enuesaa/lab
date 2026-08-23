mod handle;
mod db;
mod cli;

use anyhow::Result;
use clap::Parser;

#[tokio::main]
async fn main() -> Result<()> {
    let args = cli::Args::parse();
    let db = db::connect(cli::db_uri()?).await?;

    match args.command.unwrap_or(cli::Command::List) {
        cli::Command::List => handle::list(&db).await?,
        cli::Command::New => handle::new(&db).await?,
        cli::Command::Delete => handle::delete(&db).await?,
    }
    Ok(())
}
