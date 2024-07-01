FROM php:8.2-fpm
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update -q && \
    apt-get install -qy \
        libzip-dev \
        git \
        unzip \
        postgresql \
        postgresql-client \
        cron

# Install Nginx and necessary libraries
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    postgresql-client

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy Nginx configuration
COPY ./docker/nginx/nginx.conf /etc/nginx/sites-available/default

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . .

# Copy the cron job file
COPY ./docker/cronjob /etc/cron.d/laravel-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply cron job
RUN crontab /etc/cron.d/laravel-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Install dependencies with Composer
RUN composer install

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service nginx start && cron && php-fpm
