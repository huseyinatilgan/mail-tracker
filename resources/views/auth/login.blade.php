<x-guest-layout>
    <div class="mb-8 text-center">
        <x-application-logo class="w-16 h-16 mx-auto mb-2 text-blue-600" />
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Giriş Yap</h1>
        <p class="text-gray-500">MailTracker hesabınıza erişin ve kampanyalarınızı yönetin.</p>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-posta Adresi')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Şifre')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Beni hatırla</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                    Şifremi unuttum
                </a>
            @endif
        </div>
        <x-primary-button class="w-full py-3 text-lg">Giriş Yap</x-primary-button>
        <div class="text-center mt-4">
            <span class="text-gray-600 text-sm">Hesabınız yok mu?</span>
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline text-sm font-medium">Kayıt Ol</a>
        </div>
    </form>
</x-guest-layout>
