# Production Deployment Guide

## Güvenlik Kontrol Listesi

### 1. Environment Variables (.env)

```env
APP_NAME="MailTracker"
APP_ENV=production
APP_KEY=base64:... (php artisan key:generate ile oluşturulmalı)
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_tracker
DB_USERNAME=your_username
DB_PASSWORD=strong_password_here

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

LOG_CHANNEL=daily
LOG_LEVEL=error
LOG_DEPRECATIONS_CHANNEL=null

CACHE_STORE=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Güvenlik Ayarları

#### a) .env Dosyası
- `APP_DEBUG=false` olmalı
- `APP_ENV=production` olmalı
- Güçlü `APP_KEY` oluşturulmalı
- Veritabanı şifreleri güçlü olmalı

#### b) Dosya İzinleri
```bash
# Storage ve cache klasörlerine yazma izni
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### c) .env Dosyası Güvenliği
- `.env` dosyası `.gitignore`'da olmalı
- Production sunucuda `.env` dosyası sadece owner tarafından okunabilir olmalı: `chmod 600 .env`

### 3. Optimizasyonlar

```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Event cache
php artisan event:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Asset build (production)
npm run build
```

### 4. Veritabanı

```bash
# Migration'ları çalıştır
php artisan migrate --force

# Index'leri kontrol et (events tablosunda opened_at ve campaign_id için)
```

### 5. Web Server Yapılandırması

#### Nginx Örnek Yapılandırması

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com;

    root /var/www/mail-tracker/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
}
```

### 6. Monitoring ve Logging

- Log dosyalarını düzenli kontrol edin: `storage/logs/`
- Laravel Horizon veya Queue Worker'ları çalıştırın
- Uptime monitoring kullanın
- Error tracking (Sentry, Bugsnag vb.) ekleyin

### 7. Backup Stratejisi

- Veritabanı yedekleri: Günlük otomatik backup
- Dosya yedekleri: Storage klasörü için backup
- Backup'ları farklı bir lokasyonda saklayın

### 8. Rate Limiting

Rate limiting zaten route'larda tanımlı:
- Tracking endpoint: 100 istek/dakika
- Auth endpoint'ler: 6 istek/dakika
- Diğer endpoint'ler: 60 istek/dakika

### 9. Güvenlik Testleri

```bash
# Test'leri çalıştır
php artisan test

# Güvenlik açıklarını kontrol et
composer require --dev roave/security-advisories:dev-latest
```

### 10. SSL/TLS

- Let's Encrypt ile ücretsiz SSL sertifikası alın
- HTTPS zorunlu yapın
- HSTS header'ı aktif (SecurityHeaders middleware'de)

### 11. Firewall

- Sadece gerekli portları açın (80, 443, 22)
- Fail2ban kurun ve yapılandırın
- SSH key-based authentication kullanın

### 12. Güncellemeler

- Laravel ve paket güncellemelerini düzenli yapın
- Güvenlik yamalarını hemen uygulayın
- `composer audit` ile güvenlik açıklarını kontrol edin



