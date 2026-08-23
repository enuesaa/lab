pub mod entities;
pub mod migrator;
pub mod repositories;

use anyhow::Result;
use sea_orm::{Database, DatabaseConnection};

pub async fn connect(dburi: String) -> Result<DatabaseConnection> {
    let db = Database::connect(dburi).await?;
    migrator::migrate(&db).await?;

    Ok(db)
}
