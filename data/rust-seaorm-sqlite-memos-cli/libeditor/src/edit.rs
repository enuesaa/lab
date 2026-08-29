use anyhow::Result;
use std::ffi::OsStr;
use std::fs;
use std::process::Command as Cmd;

pub fn edit(initial: &str) -> Result<String> {
    let file = tempfile::Builder::new().suffix(".md").tempfile()?;
    fs::write(file.path(), initial)?;

    Cmd::new(OsStr::new("vim")).arg(file.path()).status()?;

    let content = fs::read_to_string(file.path())?;
    Ok(content)
}
