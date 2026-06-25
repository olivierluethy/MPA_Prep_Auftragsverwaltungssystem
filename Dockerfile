# PHP 8.2 with Apache – matches the original project (plain PHP MVC, PDO + mysqli).
FROM php:8.2-apache

# MySQL drivers used by the app:
#   - pdo_mysql  -> core/database.php (PDO)
#   - mysqli     -> app/Views/config.php (login / register)
RUN docker-php-ext-install pdo_mysql mysqli \
    && a2enmod rewrite

# Apache virtual host (serves the project under /Mini-PA-Prep and allows .htaccess)
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Bake the source into the image so it also runs without a bind mount.
# (docker-compose additionally mounts the source for live editing.)
COPY . /var/www/html/Mini-PA-Prep
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
