use editor;
use crate::service::MemoService;
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn list(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoService::list(db).await?;
    if memos.is_empty() {
        println!("No memos.");
        return Ok(());
    }

    let titles: Vec<String> = memos.iter().map(|m| m.title.clone()).collect();
    let selected_title = editor::select_from("Select a memo:", titles)?;

    let memo = memos.into_iter().find(|m| m.title == selected_title).unwrap();
    let edited = editor::edit(&memo.description)?;

    if edited != memo.description {
        MemoService::update_description(db, memo.id, edited).await?;
    }
    Ok(())
}