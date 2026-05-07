<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Reset Kata Sandi</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">
            Masukkan email kamu. Kami akan kirim link untuk reset password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl shadow-[0_10px_20px_rgba(11,_44,_82,_0.20)] text-sm font-black text-white bg-gradient-to-b from-[#2f6aa8] to-[#214e83] hover:to-[#1b416c] transition active:scale-95">
                {{ __('Kirim Link Reset') }}
            </button>
        </div>
    </form>
</x-guest-layout>
