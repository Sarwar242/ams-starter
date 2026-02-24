#!/bin/bash

# Wait for MariaDB to be ready
echo "Waiting for MariaDB to be ready..."
while ! nc -z ${DB_HOST:-mariadb} ${DB_PORT:-3306}; do
  sleep 1
done
echo "MariaDB is ready!"

# Install Composer dependencies if vendor doesn't exist
if [ ! -d "vendor" ]; then
  echo "Installing Composer dependencies..."
  composer install --optimize-autoloader --no-dev
fi

# Copy .env file if it doesn't exist
if [ ! -f ".env" ]; then
  echo "Creating .env file..."
  cp .env.example .env
  php artisan key:generate
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Setup complete!"

# Execute the main command
exec "$@"
