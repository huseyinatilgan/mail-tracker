<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MailTracker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 relative overflow-x-hidden">
    <!-- Gradient Blobs Background -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 glass border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-2xl text-slate-800">MailTracker</span>
                    </div>
                    <div class="flex gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-xl bg-white text-slate-700 font-semibold shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 border border-slate-100">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl text-slate-600 font-medium hover:text-slate-900 transition-colors">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-semibold shadow-lg shadow-slate-900/20 hover:shadow-xl hover:shadow-slate-900/30 transition-all hover:-translate-y-0.5">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-4xl mx-auto mb-20">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/50 backdrop-blur-sm border border-white/40 text-sm font-medium text-primary-600 mb-8 animate-fade-in">
                        <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                        New 2026 Version
                    </div>
                    <h1 class="font-display font-bold text-6xl md:text-7xl lg:text-8xl tracking-tight text-slate-900 mb-8 animate-fade-in" style="animation-delay: 100ms;">
                        Track emails <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-indigo-600 to-cyan-500">with precision</span>
                    </h1>
                    <p class="text-xl text-slate-600 leading-relaxed mb-10 max-w-2xl mx-auto animate-fade-in" style="animation-delay: 200ms;">
                        Invisible tracking pixels, real-time analytics, and beautiful reports. 
                        The modern way to understand your email engagement.
                    </p>
                    <div class="flex justify-center gap-4 animate-fade-in" style="animation-delay: 300ms;">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-bold text-lg shadow-xl shadow-primary-500/30 hover:shadow-2xl hover:shadow-primary-500/40 hover:-translate-y-1 transition-all duration-300">
                            Start Tracking Free
                        </a>
                        <a href="#features" class="px-8 py-4 rounded-2xl bg-white text-slate-700 font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Features Grid -->
                <div id="features" class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20">
                    <!-- Feature 1 -->
                    <div class="glass-card p-8 group hover:bg-white transition-colors duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-primary-50 mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-2xl mb-3 text-slate-900">Invisible Tracking</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Our 1x1 pixel is undetectable and loads instantly, giving you accurate open rates without disturbing your user's experience.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="glass-card p-8 group hover:bg-white transition-colors duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-2xl mb-3 text-slate-900">Real-time Analytics</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Watch opens happen live on your dashboard. Filter by location, device, and time to understand your audience better.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="glass-card p-8 group hover:bg-white transition-colors duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-pink-50 mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-2xl mb-3 text-slate-900">Secure & Private</h3>
                        <p class="text-slate-600 leading-relaxed">
                            We don't read your emails. We only track the open event. Your data is encrypted and safe with us.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} MailTracker. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-500 hover:text-primary-600 text-sm font-medium transition-colors">Privacy</a>
                    <a href="#" class="text-slate-500 hover:text-primary-600 text-sm font-medium transition-colors">Terms</a>
                    <a href="#" class="text-slate-500 hover:text-primary-600 text-sm font-medium transition-colors">Contact</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
