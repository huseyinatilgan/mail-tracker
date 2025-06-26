<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MailTracker - E-posta Kampanya Takip Sistemi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .feature-card {
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center">
                                <i class="fas fa-envelope-open-text text-2xl text-blue-600 mr-2"></i>
                                <span class="text-xl font-bold text-gray-900">MailTracker</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                                Giriş Yap
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Kayıt Ol
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-gradient text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        E-posta Kampanyalarınızı
                        <span class="text-yellow-300">Takip Edin</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-blue-100">
                        E-postalarınızın açılma oranlarını gerçek zamanlı olarak izleyin ve kampanya performansınızı optimize edin.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                                <i class="fas fa-rocket mr-2"></i>
                                Dashboard'a Git
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                                <i class="fas fa-rocket mr-2"></i>
                                Ücretsiz Başla
                            </a>
                            <a href="#features" class="border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                                <i class="fas fa-play mr-2"></i>
                                Nasıl Çalışır?
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Neden MailTracker?
                    </h2>
                    <p class="text-xl text-gray-600">
                        E-posta kampanyalarınızı daha akıllı hale getirin
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="feature-card bg-white p-8 rounded-xl shadow-lg">
                        <div class="text-center mb-6">
                            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-chart-line text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Gerçek Zamanlı Takip</h3>
                            <p class="text-gray-600">
                                E-postalarınızın açılma durumunu anında takip edin ve kampanya performansınızı optimize edin.
                            </p>
                        </div>
                    </div>

                    <div class="feature-card bg-white p-8 rounded-xl shadow-lg">
                        <div class="text-center mb-6">
                            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Güvenli ve Gizli</h3>
                            <p class="text-gray-600">
                                1x1 pixel tracking ile kullanıcılarınızın gizliliğini koruyarak güvenli takip yapın.
                            </p>
                        </div>
                    </div>

                    <div class="feature-card bg-white p-8 rounded-xl shadow-lg">
                        <div class="text-center mb-6">
                            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tachometer-alt text-2xl text-purple-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Detaylı Analitik</h3>
                            <p class="text-gray-600">
                                Günlük, haftalık ve aylık istatistiklerle kampanya performansınızı analiz edin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Nasıl Çalışır?
                    </h2>
                    <p class="text-xl text-gray-600">
                        3 basit adımda e-posta takibinizi başlatın
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            1
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Kampanya Oluşturun</h3>
                        <p class="text-gray-600">
                            MailTracker'da yeni bir kampanya oluşturun ve size özel tracking key'inizi alın.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            2
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">E-postaya Ekleyin</h3>
                        <p class="text-gray-600">
                            Tracking kodunu e-postalarınıza ekleyin. Kod otomatik olarak gizli bir pixel olarak çalışır.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            3
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Takip Edin</h3>
                        <p class="text-gray-600">
                            Dashboard'dan gerçek zamanlı olarak e-posta açılma oranlarınızı takip edin.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-blue-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Hemen Başlayın
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    E-posta kampanyalarınızı daha etkili hale getirin
                </p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Dashboard'a Git
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i>
                        Ücretsiz Kayıt Ol
                    </a>
                @endauth
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-envelope-open-text text-2xl text-blue-400 mr-2"></i>
                            <span class="text-xl font-bold">MailTracker</span>
                        </div>
                        <p class="text-gray-400">
                            E-posta kampanya takip sistemi ile kampanyalarınızı optimize edin.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Özellikler</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition duration-300">Gerçek Zamanlı Takip</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Detaylı Analitik</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Güvenli Tracking</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Destek</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition duration-300">Yardım Merkezi</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">İletişim</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">SSS</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Sosyal Medya</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 MailTracker. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
