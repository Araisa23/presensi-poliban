<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Presensi Tendik Poliban</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            :root { color-scheme: light; }
            @media (prefers-color-scheme: dark) { :root { color-scheme: dark; } }

            @keyframes fade-in {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-content {
                animation: fade-in 0.4s ease-out;
            }

            /* Subtle scrollbar polish */
            * { scrollbar-width: thin; scrollbar-color: rgba(100,116,139,.6) transparent; }
            *::-webkit-scrollbar { width: 10px; height: 10px; }
            *::-webkit-scrollbar-thumb { background: rgba(100,116,139,.35); border-radius: 999px; border: 3px solid transparent; background-clip: content-box; }
            *::-webkit-scrollbar-thumb:hover { background: rgba(100,116,139,.55); border: 3px solid transparent; background-clip: content-box; }
        </style>
        
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    </head>
<body x-data="{ sidebarOpen: false }" class="font-sans antialiased text-slate-900 bg-slate-50">

    <div class="min-h-screen flex flex-col">
        
        {{-- NAVBAR (Full Width dengan Gradasi & Logo Poliban) --}}
        <nav class="h-16 flex items-center justify-between bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white sticky top-0 z-40 shadow-sm">
            
            {{-- SISI KIRI: Tombol Mobile & Logo Poliban Baru --}}
            <div class="flex items-center h-full">
                {{-- Tombol Hamburger (Hanya muncul di Mobile/HP) --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden ml-4 p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Komponen Logo & Judul dari Kamu (Disesuaikan h-full agar pas dengan navbar) --}}
                <div class="h-full px-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm ring-1 ring-white/20">
                        <img src="{{ asset('images/poliban.png') }}" alt="Logo POLIBAN" class="w-7 h-7 object-contain">
                    </div>
                    <div class="leading-tight hidden sm:block"> {{-- Hidden sm:block menjaga agar text tidak hancur di layar hp yang sangat kecil --}}
                        <div class="text-sm font-black tracking-tight">Presensi Tenaga Kependidikan</div>
                        <div class="text-[10px] font-black uppercase tracking-[0.25em] text-white/70">Politeknik Negeri Banjarmasin</div>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN: Profil & Logout Dropdown --}}
    <div class="px-6 flex items-center">
        <x-dropdown align="right" width="72">

            <x-slot name="trigger">

                <button
                    class="inline-flex items-center gap-3 px-2 py-2
                    bg-white/10 hover:bg-white/20
                    border border-white/20
                    rounded-2xl transition-all duration-200">

                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">

                        @if(Auth::user()->foto)
                            <img
                                src="{{ asset('storage/' . Auth::user()->foto) }}"
                                alt="Profile"
                                class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                            </svg>
                        @endif

                    </div>

                    <div class="hidden sm:block text-left">

                        <div class="text-sm font-bold text-white leading-none">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-[11px] text-white/70">
                            {{ Auth::user()->email }}
                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-white/80"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7" />

                    </svg>

                </button>

            </x-slot>

        <x-slot name="content">

            <div class="w-56 bg-white rounded-2xl overflow-hidden shadow-xl border border-slate-100">

                {{-- HEADER MINI --}}
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                        Navigasi Profil
                    </p>
                </div>

                {{-- MENU --}}
                <div class="py-1">

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">

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

                        Profil Saya

                    </a>

                </div>

                {{-- LOGOUT --}}
                <div class="border-t border-slate-100 py-1">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition">

                                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>

                            Logout

                        </button>

                    </form>

                </div>

            </div>

        </x-slot>

        </x-dropdown>
    </div>
        </nav>

        <div class="flex flex-1 relative">
            
            {{-- OVERLAY BACKGROUND (Untuk Mobile saat Sidebar Terbuka) --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/40 z-40 lg:hidden" x-transition></div>

            {{-- SIDEBAR (Hanya di Bawah Navbar) --}}
            <aside class="fixed inset-y-0 left-0 lg:top-16 z-50 w-[265px] bg-[#004b8d] border-r border-white/10 transform transition-transform lg:translate-x-0 lg:static lg:h-[calc(100vh-4rem)] flex flex-col overflow-hidden"            
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                @include('layouts.sidebar')
            </aside>

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 p-6 overflow-y-auto lg:h-[calc(100vh-4rem)]">
                
                {{-- TAMBAHKAN BLOK INI: Cek apakah halaman mengirimkan slot header --}}
                @isset($header)
                    <header class="mb-6 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        {{ $header }}
                    </header>
                @endisset

                {{-- Isi Konten Halaman Utama --}}
                {{ $slot }}
                
            </main>
            
        </div>
    </div>

    @stack('scripts')
</body>
</html>