use crate::service::MemoService;
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn new(db: &DatabaseConnection) -> Result<()> {
    let title = libeditor::text("Title:")?;
    let description = libeditor::edit("")?;

    MemoService::create(db, title, description).await?;
    Ok(())
}
