use anyhow::Result;
use inquire::Text;

use crate::cli::{Args, Command};
use crate::db;
use crate::db::repositories::memos::MemoRepository;

pub async fn run(args: Args) -> Result<()> {
    let db = db::connect().await?;

    match args.command.unwrap_or(Command::Search) {
        Command::Search => {
            prompt_note()?;

            let memo_list = MemoRepository::find_all(&db).await?;
            let items: Vec<(i32, String)> = memo_list.into_iter().map(|m| (m.id, m.title)).collect();

            // if let Ok(selected) = search::search(items) {
            //     println!("Selected: {:?}", selected);
            // }
        }

        Command::Add { title, description } => {
            let inserted = MemoRepository::create(&db, title, description).await?;
            println!("Inserted: {:?}", inserted);
        }
    }

    Ok(())
}

use std::ffi::OsStr;
use std::fs;
use std::process::Command as Cmd;

fn open_editor(editor_command: &OsStr, file_extension: &str) -> std::io::Result<String> {
    let file = tempfile::Builder::new().suffix(file_extension).tempfile()?;
    let path = file.path().to_owned();

    Cmd::new(editor_command).arg(&path).status()?;

    fs::read_to_string(&path)
}

pub fn prompt_note() -> Result<()> {
    let title = Text::new("Title:").prompt()?;
    let description = open_editor(OsStr::new("vim"), ".md")?;
    Ok(())
}
