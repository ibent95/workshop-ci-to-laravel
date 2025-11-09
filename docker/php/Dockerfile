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

# PHP-FPM pool config: change listen from 127.0.0.1 to 0.0.0.0 for Docker network access
RUN sed -i 's/^listen = 127\.0\.0\.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf \
    && grep "^listen" /usr/local/etc/php-fpm.d/www.conf

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Create supervisor log directory
RUN mkdir -p /var/log/supervisor

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
