FROM php:8.2-fpm-alpine3.18

# INSTALL COMPOSER
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apk update
RUN apk upgrade
RUN apk add bash
RUN alias composer='php /usr/bin/composer'

COPY . /var/www/html
WORKDIR /var/www/html

EXPOSE 9000