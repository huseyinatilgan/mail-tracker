<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-2xl text-slate-900">Edit Campaign</h2>
                    <p class="text-sm text-slate-500">Update campaign details</p>
                </div>
            </div>
            <a href="{{ route('campaigns.show', $campaign) }}"
                class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-sm">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-8">
                <form action="{{ route('campaigns.update', $campaign) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Campaign Name</label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name', $campaign->name) }}"
                                placeholder="e.g. Summer Sale 2026 Newsletter" required
                                class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:ring-primary-500 transition-all shadow-sm">
                            <div
                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-slate-500">Give your campaign a descriptive name to identify it
                            easily in reports.</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-bold text-sm shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-200">
                            Update Campaign
                        </button>
                        <a href="{{ route('campaigns.show', $campaign) }}"
                            class="px-6 py-3 rounded-xl text-slate-600 font-medium hover:text-slate-900 hover:bg-slate-100 transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar / Info -->
        <div class="space-y-6">
            <h3 class="font-display font-semibold text-lg text-slate-800">Campaign Info</h3>

            <!-- Tracking Key -->
            <div class="glass-card p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-primary-100 rounded-bl-full -mr-8 -mt-8 opacity-50">
                </div>
                <div class="flex gap-4">
                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div class="w-full">
                        <h4 class="font-medium text-slate-900">Tracking Key</h4>
                        <p class="text-sm text-slate-500 mt-1">Cannot be changed</p>
                        <div
                            class="mt-2 bg-slate-100 rounded-lg p-3 font-mono text-sm text-slate-600 break-all border border-slate-200">
                            {{ $campaign->key }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="glass-card p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-100 rounded-bl-full -mr-8 -mt-8 opacity-50">
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Created</span>
                        <span
                            class="text-sm font-medium text-slate-900">{{ $campaign->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Last Updated</span>
                        <span
                            class="text-sm font-medium text-slate-900">{{ $campaign->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>