use crate::{db::memos, service::MemoService};
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn new(db: &DatabaseConnection) -> Result<()> {
    let mut memo = memos::Model::new();
    memo.title = libeditor::text("Title:")?;
    memo.description = libeditor::edit("")?;

    MemoService::create(db, &memo).await?;
    Ok(())
}
