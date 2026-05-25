<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Presensi Tendik Poliban</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                        boxShadow: {
                            'soft': '0 10px 30px rgba(2, 6, 23, 0.08)',
                            'lift': '0 18px 45px rgba(2, 6, 23, 0.12)',
                        },
                    },
                },
            }
        </script>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="min-h-screen bg-gradient-to-b from-[#2f6aa8] via-[#2b5f98] to-[#214e83]">
            <header class="sticky top-0 z-50 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white border-b border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-2xl bg-white/10 shadow-soft ring-1 ring-white/15">
                            <svg viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                                <path d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253Z" fill="#ffffff"/>
                            </svg>
                        </div>
                        <span class="font-black tracking-tight">Presensi Tendik Poliban</span>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white/80 text-slate-700 hover:bg-white ring-1 ring-slate-900/10 shadow-soft transition">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </header>

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-black-70">Sistem Presensi Berbasis Lokasi</p>
                        <h1 class="mt-3 text-4xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                            Presensi jadi cepat, akurat, dan rapi.
                        </h1>
                        <p class="mt-4 text-base font-medium text-white/80 leading-relaxed">
                            Presensi Tendik Poliban membantu pegawai melakukan presensi menggunakan pendeteksian lokasi dan foto, serta menyediakan monitoring dan laporan untuk pimpinan.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white text-slate-800 shadow-soft ring-1 ring-white/40 transition hover:bg-white/90">
                                Mulai Login
                            </a>
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                                Lihat Dashboard
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -top-10 -right-10 w-56 h-56 bg-indigo-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-56 h-56 bg-sky-500/10 rounded-full blur-3xl"></div>
                        <div class="bg-white border border-slate-100/70 shadow-soft rounded-3xl overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white">
                                <p class="text-black-70 text-[10px] font-black uppercase tracking-[0.25em]">Preview</p>
                                <p class="mt-1 font-black">Dashboard Presensi</p>
                            </div>
                            <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-6 rounded-3xl bg-slate-50/70 border border-slate-100/70 shadow-soft">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Presensi</p>
                                    <p class="mt-2 text-lg font-black text-slate-800">Foto + Lokasi</p>
                                    <p class="mt-1 text-xs font-medium text-slate-500">Validasi kehadiran lebih kuat.</p>
                                </div>
                                <div class="p-6 rounded-3xl bg-slate-50/70 border border-slate-100/70 shadow-soft">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Monitoring</p>
                                    <p class="mt-2 text-lg font-black text-slate-800">Realtime</p>
                                    <p class="mt-1 text-xs font-medium text-slate-500">Pantau presensi harian.</p>
                                </div>
                                <div class="p-6 rounded-3xl bg-slate-50/70 border border-slate-100/70 shadow-soft">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Laporan</p>
                                    <p class="mt-2 text-lg font-black text-slate-800">Harian & Bulanan</p>
                                    <p class="mt-1 text-xs font-medium text-slate-500">Export PDF/Excel.</p>
                                </div>
                                <div class="p-6 rounded-3xl bg-slate-50/70 border border-slate-100/70 shadow-soft">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Admin</p>
                                    <p class="mt-2 text-lg font-black text-slate-800">Manajemen</p>
                                    <p class="mt-1 text-xs font-medium text-slate-500">Unit, lokasi, jadwal, users.</p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-14 pt-8 border-t border-white/15 text-center text-xs font-medium text-black-70">
                    © {{ date('Y') }} Presensi Tendik Poliban. All rights reserved.
                </footer>
            </main>
        </div>
    </body>
</html>
