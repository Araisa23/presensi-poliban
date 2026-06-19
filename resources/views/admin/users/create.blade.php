<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah User') }}
                </h2>
                <p class="mt-1 text-black-70 text-sm font-medium">
                    Buat akun Administrator atau Pimpinan.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- NAMA --}}
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />

                        <x-text-input
                            id="name"
                            class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                        />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" />

                        <x-text-input
                            id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- PASSWORD --}}
                    <div x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" />

                        <div class="relative mt-1">

                            <input
                                :type="show ? 'text' : 'password'"
                                id="password"
                                name="password"
                                required
                                class="block w-full rounded-2xl border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 pr-12"
                            >

                            <button
                                type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500 hover:text-indigo-600"
                            >

                                <!-- Eye -->
                                <svg x-show="!show"
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

                                <!-- Eye Off -->
                                <svg x-show="show"
                                    x-cloak
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.228 6.228A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.08M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3l9 9m-18 0L21 3"/>
                                </svg>

                            </button>

                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- ROLE --}}
                    <div class="md:col-span-2">
                        <x-input-label for="role_id" :value="__('Role')" />

                        <select
                            id="role_id"
                            name="role_id"
                            class="block mt-2 w-full border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10 transition"
                            required
                        >
                            <option value="">-- Pilih Role --</option>

                            <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>
                                Administrator
                            </option>

                            <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>
                                Pimpinan
                            </option>
                        </select>

                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>

                </div>

                <div class="flex items-center justify-end mt-6 gap-3">

                    <x-back-button href="{{ url()->previous() }}">
                        Kembali
                    </x-back-button>

                    <x-primary-button class="gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>

                        Simpan User

                    </x-primary-button>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
