#<<<<<<<<<<Start: wodby/drupal-php Image Target>>>>>>>>>>#
FROM php:8.1-fpm-alpine as php

ARG GIT_TOKEN

RUN addgroup -g 1000 -S adimeo
RUN adduser -u 1000 -S adimeo -G adimeo

RUN apk update
RUN apk add vim nodejs npm curl git

# Installing and enabling required PHP extension
RUN docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-enable pdo_mysql

RUN apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} gd && \
    apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN apk add --update autoconf g++ make imagemagick-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir /srv/app/
RUN chown -Rf adimeo:adimeo /srv/app/

WORKDIR /srv/app/

RUN mkdir -p /etc/periodic/2min

COPY ./.docker/all/crons/2min/* /etc/periodic/2min

COPY ./.docker/all/crons/startup.sh /usr/local/startup.sh

RUN /usr/local/startup.sh

USER adimeo

COPY --chown=adimeo:adimeo ./composer.json ./composer.lock* /srv/app/

RUN COMPOSER_AUTH="{\"github-oauth\": {\"github.com\": \"${GIT_TOKEN}\"}}" composer install --no-dev

COPY --chown=adimeo:adimeo . /srv/app/

RUN mkdir /srv/app/web/sites/default/files

#<<<<<<<<<<End: wodby/drupal-php Image Target>>>>>>>>>>#

#<<<<<<<<<<Start: Server Image Target>>>>>>>>>>#
FROM nginx:1.21 as server

COPY .docker/all/nginx/server.conf /etc/nginx/conf.d/default.conf

COPY --from=php /srv/app/web /srv/app/web
#<<<<<<<<<<End: Server Image Target>>>>>>>>>>#
