pub mod memos;
pub mod migration;

use anyhow::Result;
use sea_orm::{
    DatabaseConnection, SqlxSqliteConnector,
    sqlx::sqlite::{SqliteConnectOptions, SqlitePoolOptions},
};

use migration::Migrator;
use sea_orm_migration::MigratorTrait;

pub async fn connect(path: String) -> Result<DatabaseConnection> {
    let opts = SqliteConnectOptions::new()
        .filename(path)
        .create_if_missing(true);

    let pool = SqlitePoolOptions::new().connect_with(opts).await?;
    let db = SqlxSqliteConnector::from_sqlx_sqlite_pool(pool);

    Migrator::up(&db, None).await?;
    Ok(db)
}
