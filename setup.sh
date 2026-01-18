#!/bin/bash

echo "🚀 MailTracker Local Kurulum Başlatılıyor..."
echo ""

# 1. Composer kontrolü
echo "📦 Composer kontrol ediliyor..."
if ! command -v composer &> /dev/null; then
    echo "⚠️  Composer bulunamadı. Yükleniyor..."
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    echo "✅ Composer yüklendi"
else
    echo "✅ Composer zaten yüklü"
fi

# 2. PHP bağımlılıkları
echo ""
echo "📦 PHP bağımlılıkları yükleniyor..."
composer install

# 3. Node.js bağımlılıkları
echo ""
echo "📦 Node.js bağımlılıkları yükleniyor..."
npm install

# 4. .env dosyası kontrolü
echo ""
echo "⚙️  .env dosyası kontrol ediliyor..."
if [ ! -f .env ]; then
    echo "⚠️  .env dosyası bulunamadı, oluşturuluyor..."
    cp .env.example .env
fi

# 5. Application key
echo ""
echo "🔑 Application key oluşturuluyor..."
php artisan key:generate

# 6. Veritabanı kontrolü
echo ""
echo "🗄️  Veritabanı kontrol ediliyor..."
echo "⚠️  Lütfen MySQL Workbench'te 'mail_tracker' veritabanını oluşturun:"
echo "   CREATE DATABASE mail_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo ""
read -p "Veritabanı oluşturuldu mu? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    # 7. Migration'lar
    echo ""
    echo "🔄 Migration'lar çalıştırılıyor..."
    php artisan migrate
    
    echo ""
    echo "✅ Kurulum tamamlandı!"
    echo ""
    echo "🚀 Server'ları başlatmak için:"
    echo "   Terminal 1: php artisan serve"
    echo "   Terminal 2: npm run dev"
    echo ""
    echo "🌐 Tarayıcıda: http://localhost:8000"
else
    echo ""
    echo "⚠️  Migration'lar atlandı. Veritabanını oluşturduktan sonra:"
    echo "   php artisan migrate"
fi



