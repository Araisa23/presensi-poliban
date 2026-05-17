<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Presensi Tendik Poliban</title>

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

            /* Subtle scrollbar polish (safe, optional) */
            * { scrollbar-width: thin; scrollbar-color: rgba(100,116,139,.6) transparent; }
            *::-webkit-scrollbar { width: 10px; height: 10px; }
            *::-webkit-scrollbar-thumb { background: rgba(100,116,139,.35); border-radius: 999px; border: 3px solid transparent; background-clip: content-box; }
            *::-webkit-scrollbar-thumb:hover { background: rgba(100,116,139,.55); border: 3px solid transparent; background-clip: content-box; }
        </style>
        
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-100">
        <div class="min-h-screen flex">
            @include('layouts.sidebar')

            <div class="flex-1 min-w-0">
                <div class="h-14 px-4 sm:px-6 flex items-center justify-between bg-gradient-to-r from-[#0b2c52] to-indigo-700 text-white border-b border-white/10">
                    <div class="flex items-center gap-3 lg:hidden">
                        <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-2xl bg-white/10 ring-1 ring-white/15 flex items-center justify-center font-black">
                            P
                        </a>
                        <div class="text-sm font-black tracking-tight">Presensi Tendik Poliban</div>
                    </div>

                    <div class="hidden lg:block text-sm font-black tracking-tight opacity-90">
                        {{ config('app.name', 'Presensi Tendik Poliban') }}
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 ring-1 ring-white/15">
                            <span class="text-xs font-black uppercase tracking-[0.25em] text-white/70">{{ Auth::user()->role->name ?? 'user' }}</span>
                        </div>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 px-3 py-2 text-sm font-bold rounded-2xl text-white bg-white/10 hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                                    <span class="max-w-[160px] truncate">{{ Auth::user()->name }}</span>
                                    <svg class="fill-current h-4 w-4 opacity-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                @if (isset($header))
                    <header class="px-4 sm:px-6 py-6">
                        <div class="rounded-2xl bg-white ring-1 ring-slate-900/10 shadow-soft px-6 py-5">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="animate-content px-4 sm:px-6 py-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
