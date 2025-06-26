<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-edit me-2"></i>
                {{ __('Kampanya Düzenle') }}: {{ $campaign->name }}
            </h2>
            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bullhorn me-2"></i>
                        Kampanya Bilgileri
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-1"></i>
                                Kampanya Adı <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $campaign->name) }}" 
                                   placeholder="Örn: Yaz Kampanyası 2024"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Kampanyanızı tanımlayacak açıklayıcı bir isim verin.
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Tracking Key Değiştirilemez
                            </h6>
                            <p class="mb-0">
                                Mevcut tracking key: <code>{{ $campaign->key }}</code><br>
                                Bu key değiştirilemez çünkü e-postalarınızda kullanılıyor olabilir.
                            </p>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>
                                İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kampanya İstatistikleri -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>
                        Kampanya İstatistikleri
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar me-2"></i>Oluşturulma Tarihi</h6>
                            <p class="text-muted">{{ $campaign->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-clock me-2"></i>Son Güncelleme</h6>
                            <p class="text-muted">{{ $campaign->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-envelope-open me-2"></i>Toplam Okunma</h6>
                            <p class="text-muted">{{ $campaign->events->count() }} kez</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-key me-2"></i>Tracking Key</h6>
                            <p class="text-muted"><code>{{ $campaign->key }}</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 