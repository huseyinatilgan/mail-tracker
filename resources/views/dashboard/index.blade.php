<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display font-semibold text-3xl text-slate-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-slate-500">
                Welcome back, {{ Auth::user()->name }}
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid (Bento Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Campaigns -->
        <div class="glass-card p-6 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-primary-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <dt class="text-sm font-medium text-slate-500 truncate z-10 relative">Total Campaigns</dt>
            <dd class="mt-2 text-4xl font-bold text-slate-900 z-10 relative">{{ $stats['total_campaigns'] ?? 0 }}</dd>
            <div class="mt-4 flex items-center text-sm text-green-600 font-medium z-10 relative">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>+{{ $stats['campaigns_this_month'] ?? 0 }} this month</span>
            </div>
        </div>

        <!-- Emails Sent -->
        <div class="glass-card p-6 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-cyan-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <dt class="text-sm font-medium text-slate-500 truncate z-10 relative">Total Views</dt>
            <dd class="mt-2 text-4xl font-bold text-slate-900 z-10 relative">{{ $stats['total_views'] ?? 0 }}</dd>
            <div class="mt-4 flex items-center text-sm text-green-600 font-medium z-10 relative">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>+{{ $stats['views_this_week'] ?? 0 }} this week</span>
            </div>
        </div>

        <!-- Open Rate -->
        <div class="glass-card p-6 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-pink-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <dt class="text-sm font-medium text-slate-500 truncate z-10 relative">Views Today</dt>
            <dd class="mt-2 text-4xl font-bold text-slate-900 z-10 relative">{{ $stats['views_today'] ?? 0 }}</dd>
            <div class="mt-4 flex items-center text-sm text-slate-400 font-medium z-10 relative">
                <span>{{ $stats['views_yesterday'] ?? 0 }} yesterday</span>
            </div>
        </div>

        <!-- User Engagement -->
        <div class="glass-card p-6 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-indigo-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition-transform">
            </div>
            <dt class="text-sm font-medium text-slate-500 truncate z-10 relative">Platform Health</dt>
            <dd class="mt-2 text-4xl font-bold text-slate-900 z-10 relative">100%</dd>
            <div class="mt-4 flex items-center text-sm text-slate-400 font-medium z-10 relative">
                <span>All systems operational</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity Chart Area (Placeholder) -->
        <div class="lg:col-span-2 glass-card p-6 min-h-[400px]">
            <h3 class="font-display font-semibold text-lg text-slate-800 mb-6">Engagement Overview</h3>
            <div
                class="w-full h-64 bg-slate-50/50 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 font-medium overflow-hidden relative">
                <!-- Using a simple HTML/CSS bar chart representation since we dont have chart.js setup in the example -->
                <div class="flex items-end gap-2 h-40 w-full px-4 justify-between">
                    @foreach($chartData['data'] as $index => $data)
                        <div class="flex flex-col items-center gap-2 group w-full">
                            <div class="w-full bg-primary-100 rounded-t-lg relative group-hover:bg-primary-200 transition-colors"
                                style="height: {{ $data > 0 ? ($data * 10) + 10 : 2 }}px; max-height: 100%;">
                                <div
                                    class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs py-1 px-2 rounded pointer-events-none transition-opacity">
                                    {{ $data }} views
                                </div>
                            </div>
                            <span class="text-xs text-slate-500">{{ $chartData['labels'][$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Campaigns List -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-display font-semibold text-lg text-slate-800">Recent Campaigns</h3>
                <a href="{{ route('campaigns.index') }}"
                    class="text-sm font-medium text-primary-600 hover:text-primary-700">View all</a>
            </div>

            <div class="space-y-4">
                @forelse($recentCampaigns as $campaign)
                    <!-- Campaign Item -->
                    <a href="{{ route('campaigns.show', $campaign) }}"
                        class="flex items-center p-3 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer group">
                        <div
                            class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $campaign->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $campaign->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="inline-flex items-center text-sm font-semibold text-slate-900">
                            {{ $campaign->events_count }}
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4">
                        <p class="text-sm text-slate-500">No campaigns yet</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('campaigns.create') }}"
                class="w-full mt-6 flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transform transition-all hover:-translate-y-0.5">
                New Campaign
            </a>
        </div>
    </div>
</x-app-layout>