<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-display font-bold text-3xl text-slate-800 leading-tight">Campaigns</h2>
                <p class="text-slate-500 mt-1">Manage and track your email performance</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block">
                    <input type="text" placeholder="Search campaigns..."
                        class="pl-10 pr-4 py-2 rounded-xl border-slate-200 bg-white/50 focus:border-primary-500 focus:ring-primary-500 text-sm w-64 shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('campaigns.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-slate-900/20 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Campaign
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-24 h-24 bg-primary-100 rounded-bl-full -mr-8 -mt-8 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <div class="relative z-10">
                <div class="text-sm font-medium text-slate-500">Total Campaigns</div>
                <div class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['total_campaigns'] ?? 0 }}</div>
            </div>
        </div>

        <div class="glass-card p-6 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-24 h-24 bg-green-100 rounded-bl-full -mr-8 -mt-8 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <div class="relative z-10">
                <div class="text-sm font-medium text-slate-500">Total Opens</div>
                <div class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['total_events'] ?? 0 }}</div>
            </div>
        </div>

        <div class="glass-card p-6 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-24 h-24 bg-purple-100 rounded-bl-full -mr-8 -mt-8 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <div class="relative z-10">
                <div class="text-sm font-medium text-slate-500">Avg. Reads/Campaign</div>
                <div class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['average_reads'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Campaign List -->
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-display font-semibold text-lg text-slate-800">All Campaigns</h3>
            <div class="flex gap-2">
                <select
                    class="text-sm border-slate-200 rounded-lg text-slate-600 focus:ring-primary-500 focus:border-primary-500">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Archived</option>
                </select>
                <select
                    class="text-sm border-slate-200 rounded-lg text-slate-600 focus:ring-primary-500 focus:border-primary-500">
                    <option>Newest First</option>
                    <option>Oldest First</option>
                </select>
            </div>
        </div>

        @if($campaigns->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($campaigns as $campaign)
                    <div class="p-6 hover:bg-slate-50/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-primary-500/20">
                                    {{ substr($campaign->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-900 text-lg">{{ $campaign->name }}</h4>
                                    <div class="flex items-center gap-3 mt-1 text-sm text-slate-500">
                                        <div class="flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded-md">
                                            <span class="font-mono text-xs">{{ $campaign->key }}</span>
                                            <button onclick="copyToClipboard(event, '{{ $campaign->key }}')"
                                                class="hover:text-primary-600 transition-colors" title="Copy Key">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <span>•</span>
                                        <span>Created {{ $campaign->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-8">
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-slate-900">{{ $campaign->events_count ?? 0 }}</div>
                                    <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Opens</div>
                                </div>

                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <!-- View/Edit -->
                                    <a href="{{ route('campaigns.show', $campaign) }}"
                                        class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                                        title="View Details">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('campaigns.edit', $campaign) }}"
                                        class="p-2 text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($campaigns instanceof \Illuminate\Pagination\LengthAwarePaginator && $campaigns->hasPages())
                <div class="p-6 border-t border-slate-100">
                    {{ $campaigns->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">No campaigns yet</h3>
                <p class="mt-1 text-slate-500">Get started by creating your first email campaign.</p>
                <div class="mt-6">
                    <a href="{{ route('campaigns.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Create Campaign
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard(event, text) {
            event.preventDefault();
            navigator.clipboard.writeText(text).then(() => {
                // Could add a toast notification here
            });
        }
    </script>
</x-app-layout>