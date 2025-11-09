FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libmemcached-dev \
    libssl-dev \
    pkg-config \
    librabbitmq-dev \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl pdo_mysql mbstring zip bcmath gd opcache \
    && pecl install redis \
    && pecl install memcached \
    && docker-php-ext-enable redis memcached \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www/html

# Opcache recommended settings & general PHP tweaks
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy supervisor config
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
