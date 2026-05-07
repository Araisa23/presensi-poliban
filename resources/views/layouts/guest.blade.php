<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen bg-gradient-to-b from-[#2f6aa8] via-[#2b5f98] to-[#214e83]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="text-center mb-8">
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                        Sistem Presensi Tenaga Kependidikan Berbasis Web dengan Pendeteksi Lokasi
                    </h1>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="hidden lg:block">
                        <div class="rounded-3xl bg-white/10 ring-1 ring-white/15 p-6 shadow-soft">
                            <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Informasi</p>
                            <p class="mt-3 text-white font-bold leading-relaxed">
                                Silakan login untuk mengakses dashboard dan fitur presensi (kamera & lokasi).
                            </p>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white/10 ring-1 ring-white/10 p-4">
                                    <p class="text-white/70 text-[10px] font-black uppercase tracking-[0.2em]">Fitur</p>
                                    <p class="mt-1 text-white font-black">Presensi Wajah</p>
                                </div>
                                <div class="rounded-2xl bg-white/10 ring-1 ring-white/10 p-4">
                                    <p class="text-white/70 text-[10px] font-black uppercase tracking-[0.2em]">Fitur</p>
                                    <p class="mt-1 text-white font-black">Deteksi Lokasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:flex lg:justify-end">
                        <div class="w-full sm:max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden ring-1 ring-black/10">
                            <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-2xl bg-white/10 ring-1 ring-white/15">
                                        <x-application-logo class="w-8 h-8 fill-current text-white" />
                                    </div>
                                    <div>
                                        <div class="text-sm font-black tracking-tight">PresenceHub</div>
                                        <div class="text-[10px] font-black uppercase tracking-[0.25em] text-white/70">Login</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mt-10 text-white/60 text-xs font-medium uppercase tracking-widest text-center">
                    © {{ date('Y') }} Politeknik Negeri Banjarmasin
                </p>
            </div>
        </div>

        <style>
            @keyframes fade-in-down {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-down { animation: fade-in-down 0.8s ease-out; }
            .animate-fade-in-up { animation: fade-in-up 0.8s ease-out 0.2s both; }
        </style>
    </body>
</html>
