# Seleccionar una imagen base
FROM php:8.0.30-apache

# Instalar el controlador PDO para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar módulo de redirección web
RUN a2enmod rewrite