use anyhow::Result;
use inquire::Text;
use inquire::Editor;

use crate::cli::{Args, Command};
use crate::db;
use crate::db::repositories::memos::MemoRepository;
use crate::search;

pub async fn run(args: Args) -> Result<()> {
    let db = db::connect().await?;

    match args.command.unwrap_or(Command::Search) {
        Command::Search => {
            prompt_note()?;

            let memo_list = MemoRepository::find_all(&db).await?;
            let items: Vec<(i32, String)> = memo_list.into_iter().map(|m| (m.id, m.title)).collect();

            if let Ok(selected) = search::search(items) {
                println!("Selected: {:?}", selected);
            }
        }

        Command::Add { title, description } => {
            let inserted = MemoRepository::create(&db, title, description).await?;
            println!("Inserted: {:?}", inserted);
        }
    }

    Ok(())
}

use std::ffi::OsStr;

pub struct Note {
    pub title: String,
    pub description: String,
}

pub fn prompt_note() -> Result<Note> {
    let title = Text::new("Title:")
        .prompt()?;

    let description = Editor::new("Description")
        .with_editor_command(OsStr::new("vim"))
        .with_file_extension(".md")
        .prompt()?;

    Ok(Note {
        title,
        description,
    })
}
