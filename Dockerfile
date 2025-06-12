FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    sudo \
    libmagickwand-dev \
    libpng-dev \
    libxml2-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libnss3 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxdamage1 \
    libxfixes3 \
    libxrandr2 \
    libgbm1 \
    nodejs \
    npm \
    gconf-service \
    libasound2 \
    libc6 \
    libcairo2 \
    libcups2 \
    libdbus-1-3 \
    libexpat1 \
    libfontconfig1 \
    libgbm1 \
    libgcc1 \
    libgconf-2-4 \
    libgdk-pixbuf2.0-0 \
    libglib2.0-0 \
    libgtk-3-0 \
    libnspr4 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    libstdc++6 \
    libx11-6 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxext6 \
    libxfixes3 \
    libxi6 \
    libxrandr2 \
    libxrender1 \
    libxss1 \
    libxtst6 \
    ca-certificates \
    fonts-liberation \
    libappindicator1 \
    libnss3 \
    lsb-release \
    xdg-utils \
    wget \
    libgbm-dev \
    libxshmfence-dev \
    supervisor

# Allow $user to run sudo commands without a password
RUN echo "$user ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Install Puppeteer globally
# RUN npm install -g puppeteer

# Install Chrome using Puppeteer
# RUN npx puppeteer browsers install chrome

RUN pecl install imagick

# Install PHP extensions
RUN docker-php-ext-enable imagick
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Copy the Laravel application code into the container
COPY . /var/www

USER $user

# Cron installation and copy backup script
# RUN apt-get update && apt-get install -y cron
# COPY docker-compose/mysql/backup.sh /usr/local/bin/backup.sh

# Sets execution permissions for the backup script
# RUN chmod +x /usr/local/bin/backup.sh

# Adds a cronjob entry to run the backup script every 6 hours
# RUN echo "0 */6 * * * root /usr/local/bin/backup.sh" > /etc/cron.d/backup

# Run composer install if vendor directory doesn't exist, then start PHP-FPM
CMD ["sh", "-c", "if [ ! -d \"vendor\" ]; then echo \"Vendor directory not found. Running composer install...\"; composer install; fi && php artisan config:cache && php-fpm"]
