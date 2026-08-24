pub mod handler;

use clap::{Parser, Subcommand};

#[derive(Parser, Debug)]
#[command(version = "v0.0.1")]
pub struct Args {
    /// Database URI (default: sqlite://<current dir>/data.db)
    #[arg(long)]
    pub dburi: Option<String>,

    #[command(subcommand)]
    pub command: Option<Command>,
}

#[derive(Subcommand, Debug)]
pub enum Command {
    /// List memos
    List,
    /// Create a new memo
    New,
    /// Delete a memo
    Delete,
}
