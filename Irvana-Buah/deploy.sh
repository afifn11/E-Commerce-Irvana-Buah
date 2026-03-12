#!/bin/bash
# Deploy script untuk Irvana Buah
# Jalankan SEKALI saat pertama upload ke server

echo "=== Irvana Buah Deploy Script ==="

# 1. Install dependencies (tanpa dev)
echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

# 2. Build frontend assets
echo "Building frontend assets..."
npm ci && npm run build

# 3. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 4. Storage link
echo "Creating storage link..."
php artisan storage:link

# 5. Cache untuk production
echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo ""
echo "=== Deploy selesai! ==="
echo "Jangan lupa:"
echo "1. Copy .env.production-template ke .env dan isi nilai yang benar"
echo "2. Ganti DOMAIN-KAMU.COM di .env"
echo "3. Ganti MIDTRANS ke production key"
echo "4. Update GOOGLE_REDIRECT_URI di Google Console"
