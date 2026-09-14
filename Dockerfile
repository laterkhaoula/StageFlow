FROM php:8.3-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Performance docker-dev (Windows bind mount) : activer OPcache CLI sans
# revalidation de timestamps (voir docker/opcache.ini pour les détails).
COPY docker/opcache.ini /usr/local/etc/php/conf.d/zz-snapbook-opcache.ini

COPY . .

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]