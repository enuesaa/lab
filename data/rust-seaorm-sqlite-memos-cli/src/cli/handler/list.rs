use crate::service::MemoService;
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn list(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoService::list(db).await?;
    if memos.is_empty() {
        println!("No memos.");
        return Ok(());
    }

    let titles = memos.iter().map(|m| m.title.clone()).collect();
    let selected = libeditor::select("Select a memo", titles)?;
    let mut memo = memos.into_iter().nth(selected.index).unwrap();

    memo.description = libeditor::edit(&memo.description)?;
    MemoService::update(db, memo).await?;
    Ok(())
}
