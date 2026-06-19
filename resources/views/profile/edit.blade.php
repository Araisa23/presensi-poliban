<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl
                        bg-gradient-to-br from-[#004b8d] to-[#006fcf]
                        text-white flex items-center justify-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                    Pengaturan Akun
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Kelola profil, keamanan, dan preferensi akun Anda
                </p>
            </div>
        </div>
    </x-slot>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8 bg-slate-50/50 min-h-screen dark:bg-slate-900/50 lg:-mt-4">
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

            {{-- ================= KOLOM KIRI (FOTO & INFO SINGKAT) ================= --}}
            <div
                x-data="{ openPreview: false }"
                class="space-y-6 xl:col-span-4"
            >

                {{-- Box Foto Profil --}}
                <div class="bg-white rounded-3xl dark:bg-slate-800 p-7 border border-slate-200 dark:border-slate-700 shadow-sm text-center">

                    <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 text-left mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632z" />
                        </svg>
                        Foto Profil
                    </h3>

                    {{-- AVATAR --}}
                    <div class="relative w-40 h-40 mx-auto mb-5">

                        @if($user->foto)
                            <img
                                id="foto-preview"
                                src="{{ asset('storage/' . $user->foto) }}"
                                alt="Foto Profil"
                                class="w-40 h-40 rounded-full object-cover border-4 border-slate-100 shadow-sm"
                            >
                        @else
                            <div id="foto-placeholder" class="w-40 h-40 rounded-full bg-slate-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-16 h-16 text-slate-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            {{-- Preview image (muncul setelah pilih file) --}}
                            <img
                                id="foto-preview"
                                src=""
                                alt="Foto Profil"
                                class="w-40 h-40 rounded-full object-cover border-4 border-slate-100 shadow-sm hidden"
                            >
                        @endif

                        {{-- Tombol kamera — trigger input foto di dalam form partial --}}
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

                    <p class="text-xs text-slate-400 mb-3">
                        {{ $user->email }}
                    </p>

                    {{-- Info file terpilih (sukses) --}}
                    <div id="file-info" class="hidden mt-2 mb-3">
                        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-xl px-3 py-2 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span id="selected-file-name" class="font-semibold text-blue-700 truncate max-w-[150px] text-left"></span>
                            <span id="selected-file-size" class="text-blue-500 shrink-0"></span>
                        </div>
                    </div>

                    {{-- Error ukuran melebihi 2MB --}}
                    <div id="file-error" class="hidden mt-2 mb-3">
                        <div class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-xl px-3 py-2 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-red-600 text-left">Ukuran file melebihi 2MB. Pilih file lain.</span>
                        </div>
                    </div>

                    {{-- Error format file --}}
                    <div id="file-error-format" class="hidden mt-2 mb-3">
                        <div class="flex items-center gap-2 bg-orange-50 border border-orange-200 rounded-xl px-3 py-2 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-orange-600 text-left">Format tidak didukung. Gunakan JPG, PNG, atau WEBP.</span>
                        </div>
                    </div>

                    {{-- Info rekomendasi --}}
                    <p class="text-[10px] text-slate-400 mb-4 leading-relaxed">
                        Format: JPG, PNG, WEBP &nbsp;·&nbsp; Maks. <span class="font-semibold text-slate-500">2 MB</span>
                    </p>

                    <div class="grid grid-cols gap-2">
                        @if($user->foto)
                            <button
                                type="button"
                                @click="openPreview = true"
                                class="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 flex items-center justify-center gap-1"
                            >
                                Lihat Foto
                            </button>
                        @endif
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
                    <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Info Akun
                    </h3>

                    <div class="divide-y divide-slate-100 dark:divide-slate-700 text-xs text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between py-2.5 items-center">
                            <span>Role</span>
                            <span class="bg-indigo-50 text-[#006fcf] dark:bg-indigo-500/10 dark:text-indigo-400 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ ucfirst(Auth::user()->role->name) }}
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
                            <span class="font-medium text-slate-800 dark:text-slate-200">
                                {{ $user->created_at->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span>Terakhir Update</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">
                                {{ $user->updated_at->diffForHumans() }}
                            </span>
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

            </div>

        </div>
    </section>

    @push('scripts')
    <script>
        function handleFotoChange(input) {
            const fileInfo     = document.getElementById('file-info');
            const fileError    = document.getElementById('file-error');
            const fileErrorFmt = document.getElementById('file-error-format');
            const fileName     = document.getElementById('selected-file-name');
            const fileSize     = document.getElementById('selected-file-size');
            const preview      = document.getElementById('foto-preview');
            const placeholder  = document.getElementById('foto-placeholder');

            // Reset semua notifikasi
            fileInfo.classList.add('hidden');
            fileError.classList.add('hidden');
            fileErrorFmt.classList.add('hidden');

            if (!input.files || !input.files[0]) return;

            const file    = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2 MB

            // Validasi format
            const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
            if (!allowed.includes(file.type)) {
                input.value = '';
                fileErrorFmt.classList.remove('hidden');
                return;
            }

            // Validasi ukuran
            if (file.size > maxSize) {
                input.value = '';
                fileError.classList.remove('hidden');
                return;
            }

            // Tampilkan preview langsung
            if (preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }

            // Tampilkan info file
            const sizeKB      = (file.size / 1024).toFixed(0);
            const sizeMB      = (file.size / 1024 / 1024).toFixed(2);
            const displaySize = file.size >= 1024 * 1024 ? sizeMB + ' MB' : sizeKB + ' KB';

            fileName.textContent = file.name;
            fileSize.textContent = '(' + displaySize + ')';
            fileInfo.classList.remove('hidden');
        }
    </script>
    @endpush

</x-app-layout>