mod cli;
mod db;
mod service;

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
        cli::Command::List => cli::list::list(&db).await?,
        cli::Command::New => cli::new::new(&db).await?,
        cli::Command::Delete => cli::delete::delete(&db).await?,
    }
    Ok(())
}
