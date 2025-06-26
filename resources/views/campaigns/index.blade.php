<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-bullhorn me-2"></i>
                {{ __('Kampanyalar') }}
            </h2>
            <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Yeni Kampanya
            </a>
        </div>
    </x-slot>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>
                Kampanya Listesi
            </h6>
        </div>
        <div class="card-body">
            @if($campaigns->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>Kampanya Adı</th>
                                <th>Tracking Key</th>
                                <th>Okunma Sayısı</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>Son Güncelleme</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $campaign)
                                <tr>
                                    <td>
                                        <strong>{{ $campaign->name }}</strong>
                                    </td>
                                    <td>
                                        <code class="bg-light p-1 rounded">{{ $campaign->key }}</code>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" 
                                                onclick="copyToClipboard('{{ $campaign->key }}')"
                                                title="Key'i kopyala">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $campaign->events_count ?? 0 }}</span>
                                    </td>
                                    <td>{{ $campaign->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $campaign->updated_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('campaigns.show', $campaign) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Görüntüle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Düzenle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('campaigns.destroy', $campaign) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bu kampanyayı silmek istediğinizden emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Sil">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500 mb-3">Henüz kampanya oluşturmadınız</h4>
                    <p class="text-gray-400 mb-4">İlk e-posta kampanyanızı oluşturarak tracking'e başlayın.</p>
                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        İlk Kampanyanızı Oluşturun
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Başarılı kopyalama bildirimi
                const button = event.target.closest('button');
                const originalIcon = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalIcon;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-secondary');
                }, 1000);
            });
        }
    </script>
</x-app-layout> 