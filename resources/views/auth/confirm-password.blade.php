<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Konfirmasi Password</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">
            Ini area aman. Masukkan password untuk melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl shadow-[0_10px_20px_rgba(11,_44,_82,_0.20)] text-sm font-black text-white bg-gradient-to-b from-[#2f6aa8] to-[#214e83] hover:to-[#1b416c] transition active:scale-95">
                {{ __('Lanjutkan') }}
            </button>
        </div>
    </form>
</x-guest-layout>
