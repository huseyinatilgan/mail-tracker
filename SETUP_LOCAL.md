# Local Kurulum Rehberi

## Gereksinimler

- PHP 8.2+ ✅ (PHP 8.4.8 yüklü)
- Composer (yüklenecek)
- MySQL 8.0+ (MySQL Workbench ile yüklü)
- Node.js ve npm

## Kurulum Adımları

### 1. Composer Kurulumu

Composer yüklü değil. Aşağıdaki komutla yükleyin:

```bash
# macOS için
brew install composer

# veya global olarak
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Veritabanı Oluşturma

MySQL Workbench'te veya terminal'de:

```sql
CREATE DATABASE IF NOT EXISTS mail_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Veya MySQL Workbench'te:
1. MySQL Workbench'i açın
2. Yeni bir connection oluşturun (localhost, root, şifre: root)
3. SQL Editor'de şu komutu çalıştırın:
   ```sql
   CREATE DATABASE mail_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### 3. .env Dosyası Yapılandırması

`.env` dosyası oluşturuldu. Eğer MySQL bağlantı sorunu varsa, MySQL Workbench'teki connection bilgilerini kontrol edin:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_tracker
DB_USERNAME=root
DB_PASSWORD=root
```

Eğer MySQL Workbench farklı bir port kullanıyorsa (örneğin 3307), `DB_PORT` değerini güncelleyin.

### 4. Bağımlılıkları Yükleme

```bash
# PHP bağımlılıkları
composer install

# Node.js bağımlılıkları
npm install
```

### 5. Application Key Oluşturma

```bash
php artisan key:generate
```

### 6. Migration'ları Çalıştırma

```bash
php artisan migrate
```

### 7. Development Server'ı Başlatma

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (asset'ler için)
npm run dev
```

Tarayıcıda `http://localhost:8000` adresine gidin.

## Hızlı Başlangıç (Tüm Komutlar)

```bash
# 1. Composer yükle (eğer yoksa)
brew install composer

# 2. Bağımlılıkları yükle
composer install
npm install

# 3. .env dosyasını kontrol et (zaten oluşturuldu)
# MySQL bağlantı bilgilerini kontrol edin

# 4. Application key
php artisan key:generate

# 5. Migration'lar
php artisan migrate

# 6. Server'ları başlat
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
```

## Sorun Giderme

### MySQL Bağlantı Hatası

Eğer MySQL bağlantı hatası alıyorsanız:

1. MySQL servisinin çalıştığından emin olun:
   ```bash
   # macOS için
   brew services list | grep mysql
   # veya
   sudo /usr/local/mysql/support-files/mysql.server start
   ```

2. MySQL Workbench'te connection bilgilerini kontrol edin
3. `.env` dosyasındaki `DB_HOST` ve `DB_PORT` değerlerini güncelleyin

### Composer Bulunamadı

Composer yüklü değilse:
```bash
brew install composer
```

### Port Zaten Kullanılıyor

Eğer 8000 portu kullanılıyorsa:
```bash
php artisan serve --port=8001
```

## İlk Kullanıcı Oluşturma

1. Tarayıcıda `http://localhost:8000/register` adresine gidin
2. Yeni bir kullanıcı oluşturun
3. Email doğrulama gerekebilir (local'de genellikle atlanabilir)

## Test Kullanıcısı Oluşturma (Opsiyonel)

Eğer test için hızlıca kullanıcı oluşturmak isterseniz:

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
```

