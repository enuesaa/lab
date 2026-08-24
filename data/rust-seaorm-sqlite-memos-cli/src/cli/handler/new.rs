use editor;
use crate::service::MemoService;
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn new(db: &DatabaseConnection) -> Result<()> {
    let title = editor::text("Title:")?;
    let description = editor::edit("")?;

    MemoService::create(db, title, description).await?;
    Ok(())
}