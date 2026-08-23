use clap::{Parser, Subcommand};

#[derive(Parser, Debug)]
#[command(version = "v0.0.1")]
pub struct Args {
    #[command(subcommand)]
    pub command: Option<Command>,
}

#[derive(Subcommand, Debug)]
pub enum Command {
    /// List memos and view/edit selected one in vim (default)
    Search,
    /// Add a new memo
    Add,
    /// Delete a memo
    Delete,
}
