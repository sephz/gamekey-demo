# syntax=docker/dockerfile:1
FROM xbbshampoo/laravel-php-81-apache:latest as base

# setup basic WORK DIRECTORY
WORKDIR /app

ARG APP_USER=1000
ARG APP_GROUP=1000
ARG CURRENT_ENVIRONMENT=development

# update document root and setup os permissions
ENV APACHE_DOCUMENT_ROOT=/app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite headers && \
    usermod -u ${APP_USER} www-data && groupmod -g ${APP_GROUP} www-data

# copy app
COPY --chown=www-data:www-data . /app

# setup folder permissions
RUN mkdir .composer && \
    chown -R www-data:www-data .composer && \
    chmod -R 755 /app/storage

FROM base as development
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY php-conf/development.ini /usr/local/etc/php/conf.d/

# set default user when running exec into container
USER www-data

FROM base as production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# set default user when running exec into container
USER www-data

RUN composer install --optimize-autoloader --no-dev
