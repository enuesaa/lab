use anyhow::Result;
use inquire::{Confirm, Select, Text};

pub fn select_from(prompt: &str, labels: Vec<String>) -> Result<String> {
    let selected = Select::new(prompt, labels).without_help_message().prompt()?;
    Ok(selected)
}

pub fn confirm(message: &str) -> Result<bool> {
    let confirmed = Confirm::new(message).with_default(false).prompt()?;
    Ok(confirmed)
}

pub fn text(prompt: &str) -> Result<String> {
    let value = Text::new(prompt).prompt()?;
    Ok(value)
}
