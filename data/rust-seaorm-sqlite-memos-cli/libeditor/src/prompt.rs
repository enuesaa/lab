use anyhow::Result;
use inquire::list_option::ListOption;
use inquire::{Confirm, Select, Text};

pub fn select(prompt: &str, labels: Vec<String>) -> Result<ListOption<String>> {
    let selected = Select::new(prompt, labels)
        .without_help_message()
        .raw_prompt()?;
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
