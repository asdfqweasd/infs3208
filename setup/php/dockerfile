FROM php:7.4-fpm

RUN pecl install igbinary \
	&& pecl install redis \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable redis \
	&& echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini