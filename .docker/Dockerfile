FROM felipe89/php:7.4-php-2.0.7-composer AS builder

WORKDIR /var/www/html

COPY ./ /var/www/html

RUN composer install --no-dev \
    && php artisan storage:link

FROM php:7.4-apache
ARG VERSION=0.0.0

ENV VERSION=$VERSION
ENV PHPRC /usr/local/etc/php/php.ini

WORKDIR /var/www/html

COPY .docker/php.ini ${PHPRC}
COPY .docker/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY --from=builder /var/www/html/app /var/www/html/app
COPY --from=builder /var/www/html/bootstrap /var/www/html/bootstrap
COPY --from=builder /var/www/html/config /var/www/html/config
COPY --from=builder /var/www/html/database /var/www/html/database
COPY --from=builder /var/www/html/public /var/www/html/public
COPY --from=builder /var/www/html/resources /var/www/html/resources
COPY --from=builder /var/www/html/routes /var/www/html/routes
COPY --from=builder /var/www/html/storage /var/www/html/storage
COPY --from=builder /var/www/html/vendor /var/www/html/vendor
COPY --from=builder /var/www/html/server.php /var/www/html/server.php

RUN chown -R www-data:www-data /var/www/html

RUN apt-get update \
    && apt-get install -y libonig-dev libxml2-dev libzip-dev zip php-gd libpng-dev \
    && rm -rf /var/lib/apt/lists/* \
    && a2enmod rewrite \
    && docker-php-ext-install bcmath ctype fileinfo json mbstring pdo pdo_mysql mysqli tokenizer xml soap zip gd
