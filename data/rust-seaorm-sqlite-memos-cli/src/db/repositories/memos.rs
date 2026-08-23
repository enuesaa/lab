use anyhow::{anyhow, Result};
use chrono::Utc;
use sea_orm::{
    ActiveModelTrait,
    DatabaseConnection,
    EntityTrait,
    Set,
};
use crate::db::entities::memos;

pub struct MemoRepository;

impl MemoRepository {
    pub async fn find_all(
        db: &DatabaseConnection,
    ) -> Result<Vec<memos::Model>> {
        let memos = memos::Entity::find()
            .all(db)
            .await?;

        Ok(memos)
    }

    pub async fn create(
        db: &DatabaseConnection,
        title: String,
        description: String,
    ) -> Result<memos::Model> {
        let now = Utc::now();

        let memo = memos::ActiveModel {
            title: Set(title),
            description: Set(description),
            created_at: Set(now.into()),
            updated_at: Set(now.into()),
            ..Default::default()
        };

        let inserted = memo.insert(db).await?;

        Ok(inserted)
    }

    pub async fn find_by_id(
        db: &DatabaseConnection,
        id: i32,
    ) -> Result<memos::Model> {
        memos::Entity::find_by_id(id)
            .one(db)
            .await?
            .ok_or_else(|| anyhow!("memo not found: {}", id))
    }

    pub async fn update_description(
        db: &DatabaseConnection,
        id: i32,
        description: String,
    ) -> Result<memos::Model> {
        let memo = Self::find_by_id(db, id).await?;
        let mut active: memos::ActiveModel = memo.into();

        active.description = Set(description);
        active.updated_at = Set(Utc::now().into());

        let updated = active.update(db).await?;
        Ok(updated)
    }

    pub async fn delete(
        db: &DatabaseConnection,
        id: i32,
    ) -> Result<()> {
        memos::Entity::delete_by_id(id).exec(db).await?;
        Ok(())
    }
}
