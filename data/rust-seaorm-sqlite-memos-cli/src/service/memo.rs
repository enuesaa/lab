use crate::db::memos;
use anyhow::{Result, anyhow};
use chrono::Utc;
use sea_orm::{ActiveModelTrait, DatabaseConnection, EntityTrait, Set};

pub struct MemoService;

impl MemoService {
    pub async fn list(db: &DatabaseConnection) -> Result<Vec<memos::Model>> {
        Ok(memos::Entity::find().all(db).await?)
    }

    pub async fn create(db: &DatabaseConnection, title: String, description: String) -> Result<memos::Model> {
        let now = Utc::now();

        let memo = memos::ActiveModel {
            title: Set(title),
            description: Set(description),
            created_at: Set(now.into()),
            updated_at: Set(now.into()),
            ..Default::default()
        };
        Ok(memo.insert(db).await?)
    }

    pub async fn update(db: &DatabaseConnection, memo: memos::Model) -> Result<memos::Model> {
        let mut active: memos::ActiveModel = memo.into();
        active.updated_at = Set(Utc::now().into());
        Ok(active.update(db).await?)
    }

    pub async fn delete(db: &DatabaseConnection, id: i32) -> Result<()> {
        memos::Entity::delete_by_id(id).exec(db).await?;
        Ok(())
    }
}
