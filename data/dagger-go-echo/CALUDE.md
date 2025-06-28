# claude.md

## 作って欲しいもの
Go で dagger を使ってサンプルアプリ

## 機能
サンプルアプリだからミニマムに。

- mysql へ sqlc で select 文を投げる
- echo では、リストを返すのみ。
  - http://localhost:8080/ で tasks のリストだけ。JSON 形式

## テーブル設計
tasks テーブル

- id primary 連番
- title text
- description text
- created_at datetime
- updated_at datetime

## 特徴
dagger に各種スクリプトをまとめて欲しい。タスクランナーとして使いたい。

- マイグレーション
- テスト
- docker build
- ecr への push
