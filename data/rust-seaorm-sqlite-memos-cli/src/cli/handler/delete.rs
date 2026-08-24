use crate::service::MemoService;
use anyhow::Result;
use crate::libs::editor;
use sea_orm::DatabaseConnection;

pub async fn delete(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoService::list(db).await?;
    if memos.is_empty() {
        println!("No memos.");
        return Ok(());
    }

    let titles: Vec<String> = memos.iter().map(|m| m.title.clone()).collect();
    let selected_title = editor::select_from("Delete which memo?", titles.clone())?;
    let memo = memos.into_iter().find(|m| m.title == selected_title).unwrap();

    if editor::confirm(&format!("Delete \"{}\"?", memo.title))? {
        MemoService::delete(db, memo.id).await?;
    }
    Ok(())
}