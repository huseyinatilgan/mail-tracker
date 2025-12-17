# 🚀 MailTracker - Hızlı Başlangıç Rehberi

## ✅ Tamamlanan Adımlar

1. ✅ Composer yüklendi
2. ✅ PHP bağımlılıkları yüklendi (`composer update`)
3. ✅ Node.js bağımlılıkları yüklendi (`npm install`)
4. ✅ `.env` dosyası oluşturuldu ve yapılandırıldı
5. ✅ Application key oluşturuldu

## 📋 Yapılması Gerekenler

### 1. MySQL Workbench'te Veritabanı Oluşturun

**MySQL Workbench'i açın ve şu SQL komutunu çalıştırın:**

```sql
CREATE DATABASE IF NOT EXISTS mail_tracker 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

**Veya MySQL Workbench'te:**
1. MySQL Workbench'i açın
2. Local instance'a bağlanın (root, şifre: root)
3. SQL Editor'de yukarıdaki komutu çalıştırın
4. Execute butonuna tıklayın (⚡)

### 2. Migration'ları Çalıştırın

Terminal'de:

```bash
cd /Users/huseyinatilgan/mail-tracker/mail-tracker
php artisan migrate
```

Bu komut tüm tabloları oluşturacak.

### 3. Development Server'ları Başlatın

**Terminal 1 - Laravel Server:**
```bash
cd /Users/huseyinatilgan/mail-tracker/mail-tracker
php artisan serve
```

**Terminal 2 - Vite Dev Server (Asset'ler için):**
```bash
cd /Users/huseyinatilgan/mail-tracker/mail-tracker
npm run dev
```

### 4. Tarayıcıda Açın

🌐 **http://localhost:8000** adresine gidin

## 🎯 İlk Kullanıcı Oluşturma

1. Tarayıcıda `http://localhost:8000/register` adresine gidin
2. Yeni bir kullanıcı oluşturun
3. Email doğrulama gerekebilir (local'de genellikle atlanabilir)

## 📝 Test Kullanıcısı Oluşturma (Opsiyonel)

Eğer hızlıca test için kullanıcı oluşturmak isterseniz:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
```

## 🔧 Sorun Giderme

### MySQL Bağlantı Hatası

Eğer migration çalışmıyorsa:

1. MySQL servisinin çalıştığından emin olun
2. MySQL Workbench'te connection bilgilerini kontrol edin
3. `.env` dosyasındaki `DB_PORT` değerini kontrol edin (varsayılan: 3306)

### Port Zaten Kullanılıyor

Eğer 8000 portu kullanılıyorsa:
```bash
php artisan serve --port=8001
```

## 📚 Daha Fazla Bilgi

- `SETUP_LOCAL.md` - Detaylı kurulum rehberi
- `VERITABANI_KURULUM.md` - Veritabanı kurulum detayları
- `PRODUCTION.md` - Production deployment rehberi
- `SECURITY.md` - Güvenlik dokümantasyonu

## 🎉 Hazırsınız!

Veritabanını oluşturduktan ve migration'ları çalıştırdıktan sonra proje kullanıma hazır olacak!

