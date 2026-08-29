use clap::{Parser, Subcommand};

#[derive(Parser, Debug)]
#[command(version = "v0.0.1")]
pub struct Args {
    /// SQLite DB File Path
    #[arg(long, default_value = "data.db")]
    pub dbpath: String,

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
