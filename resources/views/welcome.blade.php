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
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <i class="fas fa-envelope-open text-2xl text-blue-600 mr-3"></i>
                            <span class="text-xl font-bold text-gray-900">MailTracker</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                                Giriş Yap
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                    Kayıt Ol
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    E-posta Kampanyalarınızı Takip Edin
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    E-postalarınızın açılma oranlarını gerçek zamanlı olarak izleyin ve kampanya performansınızı optimize edin.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-700 transition duration-200">
                            Dashboard'a Git
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-700 transition duration-200">
                            Ücretsiz Başla
                        </a>
                        <a href="#features" class="border border-blue-600 text-blue-600 px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-50 transition duration-200">
                            Özellikler
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Neden MailTracker?
                    </h2>
                    <p class="text-lg text-gray-600">
                        E-posta kampanyalarınızı daha etkili hale getirin
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="text-center mb-4">
                            <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-line text-xl text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerçek Zamanlı Takip</h3>
                            <p class="text-gray-600">
                                E-postalarınızın açılma durumunu anında takip edin.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="text-center mb-4">
                            <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shield-alt text-xl text-green-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Güvenli ve Gizli</h3>
                            <p class="text-gray-600">
                                1x1 pixel tracking ile kullanıcı gizliliğini koruyun.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="text-center mb-4">
                            <div class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-tachometer-alt text-xl text-purple-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Detaylı Analitik</h3>
                            <p class="text-gray-600">
                                Günlük, haftalık ve aylık istatistiklerle analiz edin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Nasıl Çalışır?
                    </h2>
                    <p class="text-lg text-gray-600">
                        3 basit adımda e-posta takibinizi başlatın
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-bold">
                            1
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Kampanya Oluşturun</h3>
                        <p class="text-gray-600">
                            MailTracker'da yeni bir kampanya oluşturun ve tracking key'inizi alın.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-bold">
                            2
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">E-postaya Ekleyin</h3>
                        <p class="text-gray-600">
                            Tracking kodunu e-postalarınıza ekleyin.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-bold">
                            3
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Takip Edin</h3>
                        <p class="text-gray-600">
                            Dashboard'dan gerçek zamanlı olarak takip edin.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-blue-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Hemen Başlayın
                </h2>
                <p class="text-lg text-blue-100 mb-8">
                    E-posta kampanyalarınızı daha etkili hale getirin
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-medium hover:bg-gray-100 transition duration-200">
                            Dashboard'a Git
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-medium hover:bg-gray-100 transition duration-200">
                            Ücretsiz Kayıt Ol
                        </a>
                        <a href="{{ route('login') }}" class="border border-white text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-white hover:text-blue-600 transition duration-200">
                            Giriş Yap
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-envelope-open text-2xl text-blue-400 mr-2"></i>
                            <span class="text-xl font-bold">MailTracker</span>
                        </div>
                        <p class="text-gray-400">
                            E-posta kampanya takip sistemi ile kampanyalarınızı optimize edin.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Özellikler</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white">Gerçek Zamanlı Takip</a></li>
                            <li><a href="#" class="hover:text-white">Detaylı Analitik</a></li>
                            <li><a href="#" class="hover:text-white">Güvenli Tracking</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Destek</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white">Yardım Merkezi</a></li>
                            <li><a href="#" class="hover:text-white">İletişim</a></li>
                            <li><a href="#" class="hover:text-white">SSS</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Sosyal Medya</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
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
