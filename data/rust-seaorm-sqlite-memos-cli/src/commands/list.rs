use anyhow::Result;
use sea_orm::DatabaseConnection;

use crate::db::repository::memos::MemoRepository;
use crate::editor;

pub async fn list(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoRepository::find_all(db).await?;
    if memos.is_empty() {
        println!("No memos yet.");
        return Ok(());
    }

    let items: Vec<(i32, String)> = memos.into_iter().map(|m| (m.id, m.title)).collect();
    let labels: Vec<String> = items.iter().map(|(_, t)| t.clone()).collect();

    let selected_label = editor::select_from("Memo:", labels.clone())?;
    let (id, _) = items[labels.iter().position(|l| l == &selected_label).unwrap()].clone();

    let memo = MemoRepository::find_by_id(db, id).await?;
    let edited = editor::edit(&memo.description)?;

    if edited != memo.description {
        MemoRepository::update_description(db, id, edited).await?;
    }
    Ok(())
}
