use anyhow::Result;
use sea_orm::DatabaseConnection;

use crate::db::repository::memos::MemoRepository;
use crate::editor;

pub async fn new(db: &DatabaseConnection) -> Result<()> {
    let title = editor::text("Title:")?;
    let description = editor::edit("")?;

    MemoRepository::create(db, title, description).await?;
    Ok(())
}
