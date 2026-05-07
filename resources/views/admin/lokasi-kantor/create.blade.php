<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.lokasi-kantor.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">Admin</p>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Lokasi Kantor') }}
                </h2>
                <p class="mt-1 text-white/70 text-sm font-medium">Masukkan nama lokasi, koordinat, dan radius presensi.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">
                <form action="{{ route('admin.lokasi-kantor.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="nama_lokasi" :value="__('Nama Lokasi')" />
                            <x-text-input id="nama_lokasi" class="block mt-1 w-full" type="text" name="nama_lokasi" :value="old('nama_lokasi')" required placeholder="Contoh: Gedung Rektorat" />
                            <x-input-error :messages="$errors->get('nama_lokasi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="latitude" :value="__('Latitude')" />
                            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" required placeholder="-6.123456" />
                            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="longitude" :value="__('Longitude')" />
                            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" required placeholder="106.123456" />
                            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="radius" :value="__('Radius (Meter)')" />
                            <x-text-input id="radius" class="block mt-1 w-full" type="number" name="radius" :value="old('radius', 50)" required />
                            <x-input-error :messages="$errors->get('radius')" class="mt-2" />
                        </div>
                    </div>

                    <div class="p-5 rounded-3xl bg-slate-50/70 dark:bg-white/5 border border-slate-100/70 dark:border-white/10 shadow-soft">
                        <p class="text-xs font-medium text-indigo-700 dark:text-indigo-200">
                            <strong>Tip:</strong> Anda bisa mendapatkan latitude dan longitude dari Google Maps. Klik kanan pada lokasi di peta lalu pilih koordinat yang muncul.
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Simpan Lokasi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
