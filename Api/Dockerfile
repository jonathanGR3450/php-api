# Utilizamos una imagen de Apache con PHP
FROM php:8.1.0-apache

# Instalamos los módulos necesarios de PHP
RUN docker-php-ext-install mysqli pdo_mysql

# Copiamos el código fuente de nuestra aplicación al directorio de trabajo
COPY ./ /var/www/html/

# Configuramos el servidor Apache
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Exponemos el puerto 80
EXPOSE 80

# Indicamos que se debe ejecutar el archivo de inicio de Apache
CMD ["apache2-foreground"]
