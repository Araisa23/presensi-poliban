<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-[0.25em]">Presensi</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Presensi Hari Ini') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Ambil foto, pastikan lokasi terkunci, lalu kirim presensi.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10 p-6 sm:p-8">
            
                        <!-- Camera Preview -->
                        <div class="relative rounded-3xl overflow-hidden bg-black aspect-video flex items-center justify-center border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <video id="video" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="rounded-3xl border border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5 p-5">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Lokasi</h3>
                                <div id="location-info" class="mt-1 text-lg font-black text-slate-900 dark:text-white">
                                    Mencari lokasi...
                                </div>
                                <div id="location-coords" class="text-xs text-slate-500 dark:text-slate-300 mt-1 italic">
                                    Sedang melacak koordinat GPS...
                                </div>
                            </div>

                            <div class="rounded-3xl border border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5 p-5">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Instruksi</h3>
                                <ul class="mt-2 text-sm font-medium text-slate-600 dark:text-slate-200 space-y-1">
                                    <li>- Pastikan wajah terlihat jelas.</li>
                                    <li>- Izinkan akses lokasi & kamera.</li>
                                    <li>- Tunggu status lokasi “terkunci”.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button id="btn-absen" class="w-full py-5 px-6 bg-gradient-to-b from-indigo-600 to-indigo-700 hover:to-indigo-800 text-white font-black rounded-3xl shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] ring-1 ring-indigo-600/20 transition duration-200 transform hover:-translate-y-0.5 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-[0.2em] text-xs">
                                <span id="btn-text">KIRIM PRESENSI</span>
                                <svg id="btn-loader" class="hidden animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Alert Area -->
                        <div id="alert-container" class="hidden mt-5 p-5 rounded-3xl text-sm font-bold ring-1 ring-slate-900/5"></div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10 p-6">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Status</h3>
                        <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-300">Sebelum menekan tombol kirim, pastikan semua siap.</p>

                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10 px-4 py-3">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Kamera</span>
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-100">Aktif</span>
                            </div>
                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10 px-4 py-3">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Lokasi</span>
                                <span id="location-status-chip" class="text-sm font-bold text-slate-700 dark:text-slate-100">Menunggu...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const btnAbsen = document.getElementById('btn-absen');
            const btnText = document.getElementById('btn-text');
            const btnLoader = document.getElementById('btn-loader');
            const locationInfo = document.getElementById('location-info');
            const locationCoords = document.getElementById('location-coords');
            const alertContainer = document.getElementById('alert-container');

            let lat = null;
            let lon = null;
            const locationStatusChip = document.getElementById('location-status-chip');

            // 1. Get Location
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (position) => {
                        lat = position.coords.latitude;
                        lon = position.coords.longitude;
                        locationInfo.textContent = "Lokasi Terkunci";
                        locationInfo.classList.add('text-green-600', 'dark:text-green-400');
                        locationCoords.textContent = `${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                        if (locationStatusChip) locationStatusChip.textContent = 'Terkunci';
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                        locationInfo.textContent = "Gagal mendapatkan lokasi";
                        locationInfo.classList.add('text-red-600', 'dark:text-red-400');
                        if (locationStatusChip) locationStatusChip.textContent = 'Gagal';
                        showAlert('Izin lokasi diperlukan untuk presensi.', 'error');
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                showAlert('Browser Anda tidak mendukung Geolocation.', 'error');
            }

            // 2. Access Camera
            async function initCamera() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: "user" }, 
                        audio: false 
                    }); 
                    video.srcObject = stream;
                } catch (err) {
                    console.error("Error accessing camera: ", err);
                    showAlert('Gagal mengakses kamera. Pastikan izin diberikan.', 'error');
                    btnAbsen.disabled = true;
                }
            }
            initCamera();

            // 3. Handle Capture and Submit
            btnAbsen.addEventListener('click', async function() {
                if (!lat || !lon) {
                    showAlert('Harap tunggu hingga koordinat lokasi terkunci.', 'warning');
                    return;
                }

                setLoading(true);

                // Capture image from video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/png');

                try {
                    const response = await fetch("{{ route('pegawai.presensi.store') }}", {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            latitude: lat.toString(),
                            longitude: lon.toString(),
                            foto: imageData,
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showAlert(result.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showAlert(result.message || 'Terjadi kesalahan.', 'error');
                    }
                } catch (err) {
                    console.error('Upload error:', err);
                    showAlert('Gagal mengirim data ke server.', 'error');
                } finally {
                    setLoading(false);
                }
            });

            function showAlert(message, type) {
                alertContainer.textContent = message;
                alertContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700', 'bg-emerald-50', 'text-emerald-800', 'bg-rose-50', 'text-rose-800', 'bg-amber-50', 'text-amber-800', 'ring-emerald-600/10', 'ring-rose-600/10', 'ring-amber-600/10');
                
                if (type === 'success') {
                    alertContainer.classList.add('bg-emerald-50', 'text-emerald-800', 'ring-emerald-600/10');
                } else if (type === 'warning') {
                    alertContainer.classList.add('bg-amber-50', 'text-amber-800', 'ring-amber-600/10');
                } else {
                    alertContainer.classList.add('bg-rose-50', 'text-rose-800', 'ring-rose-600/10');
                }
            }

            function setLoading(loading) {
                if (loading) {
                    btnText.classList.add('hidden');
                    btnLoader.classList.remove('hidden');
                    btnAbsen.disabled = true;
                } else {
                    btnText.classList.remove('hidden');
                    btnLoader.classList.add('hidden');
                    btnAbsen.disabled = false;
                }
            }
        });
    </script>
    @endpush
</x-app-layout>