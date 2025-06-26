<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-gray-600">E-posta kampanyalarınızın performansını takip edin</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Kampanya ara..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64">
                </div>
                <a href="{{ route('campaigns.create') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-2.5 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Yeni Kampanya
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- İstatistik Kartları -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Toplam Kampanya -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Toplam Kampanya</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_campaigns'] ?? 0 }}</p>
                                <div class="flex items-center text-sm text-green-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+12%</span>
                                    <span class="text-gray-500 ml-1">bu ay</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg ml-4">
                                <i class="fas fa-bullhorn text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toplam Okunma -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Toplam Okunma</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_events'] ?? 0 }}</p>
                                <div class="flex items-center text-sm text-green-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+8%</span>
                                    <span class="text-gray-500 ml-1">bu hafta</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg ml-4">
                                <i class="fas fa-envelope-open text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bugünkü Okunma -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Bugünkü Okunma</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['today_events'] ?? 0 }}</p>
                                <div class="flex items-center text-sm text-purple-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+15%</span>
                                    <span class="text-gray-500 ml-1">dünden</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg ml-4">
                                <i class="fas fa-calendar-day text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bu Hafta Okunma -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Bu Hafta Okunma</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['week_events'] ?? 0 }}</p>
                                <div class="flex items-center text-sm text-orange-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+22%</span>
                                    <span class="text-gray-500 ml-1">geçen haftadan</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg ml-4">
                                <i class="fas fa-calendar-week text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ana İçerik Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Grafik Alanı -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">Okunma Trendi</h3>
                            <div class="flex items-center space-x-2">
                                <select class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option>Son 7 gün</option>
                                    <option>Son 30 gün</option>
                                    <option>Son 3 ay</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="readingChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Hızlı İşlemler -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900">Hızlı İşlemler</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <a href="{{ route('campaigns.create') }}" class="block">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-plus text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold">Yeni Kampanya</h4>
                                        <p class="text-blue-100 text-sm">E-posta kampanyası oluşturun</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('campaigns.index') }}" class="block">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-list text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold">Tüm Kampanyalar</h4>
                                        <p class="text-green-100 text-sm">Kampanyalarınızı yönetin</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="block">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-chart-bar text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold">Detaylı Analitik</h4>
                                        <p class="text-purple-100 text-sm">Performans raporları</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="block">
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-cog text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold">Ayarlar</h4>
                                        <p class="text-orange-100 text-sm">Sistem ayarları</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alt Bölüm Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Son Kampanyalar -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">Son Kampanyalar</h3>
                            <a href="{{ route('campaigns.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Tümünü Gör <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($recentCampaigns) && $recentCampaigns->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentCampaigns as $campaign)
                                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-envelope text-white"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $campaign->name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $campaign->key }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-6">
                                                <div class="text-center">
                                                    <div class="text-2xl font-bold text-gray-900">{{ $campaign->events_count ?? 0 }}</div>
                                                    <div class="text-xs text-gray-500">okunma</div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('campaigns.show', $campaign) }}" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                                                        <i class="fas fa-eye text-blue-600 text-sm"></i>
                                                    </a>
                                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="w-8 h-8 bg-green-100 hover:bg-green-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                                                        <i class="fas fa-edit text-green-600 text-sm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between text-sm text-gray-500">
                                            <span>Oluşturulma: {{ $campaign->created_at->format('d.m.Y H:i') }}</span>
                                            <div class="flex items-center space-x-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                <span>Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-inbox text-2xl text-indigo-600"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz kampanya oluşturmadınız</h3>
                                <p class="text-gray-600 mb-6">İlk e-posta kampanyanızı oluşturarak takip etmeye başlayın.</p>
                                <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-plus mr-2"></i>
                                    İlk Kampanyanızı Oluşturun
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Son Aktiviteler -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900">Son Aktiviteler</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-envelope-open text-green-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Yeni e-posta okundu</p>
                                    <p class="text-xs text-gray-500">2 dakika önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-plus text-blue-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Yeni kampanya oluşturuldu</p>
                                    <p class="text-xs text-gray-500">1 saat önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-chart-line text-purple-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Performans raporu hazırlandı</p>
                                    <p class="text-xs text-gray-500">3 saat önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-edit text-orange-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Kampanya güncellendi</p>
                                    <p class="text-xs text-gray-500">5 saat önce</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Tüm aktiviteleri gör <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Animasyonları -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasyonlu giriş
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-fade-in-up');
            });
            
            // Hover efektleri
            const statCards = document.querySelectorAll('.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4 > div');
            statCards.forEach(card => {
                card.classList.add('hover-lift');
            });

            // Chart.js Grafik
            const ctx = document.getElementById('readingChart');
            if (ctx) {
                const chartData = @json($chartData ?? ['labels' => [], 'data' => []]);
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Günlük Okunma',
                            data: chartData.data,
                            borderColor: 'rgb(99, 102, 241)',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(99, 102, 241)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        elements: {
                            point: {
                                hoverBackgroundColor: 'rgb(99, 102, 241)'
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout> 