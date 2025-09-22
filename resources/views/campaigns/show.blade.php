<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-eye me-2"></i>
                {{ $campaign->name }}
            </h2>
            <div>
                <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>
                    Düzenle
                </a>
                <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <!-- Kampanya Bilgileri -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        Kampanya Bilgileri
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Kampanya Adı:</strong></td>
                            <td>{{ $campaign->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tracking Key:</strong></td>
                            <td>
                                <code class="bg-light p-1 rounded">{{ $campaign->key }}</code>
                                <button class="btn btn-sm btn-outline-secondary ms-2"
                                        onclick="copyToClipboard(event, '{{ $campaign->key }}')"
                                        data-success-icon="fas fa-check"
                                        data-success-classes="btn-success"
                                        data-success-remove-classes="btn-outline-secondary"
                                        title="Key'i kopyala">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Oluşturulma:</strong></td>
                            <td>{{ $campaign->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Son Güncelleme:</strong></td>
                            <td>{{ $campaign->updated_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tracking Kodu -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-code me-2"></i>
                        Tracking Kodu
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Bu kodu e-postalarınıza ekleyin:</p>
                    <div class="bg-dark text-light p-3 rounded">
                        <code class="text-light">
                            &lt;img src="{{ url('/track/' . $campaign->key) }}" width="1" height="1"&gt;
                        </code>
                    </div>
                    <button class="btn btn-sm btn-outline-primary mt-2"
                            onclick="copyToClipboard(event, '&lt;img src=&quot;{{ url('/track/' . $campaign->key) }}&quot; width=&quot;1&quot; height=&quot;1&quot;&gt;')"
                            data-success-icon="fas fa-check me-2"
                            data-success-classes="btn-success"
                            data-success-remove-classes="btn-outline-primary"
                            title="Tracking kodunu kopyala">
                        <i class="fas fa-copy me-2"></i>
                        Kodu Kopyala
                    </button>
                </div>
            </div>
        </div>

        <!-- İstatistikler -->
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Toplam Okunma
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Bugün
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Bu Hafta
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['week'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Bu Ay
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['month'] ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Son Okunmalar -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>
                        Son Okunmalar
                    </h6>
                </div>
                <div class="card-body">
                    @if($campaign->events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Okunma Tarihi</th>
                                        <th>IP Adresi</th>
                                        <th>User Agent</th>
                                        <th>E-posta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaign->events->take(10) as $event)
                                        <tr>
                                            <td>{{ $event->opened_at->format('d.m.Y H:i:s') }}</td>
                                            <td><code>{{ $event->ip_address ?? 'Bilinmiyor' }}</code></td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ Str::limit($event->user_agent ?? 'Bilinmiyor', 50) }}
                                                </small>
                                            </td>
                                            <td>{{ $event->user_email ?? 'Bilinmiyor' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($campaign->events->count() > 10)
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>
                                    Tüm Okunmaları Görüntüle ({{ $campaign->events->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Henüz okunma kaydı bulunmuyor.</p>
                            <p class="text-muted">Tracking kodunu e-postalarınıza ekledikten sonra okunma kayıtları burada görünecek.</p>
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
                const successIcon = button.dataset.successIcon || 'fas fa-check';
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