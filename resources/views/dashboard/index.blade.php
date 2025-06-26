<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-tachometer-alt me-2 text-blue-600"></i>
                {{ __('Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('campaigns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-plus me-2"></i>
                    Yeni Kampanya
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- İstatistik Kartları -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Toplam Kampanya -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bullhorn text-2xl text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Toplam Kampanya</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_campaigns'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toplam Okunma -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope-open text-2xl text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Toplam Okunma</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_events'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bugünkü Okunma -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-day text-2xl text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Bugünkü Okunma</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['today_events'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bu Hafta Okunma -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-week text-2xl text-orange-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Bu Hafta Okunma</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['week_events'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hızlı İşlemler -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-bolt me-2 text-yellow-500"></i>
                        Hızlı İşlemler
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('campaigns.create') }}" class="group">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl hover:from-blue-600 hover:to-blue-700 transition duration-300 transform hover:scale-105">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-plus text-3xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Yeni Kampanya</h4>
                                        <p class="text-blue-100">Yeni bir e-posta kampanyası oluşturun</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('campaigns.index') }}" class="group">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl hover:from-green-600 hover:to-green-700 transition duration-300 transform hover:scale-105">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-list text-3xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Tüm Kampanyalar</h4>
                                        <p class="text-green-100">Mevcut kampanyalarınızı görüntüleyin</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="group">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-xl hover:from-purple-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-chart-bar text-3xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Analitik</h4>
                                        <p class="text-purple-100">Detaylı raporları inceleyin</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Son Kampanyalar -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-clock me-2 text-blue-500"></i>
                        Son Kampanyalar
                    </h3>
                </div>
                <div class="p-6">
                    @if(isset($recentCampaigns) && $recentCampaigns->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kampanya Adı
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tracking Key
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Okunma Sayısı
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Oluşturulma Tarihi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            İşlemler
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentCampaigns as $campaign)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <i class="fas fa-envelope text-blue-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $campaign->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <code class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm font-mono">{{ $campaign->key }}</code>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm text-gray-900 font-semibold">{{ $campaign->events_count ?? 0 }}</span>
                                                    <span class="ml-2 text-sm text-gray-500">okunma</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $campaign->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-900 transition duration-150">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="text-green-600 hover:text-green-900 transition duration-150">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz kampanya oluşturmadınız</h3>
                            <p class="text-gray-500 mb-6">İlk e-posta kampanyanızı oluşturarak takip etmeye başlayın.</p>
                            <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-plus me-2"></i>
                                İlk Kampanyanızı Oluşturun
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 