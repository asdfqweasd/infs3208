FROM php:7.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN pecl install igbinary \
	&& pecl install redis \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable redis \
	&& echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini