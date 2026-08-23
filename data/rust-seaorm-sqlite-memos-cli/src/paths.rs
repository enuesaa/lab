use anyhow::Result;
use std::env;
use std::path::PathBuf;

/* db file */
pub fn db_file_path() -> Result<PathBuf> {
    Ok(env::current_dir()?.join("data.db"))
}

pub fn db_uri() -> Result<String> {
    let path = db_file_path()?;
    Ok(format!("sqlite://{}?mode=rwc", path.to_string_lossy()))
}
