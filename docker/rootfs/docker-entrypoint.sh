#!/bin/sh

set -ex

php artisan optimize

exec "$@"
