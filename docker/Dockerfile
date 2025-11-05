ARG PHP_VERSION=8.4

# Install dependencies and compile sources
FROM dunglas/frankenphp:php${PHP_VERSION}-alpine AS build

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

RUN rm -rf node_modules vendor && \
    php composer install --ignore-platform-reqs --no-dev && \
    bun install --frozen-lockfile --production


# Compile supervisor
FROM rust:1.91.0-alpine AS supervisor

RUN apk add --no-cache g++

ADD https://github.com/linkdd/procfusion.git /usr/local/src

WORKDIR /usr/local/src

RUN cargo build --release


# Main stage
FROM dunglas/frankenphp:php${PHP_VERSION}-alpine

ARG BUN_VERSION=1.3.1

RUN apk add --no-cache --virtual .deps \
        bash \
        curl \
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
    curl -fsSL https://bun.com/install | BUN_INSTALL=/usr/local bash -s "bun-v${BUN_VERSION}" && \
    addgroup -g 1001 bentobox && \
    adduser -D -h /app -u 1001 -G bentobox bentobox && \
    chown -R bentobox:bentobox /data/caddy && \
    chown -R bentobox:bentobox /config/caddy && \
    setcap -r /usr/local/bin/frankenphp && \
    apk del .deps

COPY --from=supervisor /usr/local/src/target/release/procfusion /usr/local/bin/procfusion

USER bentobox

ENV XDG_CONFIG_HOME="/app/.config"

WORKDIR /app

COPY --chown=bentobox:bentobox --from=build /src/app             ./app
COPY --chown=bentobox:bentobox --from=build /src/bootstrap       ./bootstrap
COPY --chown=bentobox:bentobox --from=build /src/config          ./config
COPY --chown=bentobox:bentobox --from=build /src/database        ./database
COPY --chown=bentobox:bentobox --from=build /src/node_modules    ./node_modules
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

EXPOSE 1337

ENTRYPOINT [ "/docker-entrypoint.sh" ]
CMD [ "/usr/local/bin/procfusion", "/etc/procfusion/config.toml" ]
