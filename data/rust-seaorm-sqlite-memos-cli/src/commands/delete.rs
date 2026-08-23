use anyhow::Result;
use sea_orm::DatabaseConnection;

use crate::db::repositories::memos::MemoRepository;
use crate::editor;

pub async fn delete(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoRepository::find_all(db).await?;
    if memos.is_empty() {
        println!("No memos yet.");
        return Ok(());
    }

    let items: Vec<(i32, String)> = memos.into_iter().map(|m| (m.id, m.title)).collect();
    let labels: Vec<String> = items.iter().map(|(_, t)| t.clone()).collect();

    let selected_label = editor::select_from("Delete which memo?", labels.clone())?;
    let (id, title) = items[labels.iter().position(|l| l == &selected_label).unwrap()].clone();

    if editor::confirm(&format!("Delete \"{}\"?", title))? {
        MemoRepository::delete(db, id).await?;
        println!("Deleted.");
    }

    Ok(())
}
