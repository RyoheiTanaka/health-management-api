#!/bin/bash

echo "🔧 Generating .env.testing..."

cat > .env.testing <<EOL
APP_ENV=testing
APP_KEY=$(php artisan key:generate --show)
APP_DEBUG=true
DB_CONNECTION=sqlite
DB_DATABASE=$(pwd)/database/database.sqlite
CACHE_STORE=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=array
AWS_LAMBDA_REQUEST_HEADER=aws_lambda_request_header
EOL

echo "✅ .env.testing created!"
