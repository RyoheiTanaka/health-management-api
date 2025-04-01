# 🏥 健康管理ウェブアプリ - バックエンド

## 📌 概要

このリポジトリは、健康管理ウェブアプリのバックエンドのソースコードです。
ユーザーの健康データを管理し、分析するための API を提供します。

🔗 **フロントエンドリポジトリ:** [https://github.com/RyoheiTanaka/health-management-frontend](https://github.com/RyoheiTanaka/health-management-frontend)

---

## 🛠 技術スタック

-   **フレームワーク:** Laravel 12
-   **データベース:** PostgreSQL
-   **認証:** Laravel Sanctum
-   **API 設計:** RESTful API
-   **デプロイ:** Vercel

---

## API仕様書

https://ryoheitanaka.github.io/health-management-api-openapi/

---

## 🔧 Docker 環境のセットアップ

このプロジェクトでは、Docker を利用した開発環境を提供しています。以下の手順で環境を起動できます。

### 前提条件

-   Docker がインストールされていること
-   Docker Compose がインストールされていること

### Docker 環境の起動

プロジェクトのルートディレクトリで、以下のコマンドを実行します。

```bash
./docker.sh up
```

必要に応じて、以下のオプションを指定できます。

-   `--build`: コンテナ起動前に Docker イメージをビルドします。
-   `--no-cache`: イメージのビルド時にキャッシュを使用しません。

例：

```bash
./docker.sh up --build
./docker.sh up --no-cache
./docker.sh up --build --no-cache
```

### Docker 環境の停止 (コンテナ削除)

```bash
./docker.sh down
```

### コンテナの停止 (コンテナは残す)

```bash
./docker.sh stop
```

### 環境変数の設定

Docker 環境に必要な環境変数は、`docker/.env` ファイルに記述します。必要に応じて `.env.example` を参考に `.env` ファイルを作成してください。

```
# docker/.env の例
DOCKER_PHP_MEMORY_LIMIT=256M
DOCKER_PHP_XDEBUG_ENABLED=1
# ... 他の環境変数 ...
```

### 注意事項

-   初めて Docker 環境を起動する際は、イメージのダウンロードなどで時間がかかる場合があります。
-   ポートの競合が発生する場合は、`docker/docker-compose.yml` の `ports` 設定を見直してください。

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
