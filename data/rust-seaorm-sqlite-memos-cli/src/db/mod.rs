pub mod entity;
pub mod migrator;
pub mod repository;

use anyhow::Result;
use sea_orm::{Database, DatabaseConnection};
use std::env;

pub fn get_default_uri() -> Result<String> {
    let path = env::current_dir()?.join("data.db");
    Ok(format!("sqlite://{}?mode=rwc", path.to_string_lossy()))
}

pub async fn connect(dburi: String) -> Result<DatabaseConnection> {
    let db = Database::connect(dburi).await?;
    migrator::migrate(&db).await?;

    Ok(db)
}
