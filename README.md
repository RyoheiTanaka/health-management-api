# 健康管理アプリ - バックエンド（Laravel API）

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-blue?logo=postgresql)
![Sanctum](https://img.shields.io/badge/Auth-Sanctum-orange)
![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)

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
