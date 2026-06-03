<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-xl dark:bg-blue-500/10 dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Pengaturan Akun</h2>
                <p class="text-xs text-slate-400">Kelola profil, keamanan, dan preferensi akun Anda</p>
            </div>
        </div>
    </x-slot>

    {{-- PERUBAHAN: Mengubah pt-3 menjadi pt-0 dan menambahkan lg:-mt-4 untuk mendongak konten ke atas mendekati header --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-0 pb-8 bg-slate-50/50 min-h-screen dark:bg-slate-900/50 lg:-mt-4">
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
            
    {{-- ================= KOLOM KIRI (FOTO & INFO SINGKAT) ================= --}}
    <div
        x-data="{ openPreview: false }"
        class="space-y-6 xl:col-span-4"
    >

        {{-- Box Foto Profil --}}
        <div class="bg-white dark:bg-slate-800 p-7 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm text-center">

            <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 text-left mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Foto Profil
            </h3>

            <div class="relative w-40 h-40 mx-auto mb-5">

                @if($user->foto)
                    <img
                        src="{{ asset('storage/' . $user->foto) }}"
                        alt="Foto Profil"
                        class="w-40 h-40 rounded-full object-cover border-4 border-slate-100 shadow-sm"
                    >
                @else
                    <div class="w-40 h-40 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-16 h-16 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0
                                4 4 0 018 0zM12 14a7 7 0 00-7 7
                                h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif

                <label
                    for="foto"
                    class="absolute bottom-1 right-1 bg-blue-600 p-2 rounded-full text-white cursor-pointer hover:bg-blue-700 transition shadow-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>

            </div>

            <h4 class="font-bold text-slate-700 dark:text-white text-base">
                {{ $user->display_name }}
            </h4>

            <p class="text-xs text-slate-400 mb-4">
                {{ $user->email }}
            </p>

            <p
                id="selected-file"
                class="text-xs text-slate-500 mb-3"
            ></p>

            <div class="grid grid-cols-2 gap-2">

                @if($user->foto)
                    <button
                        type="button"
                        @click="openPreview = true"
                        class="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 flex items-center justify-center gap-1"
                    >
                        Lihat
                    </button>
                @endif

                <label
                    for="foto"
                    class="px-3 py-2 text-xs font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 flex items-center justify-center gap-1 cursor-pointer"
                >
                    Ganti
                </label>

            </div>

        </div>

        {{-- MODAL PREVIEW --}}
        @if($user->foto)
        <div
            x-show="openPreview"
            x-transition.opacity
            @keydown.escape.window="openPreview = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
            style="display:none;"
        >
            <div
                @click.away="openPreview = false"
                class="relative bg-white dark:bg-slate-800 rounded-3xl p-4 max-w-4xl w-full shadow-2xl"
            >

                <button
                    @click="openPreview = false"
                    class="absolute top-3 right-3 w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center"
                >
                    ✕
                </button>

                <img
                    src="{{ asset('storage/' . $user->foto) }}"
                    alt="Foto Profil"
                    class="w-full max-h-[85vh] object-contain rounded-2xl"
                >

            </div>
        </div>
        @endif

                {{-- Box Info Akun (Metadata) --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Info Akun
                    </h3>
                    
                    <div class="divide-y divide-slate-100 dark:divide-slate-700 text-xs text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between py-2.5 items-center">
                            <span>Role</span>
                            <span class="bg-indigo-50 text-[#006fcf] dark:bg-indigo-500/10 dark:text-indigo-400 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Admin
                            </span>
                        </div>
                        <div class="flex justify-between py-2.5 items-center">
                            <span>Status</span>
                            <span class="bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Aktif
                            </span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span>Bergabung</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">12 Aug 2025</span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span>Terakhir Dilihat</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">5 menit lalu</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================= KOLOM KANAN (FORM UTAMA & KEAMANAN) ================= --}}
            <div class="space-y-6 xl:col-span-8">
                
                {{-- Form 1: Informasi Profil --}}
                @include('profile.partials.update-profile-information-form')

                {{-- Form 2: Perbarui Password --}}
                @include('profile.partials.update-password-form')

                {{-- Box 3: Zona Bahaya (Hanya Logout Sederhana) --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-red-200 dark:border-red-900/30 shadow-sm">
                    <header class="mb-4">
                        <h3 class="text-sm font-bold text-red-800 dark:text-red-400 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Zona Bahaya
                        </h3>
                    </header>
                    
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-white dark:bg-slate-800 p-4 rounded-xl border border-red-100 dark:border-red-900/20">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white">Keluar dari Sesi</h4>
                            <p class="text-[11px] text-slate-400 mt-0.5">Akhiri sesi aktif Anda sekarang</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 rounded-xl text-xs font-semibold hover:bg-red-50 flex items-center gap-1.5 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>
</x-app-layout>