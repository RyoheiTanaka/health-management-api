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
EOL

echo "✅ .env.testing created!"
