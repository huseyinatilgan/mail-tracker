# 📧 MailTracker - Email Campaign Tracking System

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

# 📧 MailTracker - E-posta Kampanya Takip Sistemi

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 🌟 Overview / Genel Bakış

**English:** MailTracker is a modern Laravel-based email campaign tracking system that allows you to monitor email open rates using invisible tracking pixels. Track your email campaigns in real-time and analyze performance with detailed statistics.

**Türkçe:** MailTracker, görünmez tracking pixel'ları kullanarak e-posta kampanyalarınızın açılma oranlarını takip etmenizi sağlayan modern Laravel tabanlı bir e-posta kampanya takip sistemidir. E-posta kampanyalarınızı gerçek zamanlı olarak takip edin ve detaylı istatistiklerle performansı analiz edin.

## ✨ Features / Özellikler

### 🔐 Authentication & Security / Kimlik Doğrulama ve Güvenlik
- **Laravel Breeze** authentication system
- **Email verification** required
- **Password reset** functionality
- **Remember me** feature
- **CSRF protection** on all forms
- **XSS protection** with Blade escaping
- **SQL injection protection** with Eloquent ORM
- **Rate limiting** for tracking endpoints

### 📊 Campaign Management / Kampanya Yönetimi
- **Create, edit, delete, and list** campaigns
- **Unique 20-character keys** for each campaign
- **Real-time statistics** dashboard
- **Campaign performance** analytics
- **Modern responsive UI** with Tailwind CSS
- **Form validation** with custom requests

### 📈 Email Tracking System / E-posta Takip Sistemi
- **Invisible 1x1 pixel tracking**
- **Automatic event logging** when emails are opened
- **IP address and user agent** tracking
- **Rate limiting** to prevent spam
- **Real-time statistics** updates
- **Performance optimized** tracking endpoints

### 📱 Modern Dashboard / Modern Kontrol Paneli
- **Real-time statistics** cards
- **Campaign overview** with key metrics
- **Recent campaigns** list
- **Quick action buttons** for common tasks
- **Responsive design** for all devices
- **Modern UI/UX** with smooth animations

### 🔧 Technical Features / Teknik Özellikler
- **Laravel 11.x** with latest features
- **PHP 8.2+** for optimal performance
- **MySQL 8.0+** database
- **Tailwind CSS** for modern styling
- **FontAwesome 6.x** icons
- **jQuery 3.7+** for interactions
- **Laravel Sanctum** ready for API development

## 🛠️ Technology Stack / Teknoloji Yığını

### Backend / Arka Uç
- **Laravel 11.x** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL 8.0+** - Database
- **Laravel Breeze** - Authentication
- **Laravel Sanctum** - API Authentication

### Frontend / Ön Uç
- **Tailwind CSS** - Utility-first CSS framework
- **FontAwesome 6.x** - Icon library
- **jQuery 3.7+** - JavaScript library
- **Alpine.js** - Lightweight JavaScript framework

### Development Tools / Geliştirme Araçları
- **Vite** - Build tool
- **Laravel Mix** - Asset compilation
- **Composer** - PHP dependency manager
- **npm** - Node.js package manager

## 📦 Installation / Kurulum

### Prerequisites / Ön Gereksinimler
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js and npm

### Step 1: Clone the Repository / Adım 1: Repository'yi Klonlayın
```bash
git clone https://github.com/huseyinatilgan/mail-tracker.git
cd mail-tracker
```

### Step 2: Install Dependencies / Adım 2: Bağımlılıkları Yükleyin
```bash
composer install
npm install
```

### Step 3: Environment Setup / Adım 3: Ortam Kurulumu
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Database Configuration / Adım 4: Veritabanı Yapılandırması
Edit `.env` file and configure your database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations / Adım 5: Migration'ları Çalıştırın
```bash
php artisan migrate
```

### Step 6: Build Assets / Adım 6: Asset'leri Derleyin
```bash
npm run build
```

### Step 7: Start the Server / Adım 7: Sunucuyu Başlatın
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🚀 Usage / Kullanım

### Creating a Campaign / Kampanya Oluşturma
1. **Register/Login** to your account
2. **Click "New Campaign"** on the dashboard
3. **Enter campaign name** and details
4. **Copy the tracking key** generated automatically
5. **Add the tracking pixel** to your emails:
   ```html
   <img src="http://yourdomain.com/track/YOUR_TRACKING_KEY" width="1" height="1">
   ```

### Tracking Email Opens / E-posta Açılmalarını Takip Etme
- **Automatic tracking** when emails are opened
- **Real-time statistics** on dashboard
- **Detailed analytics** per campaign
- **IP and user agent** information stored

### Viewing Statistics / İstatistikleri Görüntüleme
- **Dashboard overview** with key metrics
- **Campaign-specific** statistics
- **Time-based analytics** (daily, weekly, monthly)
- **Performance insights** and trends

## 📊 Database Schema / Veritabanı Şeması

