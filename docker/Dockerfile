FROM dunglas/frankenphp:php8.4-alpine AS build

RUN apk add --no-cache \
        bash \
        curl

WORKDIR /src

RUN wget https://github.com/composer/composer/releases/latest/download/composer.phar -O composer && \
    curl -fsSL https://bun.sh/install | BUN_INSTALL=/usr/local bash

COPY . .

RUN php composer install --ignore-platform-reqs
RUN bun install --frozen-lockfile

RUN bun run build:ssr


FROM dunglas/frankenphp:php8.4-alpine

RUN apk add --no-cache \
        git \
    && \
    install-php-extensions \
        pgsql \
        pdo_pgsql \
        redis \
        opcache \
        pcntl \
    && \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo "upload_max_filesize = 512M" >> "$PHP_INI_DIR/conf.d/upload_max_filesize.ini" && \
    echo "post_max_size = 1024M" >> "$PHP_INI_DIR/conf.d/upload_max_filesize.ini" && \
    addgroup -g 1001 bentobox && \
    adduser -D -h /app -u 1001 -G bentobox bentobox && \
    chown -R bentobox:bentobox /data/caddy && \
    chown -R bentobox:bentobox /config/caddy && \
    setcap -r /usr/local/bin/frankenphp;

USER bentobox

ENV XDG_CONFIG_HOME="/app/.config"

WORKDIR /app

COPY --chown=bentobox:bentobox --from=build /src/app             ./app
COPY --chown=bentobox:bentobox --from=build /src/bootstrap       ./bootstrap
COPY --chown=bentobox:bentobox --from=build /src/config          ./config
COPY --chown=bentobox:bentobox --from=build /src/database        ./database
COPY --chown=bentobox:bentobox --from=build /src/public          ./public
COPY --chown=bentobox:bentobox --from=build /src/resources/views ./resources/views
COPY --chown=bentobox:bentobox --from=build /src/routes          ./routes
COPY --chown=bentobox:bentobox --from=build /src/storage         ./storage
COPY --chown=bentobox:bentobox --from=build /src/vendor          ./vendor

COPY --chown=bentobox:bentobox --from=build /src/composer.json .
COPY --chown=bentobox:bentobox --from=build /src/composer.lock .
COPY --chown=bentobox:bentobox --from=build /src/artisan .
COPY --chown=bentobox:bentobox --from=build /src/LICENSE .

COPY ./docker/rootfs /

VOLUME [ "/app/storage" ]

EXPOSE 8000

CMD [ "/docker-entrypoint.sh" ]
