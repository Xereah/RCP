# ================================
#  Stage 1 — PHP base with extensions
# ================================
FROM php:8.4-apache-bookworm AS php-base

ENV DEBIAN_FRONTEND=noninteractive \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# --- SQLSRV (corrected for Debian 12 / PHP 8.4) ---
    RUN apt-get update && apt-get install -y \
    gnupg2 \
    unixodbc \
    unixodbc-dev \
    curl \
    apt-transport-https && \
    mkdir -p /etc/apt/keyrings && \
    curl -fsSL https://packages.microsoft.com/keys/microsoft.asc \
        | gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg && \
    echo "deb [signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
        > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && \
    ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools unixodbc-dev && \
    pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*



# ================================
#  Stage 2 — Composer
# ================================
FROM composer:latest AS composer-builder

WORKDIR /app

# Kopiujemy cały projekt
COPY . .

# Instalacja vendorów produkcyjnych
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader



# ================================
#  Stage 3 — Node builder for Vite/Tailwind
# ================================
FROM node:20 AS node-builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# ================================
#  Stage 4 — Final production image
# ================================
FROM php-base AS final

# Enable Apache modules
RUN a2enmod rewrite headers expires deflate ssl

# Set Laravel as Apache DocumentRoot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy Apache SSL configuration
COPY docker/apache/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN a2ensite default-ssl

# Copy PHP configuration
COPY docker/php/php-custom.ini /usr/local/etc/php/conf.d/php-custom.ini

# Copy application files
WORKDIR /var/www/html
COPY . .

# Copy production vendor from composer stage
COPY --from=composer-builder /app/vendor ./vendor

# Copy Vite/Tailwind build
COPY --from=node-builder /app/public/build ./public/build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy and prepare startup script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
