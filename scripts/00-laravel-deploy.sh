echo "Running composer"
composer self-update --2
composer global require hirak/prestissimo
composer install --working-dir=/var/www/html

# 安裝 Node.js 和 npm
curl -fsSL https://deb.nodesource.com/setup_14.x | sudo -E bash -
sudo apt-get install -y nodejs

# 設定 npm 的 PATH
export PATH="$PATH:/path/to/npm"

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running npm install and npm run build..."
npm install
npm run build
