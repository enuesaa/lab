mod cli;
mod commands;
mod db;
mod editor;

use anyhow::Result;
use clap::Parser;

#[tokio::main]
async fn main() -> Result<()> {
    let args = cli::Args::parse();

    let dburi = match args.dburi {
        Some(uri) => uri,
        None => db::get_default_uri()?,
    };
    let db = db::connect(dburi).await?;

    match args.command.unwrap_or(cli::Command::List) {
        cli::Command::List => commands::list(&db).await?,
        cli::Command::New => commands::new(&db).await?,
        cli::Command::Delete => commands::delete(&db).await?,
    }
    Ok(())
}
