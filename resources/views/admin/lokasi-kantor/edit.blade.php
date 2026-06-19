<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    {{ __('Edit Lokasi Kantor') }}
                </h2>

                <p class="mt-1 text-black-70 text-sm font-medium">
                    Perbarui koordinat dan radius jika ada perubahan.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl p-6 sm:p-8 border border-slate-100/70 dark:border-white/10">

            <form action="{{ route('admin.lokasi-kantor.update', $lokasiKantor->id) }}"
                  method="POST"
                  class="space-y-6">

                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- NAMA LOKASI --}}
                    <div class="md:col-span-2">
                        <x-input-label for="nama_lokasi" :value="__('Nama Lokasi')" />

                        <x-text-input
                            id="nama_lokasi"
                            class="block mt-1 w-full"
                            type="text"
                            name="nama_lokasi"
                            :value="old('nama_lokasi', $lokasiKantor->nama_lokasi)"
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
                            Klik ulang pada peta jika ingin mengubah titik lokasi kantor.
                        </p>
                    </div>

                    {{-- LATITUDE --}}
                    <div>
                        <x-input-label for="latitude" :value="__('Latitude')" />

                        <x-text-input
                            id="latitude"
                            class="block mt-1 w-full bg-slate-50"
                            type="text"
                            name="latitude"
                            :value="old('latitude', $lokasiKantor->latitude)"
                            required
                            readonly
                        />

                        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                    </div>

                    {{-- LONGITUDE --}}
                    <div>
                        <x-input-label for="longitude" :value="__('Longitude')" />

                        <x-text-input
                            id="longitude"
                            class="block mt-1 w-full bg-slate-50"
                            type="text"
                            name="longitude"
                            :value="old('longitude', $lokasiKantor->longitude)"
                            required
                            readonly
                        />

                        <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                    </div>

                    {{-- RADIUS --}}
                    <div class="md:col-span-2">
                        <x-input-label for="radius" :value="__('Radius Presensi (Meter)')" />

                        <x-text-input
                            id="radius"
                            class="block mt-1 w-full"
                            type="number"
                            name="radius"
                            :value="old('radius', $lokasiKantor->radius)"
                            required
                        />

                        <x-input-error :messages="$errors->get('radius')" class="mt-2" />
                    </div>

                </div>

                {{-- INFO --}}
                <div class="p-5 rounded-3xl bg-blue-50 border border-blue-100 shadow-soft">

                    <p class="text-sm font-medium text-blue-800">
                        Klik titik baru pada peta untuk memperbarui lokasi kantor.
                        Sistem akan otomatis memperbarui koordinat latitude dan longitude.
                    </p>

                </div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-end mt-6 gap-3">

                    <x-back-button href="{{ route('admin.lokasi-kantor.index') }}">
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
                        Simpan Perubahan
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

    {{-- LEAFLET --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>

        // DEFAULT LOCATION FROM DATABASE
        const defaultLat = {{ $lokasiKantor->latitude }};
        const defaultLng = {{ $lokasiKantor->longitude }};
        const defaultRadius = {{ $lokasiKantor->radius }};

        // INIT MAP
        const map = L.map('map').setView([defaultLat, defaultLng], 16);

        // TILE
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // DEFAULT MARKER
        let marker = L.marker([defaultLat, defaultLng]).addTo(map);

        // DEFAULT CIRCLE
        let circle = L.circle([defaultLat, defaultLng], {
            radius: defaultRadius,
            color: '#2563eb',
            fillColor: '#3b82f6',
            fillOpacity: 0.2
        }).addTo(map);

        // CLICK MAP
        map.on('click', function (e) {

            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            const radius =
                document.getElementById('radius').value || 50;

            // REMOVE OLD
            if (marker) {
                map.removeLayer(marker);
            }

            if (circle) {
                map.removeLayer(circle);
            }

            // NEW MARKER
            marker = L.marker([lat, lng]).addTo(map);

            // NEW CIRCLE
            circle = L.circle([lat, lng], {
                radius: radius,
                color: '#2563eb',
                fillColor: '#3b82f6',
                fillOpacity: 0.2
            }).addTo(map);

        });

        // UPDATE RADIUS
        document.getElementById('radius')
            .addEventListener('input', function () {

                const lat =
                    document.getElementById('latitude').value;

                const lng =
                    document.getElementById('longitude').value;

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