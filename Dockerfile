# Utiliser l'image PHP-FPM
FROM php:8.1-fpm

# Installer les extensions requises pour Laravel et PDO_MySQL
RUN apt-get update && apt-get install -y \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le code source du projet dans le conteneur
COPY . /var/www

# Donner les permissions appropriées
RUN chown -R www-data:www-data /var/www \
    && chmod -R 777 /var/www \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 777 /var/www/storage \
    && chown -R www-data:www-data /var/www/bootstrap/cache \
    && chmod -R 777 /var/www/bootstrap/cache

# Installer les dépendances du projet
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Exposer le port 9000
EXPOSE 9000

# Définir le point d'entrée
CMD ["php-fpm"]
