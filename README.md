# 🏥 健康管理ウェブアプリ - バックエンド

## 📌 概要

このリポジトリは、健康管理ウェブアプリのバックエンドのソースコードです。
ユーザーの健康データを管理し、分析するための API を提供します。

🔗 **フロントエンドリポジトリ:** [https://github.com/RyoheiTanaka/health-management-frontend](https://github.com/RyoheiTanaka/health-management-frontend)

---

## 🛠 技術スタック

-   **フレームワーク:** Laravel 11
-   **データベース:** PostgreSQL
-   **認証:** Laravel Sanctum
-   **API 設計:** RESTful API
-   **デプロイ:** Vercel

---

## 📂 機能一覧

-   📊 **健康データ管理:** 体重・体脂肪率・睡眠記録の登録・更新
-   📅 **データ分析:** 期間ごとの健康データの情報取得
-   🔑 **認証・認可:** フロントエンドからは SPA 認証、Lamda からは API 認証（Sanctum）

---

## 🛡 セキュリティ対策

-   **環境変数の管理:** `.env` ファイルを `.gitignore` に追加
-   **SPA 認証:** Laravel Sanctum を使用した SPA 認証
-   **API 認証:** Laravel Sanctum を使用したトークン認証、独自の暗号化処理追加
-   **CORS 設定:** `config/cors.php` で適切なオリジン設定

---

## 📝 ライセンス

このプロジェクトのソースコードの **改変・複製・再配布を禁止** します。
詳細は [`LICENSE`](./LICENSE) をご覧ください。

---

## 📬 お問い合わせ

何か質問があれば、お気軽にご連絡ください！

📧 **Email:** ryohei.tanaka@coolat.net

---

🚀 **ご覧いただき、ありがとうございます！** 🙌
