<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-plus me-2"></i>
                {{ __('Yeni Kampanya Oluştur') }}
            </h2>
            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
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
                    <form action="{{ route('campaigns.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-1"></i>
                                Kampanya Adı <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                Tracking Key Otomatik Oluşturulacak
                            </h6>
                            <p class="mb-0">
                                Kampanya oluşturulduktan sonra size benzersiz bir tracking key verilecek. 
                                Bu key'i e-postalarınıza ekleyerek okunma durumunu takip edebilirsiniz.
                            </p>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>
                                İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Kampanya Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kullanım Rehberi -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-question-circle me-2"></i>
                        Nasıl Kullanılır?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-1 me-2"></i>Kampanya Oluşturun</h6>
                            <p class="text-muted">Yukarıdaki formu doldurarak kampanyanızı oluşturun.</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-2 me-2"></i>Tracking Key'i Alın</h6>
                            <p class="text-muted">Kampanya oluşturulduktan sonra size benzersiz bir key verilecek.</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-3 me-2"></i>E-postaya Ekleyin</h6>
                            <p class="text-muted">Bu key'i e-postalarınıza şu şekilde ekleyin:</p>
                            <code>&lt;img src="{{ url('/track/YOUR_KEY') }}" width="1" height="1"&gt;</code>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-4 me-2"></i>Takip Edin</h6>
                            <p class="text-muted">E-posta açıldığında otomatik olarak okunma kaydı oluşacak.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 