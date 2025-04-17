# 健康管理アプリ - バックエンド（Laravel API）

![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-blue?logo=postgresql)
![Sanctum](https://img.shields.io/badge/Auth-Sanctum-orange)  
![Tests by Pest](https://github.com/RyoheiTanaka/health-management-api/actions/workflows/tests.yml/badge.svg?branch=main)

このリポジトリは、**健康管理アプリのバックエンド API** を構成する Laravel アプリケーションです。  
記録対象は「体重・体脂肪率・睡眠時間」。ユーザー認証やデータ管理を担い、フロントエンドアプリと API を通じて連携します。

---

## 🌐 公開情報

-   フロントエンド：  
    👉 [health-management-frontend](https://github.com/RyoheiTanaka/health-management-frontend)

-   API 仕様書（Swagger UI）：  
    👉 [https://docs-health-management.coolat.net/](https://docs-health-management.coolat.net/)

-   デモアプリ（Vercel + Supabase）：  
    👉 https://health-management.coolat.net

---

## 🛠 使用技術スタック

-   **Laravel 12**
-   **PHP 8.2**
-   **PostgreSQL**
-   **Laravel Sanctum**（SPA 認証）
-   **Supabase**（本番データベース環境）
-   **Vercel**（フロントと合わせて運用）

---

## 💡 設計・構築のポイント

-   SPA 対応：Sanctum による Cookie ベースの認証
-   RESTful 設計：リソース指向でわかりやすい API 設計
-   環境変数によりローカルと本番（Supabase）を切り替え可能
-   データベースは PostgreSQL を使用（マイグレーション対応済）

---

## ▶️ ローカル開発手順

```bash
git clone https://github.com/RyoheiTanaka/health-management-api.git
cd health-management-api

cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

.env にて DB 接続情報、CORS ドメイン、フロントエンド URL などの設定が必要です。
Supabase を使用する場合は .env.production 等で環境ごとに切り替えてください。

---

## 🧪 テストの実行方法

### ローカルで実行する場合

まずはテスト環境用の `.env.testing` を生成します：

```bash
./scripts/generate-env.sh
```

> `generate-env.sh` は、テスト用に必要な最小限の `.env.testing` を自動生成するスクリプトです。  
> Git 管理はされておらず、**ローカル専用の一時ファイル**として扱うことを想定しています。

スクリプトの中では以下のような設定を行っています：

-   `APP_ENV=testing`
-   `APP_KEY` を自動生成
-   `DB_CONNECTION=sqlite`（ローカル DB）
-   その他 `CACHE_STORE=array` など CI と同様の構成を再現

```bash
# scripts/generate-env.sh の一部
APP_ENV=testing
APP_KEY=$(php artisan key:generate --show)
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
...
```

その後、以下のコマンドでテストを実行します：

```bash
composer test
```

> ※ `composer test` は `php artisan test --env=testing` を実行します  
> ※ テストコード内で `uses(RefreshDatabase::class);` を使用しているため、マイグレーションは自動で行われます

---

### GitHub Actions による CI テスト

このリポジトリでは、`main` ブランチへの push / pull request 時に、CI で自動的にテストが実行されます。

CI では `generate-env.sh` を利用して `.env.testing` を生成し、  
SQLite のインメモリ DB を使って高速にテストを実行しています。

---

## 📄 ライセンス

MIT License
Copyright (c) 2024 Ryohei Tanaka

このソフトウェアは [`MITライセンス`](./LICENSE) に基づき公開されています。
商用・個人利用・改変・再配布すべて自由ですが、著作権表記は保持してください。

---

## 👤 開発者

-   **田中 涼平**（[@RyoheiTanaka](https://github.com/RyoheiTanaka)）
-   Email: [ryohei.tanaka@coolat.net](mailto:ryohei.tanaka@coolat.net)

ご利用いただきありがとうございます 🙌
