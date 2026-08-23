pub mod entities;
pub mod migrator;
pub mod repositories;

use anyhow::Result;
use sea_orm::{Database, DatabaseConnection};

use crate::paths;

pub async fn connect() -> Result<DatabaseConnection> {
    let db = Database::connect(paths::db_uri()?).await?;
    migrator::migrate(&db).await?;

    Ok(db)
}
