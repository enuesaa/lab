use crate::service::MemoService;
use anyhow::Result;
use sea_orm::DatabaseConnection;

pub async fn delete(db: &DatabaseConnection) -> Result<()> {
    let memos = MemoService::list(db).await?;
    if memos.is_empty() {
        println!("No memos.");
        return Ok(());
    }

    let titles = memos.iter().map(|m| m.title.clone()).collect();
    let selected = libeditor::select("Delete which memo?", titles)?;
    let memo = memos.into_iter().nth(selected.index).unwrap();

    if libeditor::confirm(&format!("Delete \"{}\"?", memo.title))? {
        MemoService::delete(db, memo.id).await?;
    }
    Ok(())
}
