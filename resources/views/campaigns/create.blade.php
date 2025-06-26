<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Yeni Kampanya Oluştur</h1>
                        <p class="text-sm text-gray-600">E-posta kampanyanızı oluşturun ve takip etmeye başlayın</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('campaigns.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg transition-all duration-300 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Ana Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-bullhorn mr-2 text-indigo-600"></i>
                        Kampanya Bilgileri
                    </h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('campaigns.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1 text-indigo-600"></i>
                                Kampanya Adı <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Örn: Yaz Kampanyası 2024"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-600">
                                Kampanyanızı tanımlayacak açıklayıcı bir isim verin.
                            </p>
                        </div>

                        <!-- Bilgi Kutusu -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                    <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-blue-900 mb-1">
                                        Tracking Key Otomatik Oluşturulacak
                                    </h4>
                                    <p class="text-sm text-blue-800">
                                        Kampanya oluşturulduktan sonra size benzersiz bir tracking key verilecek. 
                                        Bu key'i e-postalarınıza ekleyerek okunma durumunu takip edebilirsiniz.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('campaigns.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg transition-all duration-300 font-medium">
                                <i class="fas fa-times mr-2"></i>
                                İptal
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Kampanya Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kullanım Rehberi -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-question-circle mr-2 text-indigo-600"></i>
                        Nasıl Kullanılır?
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Kampanya Oluşturun</h4>
                            </div>
                            <p class="text-gray-600">Yukarıdaki formu doldurarak kampanyanızı oluşturun.</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Tracking Key'i Alın</h4>
                            </div>
                            <p class="text-gray-600">Kampanya oluşturulduktan sonra size benzersiz bir key verilecek.</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">E-postaya Ekleyin</h4>
                            </div>
                            <p class="text-gray-600 mb-3">Bu key'i e-postalarınıza şu şekilde ekleyin:</p>
                            <code class="bg-gray-100 text-gray-800 px-3 py-2 rounded text-sm font-mono block">
                                &lt;img src="{{ url('/track/YOUR_KEY') }}" width="1" height="1"&gt;
                            </code>
                        </div>
                        
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">4</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Takip Edin</h4>
                            </div>
                            <p class="text-gray-600">E-posta açıldığında otomatik olarak okunma kaydı oluşacak.</p>
                        </div>
                    </div>
                    
                    <!-- Örnek Kullanım -->
                    <div class="mt-8 bg-gray-50 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-code mr-2 text-indigo-600"></i>
                            Örnek E-posta HTML Kodu
                        </h4>
                        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-green-400 text-sm"><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;Kampanya E-postası&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Merhaba!&lt;/h1&gt;
    &lt;p&gt;Bu e-posta kampanyamızı takip ediyoruz.&lt;/p&gt;
    
    &lt;!-- Tracking pixel - görünmez olmalı --&gt;
    &lt;img src="{{ url('/track/YOUR_KEY') }}" width="1" height="1" style="display:none;"&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 