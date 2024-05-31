FROM php:8.0-apache
RUN docker-php-ext-install mysqli

COPY ./php /var/www/html/


RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/
