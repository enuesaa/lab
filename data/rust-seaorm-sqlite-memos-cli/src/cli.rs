use anyhow::Result;
use std::env;
use std::path::PathBuf;
use clap::{Parser, Subcommand};

#[derive(Parser, Debug)]
#[command(version = "v0.0.1")]
pub struct Args {
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

pub fn db_file_path() -> Result<PathBuf> {
    Ok(env::current_dir()?.join("data.db"))
}

pub fn db_uri() -> Result<String> {
    let path = db_file_path()?;
    Ok(format!("sqlite://{}?mode=rwc", path.to_string_lossy()))
}
