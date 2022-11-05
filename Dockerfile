FROM php:8.1-apache
WORKDIR /app
EXPOSE 80
RUN apt-get update -y && apt-get install -y zip unzip libxml2-dev curl nano libpng-dev libzip-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql gd zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
COPY server-apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /app
COPY php.ini "$PHP_INI_DIR/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite