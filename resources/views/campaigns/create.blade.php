<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-2xl text-slate-900">New Campaign</h2>
                    <p class="text-sm text-slate-500">Create a tracking campaign and get your invisible pixel</p>
                </div>
            </div>
            <a href="{{ route('campaigns.index') }}"
                class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-sm">
                ← Back to Campaigns
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-8">
                <form action="{{ route('campaigns.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Campaign Name</label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
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

                    <div class="bg-primary-50/50 rounded-xl p-4 border border-primary-100 flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-primary-900">Automatic Key Generation</h4>
                            <p class="mt-1 text-sm text-primary-700 leading-relaxed">
                                Once you create the campaign, we'll generate a unique 20-character tracking key for you.
                                You'll need this key to embed the tracking pixel.
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-bold text-sm shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-200">
                            Create Campaign
                        </button>
                        <a href="{{ route('campaigns.index') }}"
                            class="px-6 py-3 rounded-xl text-slate-600 font-medium hover:text-slate-900 hover:bg-slate-100 transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar / Guide -->
        <div class="space-y-6">
            <h3 class="font-display font-semibold text-lg text-slate-800">Quick Guide</h3>

            <!-- Step 1 -->
            <div class="glass-card p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-primary-100 rounded-bl-full -mr-8 -mt-8 opacity-50">
                </div>
                <div class="flex gap-4">
                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm">
                        1</div>
                    <div>
                        <h4 class="font-medium text-slate-900">Create Campaign</h4>
                        <p class="text-sm text-slate-500 mt-1">Fill out the form to register your new email campaign.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="glass-card p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-cyan-100 rounded-bl-full -mr-8 -mt-8 opacity-50"></div>
                <div class="flex gap-4">
                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-sm">
                        2</div>
                    <div>
                        <h4 class="font-medium text-slate-900">Get Tracking Key</h4>
                        <p class="text-sm text-slate-500 mt-1">Copy the unique ID generated for your campaign.</p>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="glass-card p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-pink-100 rounded-bl-full -mr-8 -mt-8 opacity-50"></div>
                <div class="flex gap-4">
                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold text-sm">
                        3</div>
                    <div>
                        <h4 class="font-medium text-slate-900">Embed Pixel</h4>
                        <p class="text-sm text-slate-500 mt-1">Add the HTML code to your email template.</p>
                        <div class="mt-3 bg-slate-900 rounded-lg p-3 overflow-x-auto">
                            <code class="text-xs text-pink-400 font-mono">&lt;img src="..."&gt;</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>