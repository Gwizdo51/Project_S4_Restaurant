# start from the official php apache image
FROM php:8.3-apache AS apache_server_img
# set php engine in development mode
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
# add mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# activate the rewrite mod
RUN a2enmod rewrite
# copy the apache2.conf
RUN rm /etc/apache2/apache2.conf
COPY ./apache2.conf /etc/apache2
# mount a volume at /var/www/html
VOLUME /var/www/html
# expose SSH port
EXPOSE 80
