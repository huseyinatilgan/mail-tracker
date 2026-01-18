<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" style="flex-wrap: wrap; gap: var(--spacing-md);">
            <div class="page-header-title">
                <div class="page-header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="page-header-text">
                    <h1>{{ __('Kampanya Düzenle') }}: {{ $campaign->name }}</h1>
                    <p>Kampanya bilgilerini güncelleyin</p>
                </div>
            </div>
            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="main-content">
        <div class="main-container" style="max-width: 1024px;">
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn" style="color: var(--color-primary);"></i>
                        Kampanya Bilgileri
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name" class="form-label required">
                                <i class="fas fa-tag" style="color: var(--color-primary); margin-right: var(--spacing-xs);"></i>
                                Kampanya Adı
                            </label>
                            <input type="text" 
                                   class="form-input @error('name') error @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $campaign->name) }}" 
                                   placeholder="Örn: Yaz Kampanyası 2024"
                                   required>
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="form-help">
                                Kampanyanızı tanımlayacak açıklayıcı bir isim verin.
                            </p>
                        </div>

                        <div class="info-box">
                            <div class="info-box-content">
                                <div class="info-box-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="info-box-text">
                                    <h4>Tracking Key Değiştirilemez</h4>
                                    <p>
                                        Mevcut tracking key: <code class="code">{{ $campaign->key }}</code><br>
                                        Bu key değiştirilemez çünkü e-postalarınızda kullanılıyor olabilir.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between" style="margin-top: var(--spacing-xl);">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kampanya İstatistikleri -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar" style="color: var(--color-primary);"></i>
                        Kampanya İstatistikleri
                    </h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 grid-cols-sm-2" style="gap: var(--spacing-lg);">
                        <div>
                            <h4 style="margin: 0; margin-bottom: var(--spacing-sm); font-size: var(--font-size-base); font-weight: 600; color: var(--text-primary);">
                                <i class="fas fa-calendar" style="color: var(--color-primary); margin-right: var(--spacing-sm);"></i>
                                Oluşturulma Tarihi
                            </h4>
                            <p style="margin: 0; color: var(--text-secondary);">{{ $campaign->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <h4 style="margin: 0; margin-bottom: var(--spacing-sm); font-size: var(--font-size-base); font-weight: 600; color: var(--text-primary);">
                                <i class="fas fa-clock" style="color: var(--color-primary); margin-right: var(--spacing-sm);"></i>
                                Son Güncelleme
                            </h4>
                            <p style="margin: 0; color: var(--text-secondary);">{{ $campaign->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <h4 style="margin: 0; margin-bottom: var(--spacing-sm); font-size: var(--font-size-base); font-weight: 600; color: var(--text-primary);">
                                <i class="fas fa-envelope-open" style="color: var(--color-primary); margin-right: var(--spacing-sm);"></i>
                                Toplam Okunma
                            </h4>
                            <p style="margin: 0; color: var(--text-secondary);">{{ $campaign->events->count() }} kez</p>
                        </div>
                        <div>
                            <h4 style="margin: 0; margin-bottom: var(--spacing-sm); font-size: var(--font-size-base); font-weight: 600; color: var(--text-primary);">
                                <i class="fas fa-key" style="color: var(--color-primary); margin-right: var(--spacing-sm);"></i>
                                Tracking Key
                            </h4>
                            <p style="margin: 0;"><code class="code">{{ $campaign->key }}</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
