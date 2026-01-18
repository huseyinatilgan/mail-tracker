<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-2xl text-slate-900">{{ $campaign->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        <span class="text-sm text-slate-500">Created {{ $campaign->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('campaigns.edit', $campaign) }}"
                    class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-sm">
                    Edit Campaign
                </a>
                <a href="{{ route('campaigns.index') }}"
                    class="px-4 py-2 bg-slate-100 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                    &larr; Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Stats Overview -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="glass-card p-4 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100 rounded-bl-full -mr-6 -mt-6 opacity-50">
                    </div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Views</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</dd>
                </div>
                <div class="glass-card p-4 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-green-100 rounded-bl-full -mr-6 -mt-6 opacity-50">
                    </div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Today</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['today'] ?? 0 }}</dd>
                </div>
                <div class="glass-card p-4 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-purple-100 rounded-bl-full -mr-6 -mt-6 opacity-50">
                    </div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">This Week</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['week'] ?? 0 }}</dd>
                </div>
                <div class="glass-card p-4 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-orange-100 rounded-bl-full -mr-6 -mt-6 opacity-50">
                    </div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">This Month</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['month'] ?? 0 }}</dd>
                </div>
            </div>

            <!-- Recent Activity List -->
            <div class="glass-card overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-display font-semibold text-lg text-slate-800">Recent Views</h3>
                    <button class="text-sm font-medium text-primary-600 hover:text-primary-700">Export CSV</button>
                </div>

                @if($campaign->events->count() > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach($campaign->events->take(10) as $event)
                            <div class="p-4 hover:bg-slate-50/50 transition-colors flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $event->ip_address ?? 'Unknown IP' }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ Str::limit($event->user_agent ?? 'Unknown Client', 40) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-slate-900">{{ $event->opened_at->format('H:i') }}</p>
                                    <p class="text-xs text-slate-500">{{ $event->opened_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">No views yet</h3>
                        <p class="mt-1 text-slate-500">Waiting for the first open event.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Tracking Details -->
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-slate-800 mb-4">Tracking Configuration</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tracking Key</label>
                        <div class="mt-1 flex items-center gap-2">
                             <code class="flex-1 block w-full px-3 py-2 rounded-lg bg-slate-100 text-slate-800 font-mono text-sm border border-slate-200">
                                {{ $campaign->key }}
                            </code>
                            <button onclick="copyToClipboard('{{ $campaign->key }}')" class="p-2 text-slate-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors border border-transparent hover:border-primary-100" title="Copy Key">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Embed Code</label>
                        <div class="mt-1 relative group">
                            <pre class="block w-full px-4 py-3 rounded-lg bg-slate-900 text-pink-400 font-mono text-xs overflow-x-auto selection:bg-pink-900 selection:text-white mb-2"><code>&lt;img src="{{ url('/track/' . $campaign->key) }}" width="1" height="1" style="display:none;" /&gt;</code></pre>
                            <button onclick="copyToClipboard('<img src=\'{{ url('/track/' . $campaign->key) }}\' width=\'1\' height=\'1\' style=\'display:none;\' />')" class="flex items-center gap-2 w-full justify-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:text-primary-600 hover:border-primary-200 hover:bg-primary-50 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                Copy Code
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integration Guide -->
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-slate-800 mb-4">How to Integrate</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs ring-4 ring-white">1</div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Copy the Code</p>
                            <p class="text-xs text-slate-500 mt-0.5">Click the "Copy Code" button above to get your unique tracking pixel.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs ring-4 ring-white">2</div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Insert into Email</p>
                            <p class="text-xs text-slate-500 mt-0.5">Open your email editor's HTML view (source code) and paste the code.</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs ring-4 ring-white">3</div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Place at Bottom</p>
                            <p class="text-xs text-slate-500 mt-0.5">Paste it at the very bottom of the body tag, just before <code>&lt;/body&gt;</code>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-slate-800 mb-4">Metadata</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Created</dt>
                        <dd class="font-medium text-slate-900">{{ $campaign->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Last Updated</dt>
                        <dd class="font-medium text-slate-900">{{ $campaign->updated_at->format('M d, Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Campaign ID</dt>
                        <dd class="font-medium text-slate-900">#{{ $campaign->id }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Optional: Show a toast
            });
        }
    </script>
</x-app-layout>