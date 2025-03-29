#!/bin/bash

service cron start

# Xdebug 有効/無効の制御
if [ "$DOCKER_PHP_XDEBUG_ENABLED" = "1" ]; then
  echo "Enabling Xdebug"
  docker-php-ext-enable xdebug
else
  echo "Disabling Xdebug"
  docker-php-ext-disable xdebug
fi

# PHP設定
if [ -n "$DOCKER_PHP_MEMORY_LIMIT" ]; then
  echo "Setting PHP memory_limit to ${DOCKER_PHP_MEMORY_LIMIT}"
  sed -i "s/^memory_limit = .*/memory_limit = ${DOCKER_PHP_MEMORY_LIMIT}/" /usr/local/etc/php/php.ini
fi

if [ -n "$DOCKER_PHP_UPLOAD_MAX_FILESIZE" ]; then
  echo "Setting PHP upload_max_filesize to ${DOCKER_PHP_UPLOAD_MAX_FILESIZE}"
  sed -i "s/^upload_max_filesize = .*/upload_max_filesize = ${DOCKER_PHP_UPLOAD_MAX_FILESIZE}/" /usr/local/etc/php/php.ini
fi

if [ -n "$DOCKER_PHP_POST_SIZE" ]; then
  echo "Setting PHP post_max_size to ${DOCKER_PHP_POST_SIZE}"
  sed -i "s/^post_max_size = .*/post_max_size = ${DOCKER_PHP_POST_SIZE}/" /usr/local/etc/php/php.ini
fi

if [ -n "$DOCKER_PHP_MAX_EXECUTION_TIME" ]; then
  echo "Setting PHP max_execution_time to ${DOCKER_PHP_MAX_EXECUTION_TIME}"
  sed -i "s/^max_execution_time = .*/max_execution_time = ${DOCKER_PHP_MAX_EXECUTION_TIME}/" /usr/local/etc/php/php.ini
fi

if [ -n "$DOCKER_PHP_DISPLAY_ERRORS" ]; then
  echo "Setting PHP display_errors to ${DOCKER_PHP_DISPLAY_ERRORS}"
  sed -i "s/^display_errors = .*/display_errors = ${DOCKER_PHP_DISPLAY_ERRORS}/" /usr/local/etc/php/php.ini
fi

# Xdebug設定 (Xdebugが有効な場合のみ設定を適用)
if [ "$DOCKER_PHP_XDEBUG_ENABLED" = "1" ]; then
  if [ -n "$DOCKER_PHP_XDEBUG_MODE" ]; then
    echo "Setting Xdebug mode to ${DOCKER_PHP_XDEBUG_MODE}"
    sed -i "s/^xdebug.mode=.*/xdebug.mode=${DOCKER_PHP_XDEBUG_MODE}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi

  if [ -n "$DOCKER_PHP_XDEBUG_START_WITH_REQUEST" ]; then
    echo "Setting Xdebug start_with_request to ${DOCKER_PHP_XDEBUG_START_WITH_REQUEST}"
    sed -i "s/^xdebug.start_with_request=.*/xdebug.start_with_request=${DOCKER_PHP_XDEBUG_START_WITH_REQUEST}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi

  if [ -n "$DOCKER_PHP_CLIENT_HOST" ]; then
    echo "Setting Xdebug client_host to ${DOCKER_PHP_CLIENT_HOST}"
    sed -i "s/^xdebug.client_host=.*/xdebug.client_host=${DOCKER_PHP_CLIENT_HOST}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi

  if [ -n "$DOCKER_PHP_CLIENT_PORT" ]; then
    echo "Setting Xdebug client_port to ${DOCKER_PHP_CLIENT_PORT}"
    sed -i "s/^xdebug.client_port=.*/xdebug.client_port=${DOCKER_PHP_CLIENT_PORT}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi
fi

exec php-fpm
