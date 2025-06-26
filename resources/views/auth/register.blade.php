<x-guest-layout>
    <div class="mb-8 text-center">
        <x-application-logo class="w-16 h-16 mx-auto mb-2 text-blue-600" />
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Kayıt Ol</h1>
        <p class="text-gray-500">MailTracker'a ücretsiz kaydolun ve e-posta kampanyalarınızı takip etmeye başlayın.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Ad Soyad')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-posta Adresi')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Şifre')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Şifreyi Onayla')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <x-primary-button class="w-full py-3 text-lg">Kayıt Ol</x-primary-button>
        <div class="text-center mt-4">
            <span class="text-gray-600 text-sm">Zaten hesabınız var mı?</span>
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm font-medium">Giriş Yap</a>
        </div>
    </form>
</x-guest-layout>
