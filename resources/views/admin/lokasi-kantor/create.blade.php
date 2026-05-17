<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.lokasi-kantor.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white/10 text-white hover:bg-white/15 ring-1 ring-white/15 shadow-soft transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>

            <div>
                <p class="text-white/70 text-xs font-black uppercase tracking-[0.25em]">
                    Admin
                </p>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Tambah Lokasi Kantor') }}
                </h2>

                <p class="mt-1 text-white/70 text-sm font-medium">
                    Tentukan lokasi kantor langsung melalui peta OpenStreetMap.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">

            <form action="{{ route('admin.lokasi-kantor.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Lokasi --}}
                    <div class="md:col-span-2">
                        <x-input-label for="nama_lokasi" :value="__('Nama Lokasi')" />

                        <x-text-input
                            id="nama_lokasi"
                            class="block mt-1 w-full"
                            type="text"
                            name="nama_lokasi"
                            :value="old('nama_lokasi')"
                            required
                            placeholder="Contoh: Gedung Rektorat"
                        />

                        <x-input-error :messages="$errors->get('nama_lokasi')" class="mt-2" />
                    </div>

                    {{-- MAP --}}
                    <div class="md:col-span-2">
                        <x-input-label :value="__('Pilih Lokasi di Peta')" />

                        <div id="map"
                             class="w-full h-[400px] rounded-3xl mt-2 border border-slate-200 overflow-hidden z-10">
                        </div>

                        <p class="mt-3 text-xs text-slate-500 font-medium">
                            Klik pada peta untuk menentukan lokasi kantor.
                        </p>
                    </div>

                    {{-- Latitude --}}
                    <div>
                        <x-input-label for="latitude" :value="__('Latitude')" />

                        <x-text-input
                            id="latitude"
                            class="block mt-1 w-full bg-slate-50"
                            type="text"
                            name="latitude"
                            :value="old('latitude')"
                            required
                            readonly
                        />

                        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                    </div>

                    {{-- Longitude --}}
                    <div>
                        <x-input-label for="longitude" :value="__('Longitude')" />

                        <x-text-input
                            id="longitude"
                            class="block mt-1 w-full bg-slate-50"
                            type="text"
                            name="longitude"
                            :value="old('longitude')"
                            required
                            readonly
                        />

                        <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                    </div>

                    {{-- Radius --}}
                    <div class="md:col-span-2">
                        <x-input-label for="radius" :value="__('Radius Presensi (Meter)')" />

                        <x-text-input
                            id="radius"
                            class="block mt-1 w-full"
                            type="number"
                            name="radius"
                            :value="old('radius', 50)"
                            required
                        />

                        <x-input-error :messages="$errors->get('radius')" class="mt-2" />
                    </div>

                </div>

                {{-- INFO --}}
                <div class="p-5 rounded-3xl bg-blue-50 border border-blue-100 shadow-soft">
                    <p class="text-sm font-medium text-blue-800">
                        Pilih titik lokasi kantor pada peta. Sistem akan otomatis mengambil koordinat latitude dan longitude.
                    </p>
                </div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-end mt-6">
                    <x-primary-button>
                        {{ __('Simpan Lokasi') }}
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>

    {{-- LEAFLET OPENSTREETMAP --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-3.3194, 114.5908], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker;
        let circle;

        map.on('click', function (e) {

            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            const radius = document.getElementById('radius').value || 50;

            if (marker) {
                map.removeLayer(marker);
            }

            if (circle) {
                map.removeLayer(circle);
            }

            marker = L.marker([lat, lng]).addTo(map);

            circle = L.circle([lat, lng], {
                radius: radius,
                color: '#2563eb',
                fillColor: '#3b82f6',
                fillOpacity: 0.2
            }).addTo(map);
        });

        document.getElementById('radius').addEventListener('input', function () {

            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;

            if (lat && lng && circle) {

                map.removeLayer(circle);

                circle = L.circle([lat, lng], {
                    radius: this.value,
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.2
                }).addTo(map);
            }
        });
    </script>

</x-app-layout>