FROM node:latest AS node
FROM dunglas/frankenphp:1.4

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip \
    librabbitmq-dev \
    libpq-dev \
    supervisor

RUN install-php-extensions \
    gd \
    pcntl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql \
    redis \
    zip

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . .

COPY ./.docker/php/php.ini /usr/local/etc/php/
COPY ./.docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./.docker/supervisor/supervisord.prod.conf /etc/supervisor/conf.d/supervisord.prod.conf

RUN chown -R www-data:www-data storage bootstrap/cache
