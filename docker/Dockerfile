# start from the official php apache image
FROM php:8.3-apache AS apache_server_img
# set php engine in development mode
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
# update apt
RUN apt-get -y update
# add mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# install libicu and add the intl extension (currency formatting)
RUN apt-get install -y libicu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl
# activate the rewrite mod
RUN a2enmod rewrite
# copy the apache2.conf
RUN rm /etc/apache2/apache2.conf
COPY ./apache2.conf /etc/apache2
# mount a volume at /var/www/html
VOLUME /var/www/html
# expose SSH port
EXPOSE 80

# scss compiler
# https://blog.svenar.nl/posts/building_sass_with_docker/
FROM google/dart AS scss_compiler_img
ARG DART_SASS_VERSION=1.89.0
ARG DART_SASS_TAR=dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz
ARG DART_SASS_URL=https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/${DART_SASS_TAR}
ADD ${DART_SASS_URL} /opt/
RUN cd /opt/ && tar -xzf ${DART_SASS_TAR} && rm ${DART_SASS_TAR}
WORKDIR /opt/dart-sass
ENTRYPOINT ["/opt/dart-sass/sass", "/sass:/css"]
