# Base image: PHP 8.2 with Apache
FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    netcat-openbsd \
    vim \
    libapache2-mod-security2 \
    supervisor \
    libpq-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    && a2enmod rewrite \
    && a2enmod headers \
    && a2enmod security2 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure mod_security
RUN if [ -f /etc/modsecurity/modsecurity.conf-recommended ]; then \
      cp /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf; \
    fi

# Install modsecurity-crs (Core Rule Set)
RUN rm -rf /usr/share/modsecurity-crs \
    && git clone https://github.com/coreruleset/coreruleset /usr/share/modsecurity-crs \
    && cp /usr/share/modsecurity-crs/crs-setup.conf.example /usr/share/modsecurity-crs/crs-setup.conf

# Auto-update script for CRS
RUN echo '#!/bin/bash\nwhile true; do\n  cd /usr/share/modsecurity-crs && git pull\n  sleep 86400\ndone' > /auto_update_crs.sh \
    && chmod +x /auto_update_crs.sh

# Enable mod_security CRS in Apache
RUN echo "IncludeOptional /usr/share/modsecurity-crs/crs-setup.conf" > /etc/apache2/conf-available/modsecurity-crs.conf \
    && echo "IncludeOptional /usr/share/modsecurity-crs/rules/*.conf" >> /etc/apache2/conf-available/modsecurity-crs.conf \
    && a2enconf modsecurity-crs

# Add shell aliases
RUN echo "alias ll='ls -alF'" >> ~/.bashrc

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create and set permissions for Laravel directories
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy application code
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port
EXPOSE 80

# Add entrypoint script
COPY php/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Use entrypoint
ENTRYPOINT ["entrypoint.sh"]

# Start Apache
CMD ["apache2-foreground"]
