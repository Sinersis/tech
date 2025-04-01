FROM php:8.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update

RUN apt-get install -y libonig-dev  \
    libbz2-dev  \
    libmcrypt-dev  \
    zlib1g-dev  \
    libpng-dev  \
    libxml2-dev  \
    libjpeg-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libcurl4-openssl-dev \
    libzip-dev

RUN docker-php-ext-install mbstring  \
    bcmath  \
    bz2  \
    calendar  \
    exif  \
    gd  \
    ctype  \
    curl  \
    dom  \
    fileinfo  \
    pdo  \
    xml \
    sockets \
    pdo_mysql \
    zip \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis


# Очистка
RUN docker-php-source delete; \
    apt-get remove -y autoconf build-essential linux-headers-amd64 && apt-get autoremove -y \
    && rm -rf /tmp/* /var/lib/apt/lists/* /var/cache/apt/* /var/www/html/*


WORKDIR /var/www

CMD ["/bin/sh", "-c", "chmod +x ./docker/entrypoint.sh && sh ./docker/entrypoint.sh"]


