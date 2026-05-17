<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">
            Selamat Datang
        </h2>

        <p class="text-slate-500 text-sm font-medium">
            Login untuk mengakses dashboard sistem presensi.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- LOGIN -->
        <div class="space-y-2">
            <x-input-label 
                for="login"
                :value="__('Email / NIP')"
                class="font-bold text-xs uppercase tracking-widest text-gray-400"
            />

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                    </svg>
                </div>

                <x-text-input
                    id="login"
                    class="block w-full pl-10 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 rounded-xl"
                    type="text"
                    name="login"
                    :value="old('login')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan Email atau NIP"
                />
            </div>

            <x-input-error :messages="$errors->get('login')" class="mt-2 text-xs" />
        </div>

        <!-- PASSWORD -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <x-input-label
                    for="password"
                    :value="__('Password')"
                    class="font-bold text-xs uppercase tracking-widest text-gray-400"
                />
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>

                <x-text-input
                    id="password"
                    class="block w-full pl-10 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 rounded-xl text-lg"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <!-- REMEMBER -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                class="w-4 h-4 text-indigo-600 bg-gray-50 border-gray-200 rounded focus:ring-indigo-500 focus:ring-2"
                name="remember"
            >

            <label for="remember_me"
                class="ml-2 text-sm font-medium text-gray-500">
                Ingat saya
            </label>
        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full flex justify-center py-3.5 px-4 rounded-xl shadow-[0_10px_20px_rgba(11,_44,_82,_0.25)] text-sm font-black text-white bg-gradient-to-b from-[#2f6aa8] to-[#214e83] hover:to-[#1b416c] transition-all duration-200 active:scale-95">

            Login
        </button>
    </form>
</x-guest-layout>