### Users Table
```sql
- id (bigint, primary key)
- name (varchar)
- email (varchar, unique)
- email_verified_at (timestamp, nullable)
- password (varchar, hashed)
- remember_token (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Campaigns Table
```sql
- id (bigint, primary key)
- name (varchar, required)
- key (varchar, unique, 20 characters)
- user_id (bigint, foreign key -> users.id)
- created_at (timestamp)
- updated_at (timestamp)
```

### Events Table
```sql
- id (bigint, primary key)
- campaign_id (bigint, foreign key -> campaigns.id)
- user_agent (text, nullable)
- ip_address (varchar, nullable)
- user_email (varchar, nullable)
- opened_at (timestamp)
- created_at (timestamp)
- updated_at (timestamp)
```

## 🔧 Configuration / Yapılandırma

### Environment Variables / Ortam Değişkenleri
```env
APP_NAME=MailTracker
APP_ENV=production
APP_DEBUG=false
APP_URL=http://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="${APP_NAME}"
```

### Rate Limiting / Hız Sınırlama
Configure rate limiting in `app/Http/Kernel.php`:
```php
'throttle:60,1' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
```

## 🧪 Testing / Test Etme

### Run Tests / Testleri Çalıştırın
```bash
php artisan test
```

### Test Coverage / Test Kapsamı
```bash
php artisan test --coverage
```

## 📈 Performance Optimization / Performans Optimizasyonu

### Caching / Önbellekleme
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Optimization / Veritabanı Optimizasyonu
- **Indexes** on frequently queried columns
- **Query optimization** with Eloquent
- **Database connection pooling**

### Frontend Optimization / Ön Uç Optimizasyonu
- **Asset minification** with Vite
- **Image optimization**
- **CDN integration** ready

## 🔒 Security Features / Güvenlik Özellikleri

### Authentication Security / Kimlik Doğrulama Güvenliği
- **Laravel Breeze** secure authentication
- **Email verification** required
- **Password complexity** requirements
- **Rate limiting** on login attempts
- **Session security** configuration

### Data Protection / Veri Koruması
- **CSRF protection** on all forms
- **XSS protection** with Blade escaping
- **SQL injection protection** with Eloquent
- **Input validation** with Form Requests
- **File upload security**

### API Security / API Güvenliği
- **Laravel Sanctum** authentication ready
- **Rate limiting** for API calls
- **CORS configuration**
- **Request validation**

## 🚀 Deployment / Dağıtım

### Production Deployment / Üretim Dağıtımı
1. **Set up production server** (Ubuntu 20.04+ recommended)
2. **Install required software** (PHP, MySQL, Nginx)
3. **Clone repository** and configure environment
4. **Run migrations** and seed data
5. **Configure web server** (Nginx/Apache)
6. **Set up SSL certificate**
7. **Configure monitoring** and logging

### Docker Deployment / Docker Dağıtımı
```bash
docker-compose up -d
```

### Environment Checklist / Ortam Kontrol Listesi
- [ ] **Environment variables** configured
- [ ] **Database** created and migrated
- [ ] **Web server** configured
- [ ] **SSL certificate** installed
- [ ] **Monitoring** set up
- [ ] **Backup strategy** implemented

## 🔮 Future Enhancements / Gelecek Geliştirmeler

### Planned Features / Planlanan Özellikler
- [ ] **API endpoints** for mobile apps
- [ ] **Real-time notifications** with WebSockets
- [ ] **Advanced analytics** with Chart.js
- [ ] **Email templates** management
- [ ] **Bulk email sending** functionality
- [ ] **A/B testing** for campaigns
- [ ] **Geographic tracking** by IP
- [ ] **Device/browser analytics**
- [ ] **Export reports** (PDF, CSV, Excel)
- [ ] **Scheduled reports** via email
- [ ] **Multi-tenant architecture**
- [ ] **White-label solution**
- [ ] **Mobile application**
- [ ] **Webhook integrations**
- [ ] **Third-party integrations** (Mailchimp, SendGrid)

### Performance Improvements / Performans İyileştirmeleri
- [ ] **Redis caching** for statistics
- [ ] **Database query optimization**
- [ ] **CDN integration**
- [ ] **Image optimization**
- [ ] **Lazy loading** for large datasets
- [ ] **Database read replicas**

### Security Enhancements / Güvenlik İyileştirmeleri
- [ ] **Two-factor authentication**
- [ ] **Audit logging**
- [ ] **IP whitelisting**
- [ ] **Advanced rate limiting**
- [ ] **Security headers** configuration

## 🤝 Contributing / Katkıda Bulunma

### Development Setup / Geliştirme Kurulumu
1. **Fork the repository**
2. **Create a feature branch**
3. **Make your changes**
4. **Write tests** for new features
5. **Submit a pull request**

### Coding Standards / Kod Standartları
- **PSR-12** coding standards
- **Laravel conventions** followed
- **Documentation** for new features
- **Test coverage** for all changes

## 👥 Authors / Yazarlar

- **Hüseyin Atılgan** - *Initial work* - [huseyinatilgan](https://github.com/huseyinatilgan)

## 🙏 Acknowledgments / Teşekkürler

- **Laravel Team** for the amazing framework
- **Tailwind CSS** for the utility-first CSS framework
- **FontAwesome** for the beautiful icons
- **Open source community** for inspiration and support


### Bug Reports / Hata Raporları
Please use the [GitHub issue tracker](https://github.com/huseyinatilgan/mail-tracker/issues) to report bugs.

### Feature Requests / Özellik İstekleri
Use the [GitHub Discussions](https://github.com/huseyinatilgan/mail-tracker/discussions) to request new features.

---