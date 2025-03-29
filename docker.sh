#!/bin/bash

set -e

COMPOSE_FILE='docker/docker-compose.yml'
ENV_FILE='docker/.env'

usage() {
  echo "Usage: $0 {up|down|stop} [options]"
  echo ""
  echo "Options for 'up':"
  echo "  --build       Build images before starting containers."
  echo "  --no-cache    Do not use cache when building images."
  echo ""
  echo "Options for 'down' and 'stop':"
  echo "  (No specific options implemented yet)"
  exit 1
}

if [ -z "$1" ]; then
  usage
fi

COMMAND="$1"
shift # Remove the command from the arguments

DOCKER_COMPOSE_OPTIONS="--env-file $ENV_FILE -f $COMPOSE_FILE"

case "$COMMAND" in
  up)
    echo "Starting Docker environment..."
    BUILD_FLAG=false
    NO_CACHE_FLAG=false
    while [ "$#" -gt 0 ]; do
      case "$1" in
        --build)
          BUILD_FLAG=true
          ;;
        --no-cache)
          NO_CACHE_FLAG=true
          ;;
        *)
          echo "Unknown option: $1"
          usage
          ;;
      esac
      shift
    done

    if $BUILD_FLAG || $NO_CACHE_FLAG; then
      echo "Building images..."
      BUILD_COMMAND="build"
      if $NO_CACHE_FLAG; then
        BUILD_COMMAND="$BUILD_COMMAND --no-cache"
      fi
      docker-compose $DOCKER_COMPOSE_OPTIONS $BUILD_COMMAND
    fi

    docker-compose $DOCKER_COMPOSE_OPTIONS up -d
    echo "Docker environment started."
    ;;
  down)
    echo "Stopping Docker environment..."
    docker-compose $DOCKER_COMPOSE_OPTIONS down
    echo "Docker environment stopped."
    ;;
  stop)
    echo "Stopping Docker containers..."
    docker-compose $DOCKER_COMPOSE_OPTIONS stop
    echo "Docker containers stopped."
    ;;
  *)
    usage
    ;;
esac

exit 0
