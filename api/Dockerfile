FROM php:8.2-cli
RUN apt-get update && apt-get install -y zip unzip git libzip-dev && docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html
COPY . .
RUN php -r "copy('https://getcomposer.org/installer','composer-setup.php');" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && composer install --no-interaction
