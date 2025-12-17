# Veritabanı Kurulum Rehberi

## MySQL Workbench ile Veritabanı Oluşturma

### Adım 1: MySQL Workbench'i Açın
1. MySQL Workbench uygulamasını açın
2. Local instance'a bağlanın (root kullanıcısı, şifre: root)

### Adım 2: Veritabanını Oluşturun

SQL Editor'de şu komutu çalıştırın:

```sql
CREATE DATABASE IF NOT EXISTS mail_tracker 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

### Adım 3: Veritabanını Kontrol Edin

```sql
SHOW DATABASES LIKE 'mail_tracker';
```

Eğer veritabanı görünüyorsa, kurulum başarılı!

### Adım 4: Migration'ları Çalıştırın

Terminal'de:

```bash
cd /Users/huseyinatilgan/mail-tracker/mail-tracker
php artisan migrate
```

Bu komut şu tabloları oluşturacak:
- `users` - Kullanıcılar
- `campaigns` - Kampanyalar
- `events` - E-posta okunma kayıtları
- `cache`, `cache_locks`, `jobs`, `job_batches`, `sessions` - Laravel sistem tabloları

### Adım 5: Index Migration'ını Çalıştırın

```bash
php artisan migrate
```

Bu, `events` tablosuna performans index'lerini ekleyecek.

## Alternatif: Terminal ile Veritabanı Oluşturma

Eğer MySQL komut satırından erişilebilirse:

```bash
mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS mail_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## Sorun Giderme

### MySQL Bağlantı Hatası

Eğer `php artisan migrate` komutu MySQL bağlantı hatası veriyorsa:

1. MySQL servisinin çalıştığından emin olun
2. `.env` dosyasındaki bağlantı bilgilerini kontrol edin:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mail_tracker
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

3. MySQL Workbench'te connection bilgilerini kontrol edin (port, host vb.)

### Port Farklıysa

Eğer MySQL farklı bir port kullanıyorsa (örneğin 3307), `.env` dosyasını güncelleyin:
```env
DB_PORT=3307
```

