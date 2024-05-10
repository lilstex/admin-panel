# # PHP image as base
# FROM php:8.2-apache

# # Set the working directory inside the container
# WORKDIR /var/www/html

# # Install system dependencies
# RUN apt-get update && \
#     apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Copy composer.json and composer.lock
# COPY composer.json composer.lock ./

# # Install project dependencies
# RUN composer install --no-scripts --no-autoloader

# # Copy the rest of the application code
# COPY . .

# # Generate autoload files
# RUN composer dump-autoload --no-scripts --no-dev --optimize

# # Set permissions
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Copy entrypoint script
# COPY entrypoint.sh /usr/local/bin/
# RUN chmod +x /usr/local/bin/entrypoint.sh

# # Expose port 8000
# EXPOSE 8000

# # Command to start the server
# CMD ["/usr/local/bin/entrypoint.sh"]


FROM php:8.2-fpm

# Set the working directory inside the container
WORKDIR /var/www/html

RUN apt-get update && apt-get install --fix-missing --quiet --yes \
        --no-install-recommends \
		libzip-dev \
		unzip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && pecl install -o -f redis-5.1.1 \
	&& docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser \
        -G www-data,root --shell /bin/bash \
        --create-home appuser


USER appuser
