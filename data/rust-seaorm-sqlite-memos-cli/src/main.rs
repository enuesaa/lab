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
        cli::Command::List => cli::handler::list(&db).await?,
        cli::Command::New => cli::handler::new(&db).await?,
        cli::Command::Delete => cli::handler::delete(&db).await?,
    }
    Ok(())
}
