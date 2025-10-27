#!/bin/sh

set -ex

php artisan optimize

frankenphp run -c /etc/frankenphp/Caddyfile
