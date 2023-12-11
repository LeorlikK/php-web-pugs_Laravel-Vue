FROM php:8.2-rc-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip unzip \
    cron \
    supervisor \
    git \
    build-essential \
    locales \
    libonig-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    vim \
    procps \
    net-tools && \
    docker-php-ext-install pdo_mysql bcmath gd zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
# Install npm
RUN apt-get install -y npm

# Cron
RUN echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run > /var/www/cron.log 2>&1" > /etc/cron.d/crontab && \
  chmod 0644 /etc/cron.d/crontab && \
  crontab -u root /etc/cron.d/crontab

#EXPOSE 9000
#CMD bash -c "cron && php-fpm"

# Supervisor
RUN mkdir -p "/etc/supervisor/logs"
COPY ./_docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
CMD ["/usr/bin/supervisord"]

WORKDIR /var/www
