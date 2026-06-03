<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Presensi Login</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body
class="min-h-screen flex items-center justify-center px-4 py-8 bg-cover bg-center bg-no-repeat relative overflow-hidden"
style="background-image: url('{{ asset('images/bg-poliban.jpg') }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-[3px]"></div>

    <!-- Main Card -->
    <div class="relative z-10 w-full max-w-5xl bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[35px] overflow-hidden shadow-2xl grid lg:grid-cols-2">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex flex-col justify-between p-10 relative">

            <div>
                <p class="uppercase tracking-[0.35em] text-white/80 text-sm font-semibold">
                    PRESENSI
                </p>

                <h1 class="mt-6 text-5xl font-extrabold leading-tight text-white">
                    Sistem Presensi
                    <span class="block text-white/80">
                        Tenaga Kependidikan
                    </span>
                </h1>

                <p class="mt-5 text-white/80 text-lg leading-relaxed max-w-md">
                    Sistem presensi modern berbasis website dengan fitur lokasi dan kamera untuk lingkungan Politeknik Negeri Banjarmasin.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-lg flex items-center justify-center border border-white/20">
                    <img 
                        src="{{ asset('images/poliban.png') }}"
                        alt="Poliban"
                        class="w-10 h-10 object-contain"
                    >
                </div>

                <div>
                    <p class="text-white font-semibold">
                        Politeknik Negeri Banjarmasin
                    </p>

                    <p class="text-white/60 text-sm">
                        Presensi © {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="bg-white px-8 py-10 sm:px-12 flex items-center">

            <div class="w-full">

                <!-- Logo -->
                <div class="flex justify-center">
                    <div class="bg-blue-50 shadow-lg p-4 rounded-3xl">
                        <img 
                            src="{{ asset('images/poliban.png') }}"
                            alt="Logo"
                            class="w-20 h-20 object-contain"
                        >
                    </div>
                </div>

                <!-- Heading -->
                <div class="text-center mt-6">
                    <h2 class="text-3xl font-extrabold text-slate-800">
                        Selamat Datang
                    </h2>

                    <p class="mt-2 text-slate-500 text-sm leading-relaxed">
                        Login untuk mengakses dashboard sistem presensi.
                    </p>
                </div>

                <!-- ERROR -->
                @if ($errors->any())
                    <div class="mt-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-2xl text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">

                    @csrf

                    <!-- LOGIN -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Email / NIP
                        </label>

                        <input
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="Masukkan Email atau NIP"
                            required
                            autofocus
                            class="w-full rounded-2xl border border-slate-200 px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        >
                    </div>

                    <!-- PASSWORD -->
                    <div>

                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-semibold text-slate-700">
                                Password
                            </label>
                        </div>

                        <div class="relative">

                            <!-- INPUT -->
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full rounded-2xl border border-slate-200 px-5 py-3.5 pr-14 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            >

                            <!-- BUTTON EYE -->
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-400 hover:text-slate-700 transition">

                                <!-- EYE OPEN -->
                                <svg id="eyeOpen"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <!-- EYE CLOSED -->
                                <svg id="eyeClose"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 hidden"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3l18 18"/>

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10.477 10.489A3 3 0 0013.5 13.5"/>

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.227"/>

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7a9.95 9.95 0 005.772-1.772"/>
                                </svg>

                            </button>

                        </div>

                    </div>

                    <!-- REMEMBER -->
                    <div class="flex items-center gap-3">

                        <input 
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        >

                        <p class="text-sm text-slate-600">
                            Remember me
                        </p>

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-[#0f2f57] to-[#2f6aa8] hover:opacity-90 text-white font-bold py-3.5 rounded-2xl shadow-lg transition duration-300">

                        Login

                    </button>

                </form>

            </div>
        </div>

    </div>

    <!-- SCRIPT SHOW PASSWORD -->
    <script>

        function togglePassword() {

            const passwordInput = document.getElementById('password');

            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClose = document.getElementById('eyeClose');

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeOpen.classList.add('hidden');
                eyeClose.classList.remove('hidden');

            } else {

                passwordInput.type = 'password';

                eyeOpen.classList.remove('hidden');
                eyeClose.classList.add('hidden');
            }
        }

    </script>

</body>
</html>