#!/bin/sh

# cronをバックグラウンドで起動
service cron start

# php-fpmをフォアグラウンドで起動
php-fpm
