<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-bullhorn text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Kampanyalar</h1>
                        <p class="text-sm text-gray-600">E-posta kampanyalarınızı yönetin ve takip edin</p>
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
            
            <!-- İstatistik Özeti -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-bullhorn text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Toplam Kampanya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $summary['total_campaigns'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-envelope-open text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Toplam Okunma</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $summary['total_events'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ortalama Okunma</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $summary['average_reads'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kampanya Listesi -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">Kampanya Listesi</h3>
                        <div class="flex items-center space-x-2">
                            <select class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option>Tüm Kampanyalar</option>
                                <option>Aktif Kampanyalar</option>
                                <option>Arşivlenmiş</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($campaigns->count() > 0)
                        <div class="space-y-4">
                            @foreach($campaigns as $campaign)
                                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-envelope text-white"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $campaign->name }}</h4>
                                                <div class="flex items-center space-x-4 mt-1">
                                                    <div class="flex items-center space-x-2">
                                                        <code class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm font-mono">{{ $campaign->key }}</code>
                                                        <button onclick="copyToClipboard(event, '{{ $campaign->key }}')"
                                                                class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center transition-colors duration-200"
                                                                data-success-icon="fas fa-check text-green-600 text-xs"
                                                                data-success-classes="bg-green-200"
                                                                data-success-remove-classes="bg-gray-200 hover:bg-gray-300"
                                                                title="Key'i kopyala">
                                                            <i class="fas fa-copy text-gray-600 text-xs"></i>
                                                        </button>
                                                    </div>
                                                    <span class="text-sm text-gray-500">•</span>
                                                    <span class="text-sm text-gray-500">Oluşturulma: {{ $campaign->created_at->format('d.m.Y H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-6">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900">{{ $campaign->events_count ?? 0 }}</div>
                                                <div class="text-xs text-gray-500">okunma</div>
                                            </div>
                                            
                                            <div class="flex space-x-2">
                                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                                   class="w-10 h-10 bg-blue-100 hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors duration-200"
                                                   title="Görüntüle">
                                                    <i class="fas fa-eye text-blue-600"></i>
                                                </a>
                                                <a href="{{ route('campaigns.edit', $campaign) }}" 
                                                   class="w-10 h-10 bg-yellow-100 hover:bg-yellow-200 rounded-lg flex items-center justify-center transition-colors duration-200"
                                                   title="Düzenle">
                                                    <i class="fas fa-edit text-yellow-600"></i>
                                                </a>
                                                <form action="{{ route('campaigns.destroy', $campaign) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Bu kampanyayı silmek istediğinizden emin misiniz?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg flex items-center justify-center transition-colors duration-200"
                                                            title="Sil">
                                                        <i class="fas fa-trash text-red-600"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                        <span>Son güncelleme: {{ $campaign->updated_at->format('d.m.Y H:i') }}</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            <span>Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Sayfalama -->
                        @if($campaigns instanceof \Illuminate\Pagination\LengthAwarePaginator && $campaigns->hasPages())
                            <div class="mt-8 flex items-center justify-center">
                                {{ $campaigns->links() }}
                            </div>
                        @endif
                        
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-inbox text-3xl text-indigo-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz kampanya oluşturmadınız</h3>
                            <p class="text-gray-600 mb-8">İlk e-posta kampanyanızı oluşturarak tracking'e başlayın.</p>
                            <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>
                                İlk Kampanyanızı Oluşturun
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(event, text) {
            event.preventDefault();

            const button = event.currentTarget;

            if (!button.dataset.originalClasses) {
                button.dataset.originalClasses = button.className;
            }

            const icon = button.querySelector('i');

            if (icon && !button.dataset.originalIconClasses) {
                button.dataset.originalIconClasses = icon.className;
            }

            navigator.clipboard.writeText(text).then(function () {
                const successIcon = button.dataset.successIcon || 'fas fa-check text-green-600';
                const classesToAdd = (button.dataset.successClasses || '').split(' ').filter(Boolean);
                const classesToRemove = (button.dataset.successRemoveClasses || '').split(' ').filter(Boolean);

                if (icon && successIcon) {
                    icon.className = successIcon;
                }

                if (classesToRemove.length) {
                    button.classList.remove(...classesToRemove);
                }

                if (classesToAdd.length) {
                    button.classList.add(...classesToAdd);
                }

                setTimeout(() => {
                    if (icon && button.dataset.originalIconClasses) {
                        icon.className = button.dataset.originalIconClasses;
                    }

                    if (button.dataset.originalClasses) {
                        button.className = button.dataset.originalClasses;
                    }
                }, 1000);
            }).catch(function () {
                if (button.dataset.originalClasses) {
                    button.className = button.dataset.originalClasses;
                }

                if (icon && button.dataset.originalIconClasses) {
                    icon.className = button.dataset.originalIconClasses;
                }
            });
        }
    </script>
</x-app-layout>