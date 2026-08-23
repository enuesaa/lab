use anyhow::Result;
use inquire::{Confirm, Select, Text};

use crate::db::repositories::memos::MemoRepository;

pub async fn list(db: &sea_orm::DatabaseConnection) -> Result<()> {
    let memos = MemoRepository::find_all(db).await?;
    if memos.is_empty() {
        println!("No memos yet.");
        return Ok(());
    }

    let items: Vec<(i32, String)> = memos.into_iter().map(|m| (m.id, m.title)).collect();
    let labels: Vec<String> = items.iter().map(|(_, t)| t.clone()).collect();

    let selected_label = Select::new("Memo:", labels.clone()).without_help_message().prompt()?;
    let (id, _) = items[labels.iter().position(|l| l == &selected_label).unwrap()].clone();

    let memo = MemoRepository::find_by_id(db, id).await?;
    let edited = open_editor_with_content(&memo.description, ".md")?;

    if edited != memo.description {
        MemoRepository::update_description(db, id, edited).await?;
    }

    Ok(())
}

pub async fn new(db: &sea_orm::DatabaseConnection) -> Result<()> {
    let title = Text::new("Title:").prompt()?;
    let description = open_editor_with_content("", ".md")?;

    MemoRepository::create(db, title, description).await?;
    Ok(())
}

pub async fn delete(db: &sea_orm::DatabaseConnection) -> Result<()> {
    let memos = MemoRepository::find_all(db).await?;
    if memos.is_empty() {
        println!("No memos yet.");
        return Ok(());
    }

    let items: Vec<(i32, String)> = memos.into_iter().map(|m| (m.id, m.title)).collect();
    let labels: Vec<String> = items.iter().map(|(_, t)| t.clone()).collect();

    let selected_label = Select::new("Delete which memo?", labels.clone()).prompt()?;
    let (id, title) = items[labels.iter().position(|l| l == &selected_label).unwrap()].clone();

    let confirmed = Confirm::new(&format!("Delete \"{}\"?", title))
        .with_default(false)
        .prompt()?;

    if confirmed {
        MemoRepository::delete(db, id).await?;
        println!("Deleted.");
    }

    Ok(())
}

use std::ffi::OsStr;
use std::fs;
use std::process::Command as Cmd;

fn open_editor_with_content(initial: &str, file_extension: &str) -> std::io::Result<String> {
    let file = tempfile::Builder::new().suffix(file_extension).tempfile()?;
    fs::write(file.path(), initial)?;

    Cmd::new(OsStr::new("vim")).arg(file.path()).status()?;
    fs::read_to_string(file.path())
}
