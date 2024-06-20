FROM php:7.4-apache
MAINTAINER milena.silva@viannasempre.com.br
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite