<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Presensi Hari Ini') }}
            </h2>
            <p class="mt-1 text-slate-500 text-sm font-medium">Ambil foto, pastikan lokasi terkunci, lalu kirim presensi.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 overflow-hidden shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10 p-6 sm:p-8">

                        @if($jadwal?->use_camera)

                        <div class="relative rounded-3xl overflow-hidden bg-black aspect-video flex items-center justify-center border border-slate-100/70 dark:border-white/10 shadow-soft">
                            <video id="video" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                        </div>

                        <div id="liveness-status" class="mt-3 p-3 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 text-amber-800 dark:text-amber-200 text-xs font-bold text-center">
                            📷 Memuat model deteksi wajah...
                        </div>

                        @endif

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($jadwal?->use_location)
                        <div class="rounded-3xl border border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5 p-5">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Lokasi</h3>

                            <div id="location-info" class="mt-1 text-lg font-black text-slate-900 dark:text-white">
                                Mencari lokasi...
                            </div>

                            <div id="location-coords" class="text-xs text-slate-500 dark:text-slate-300 mt-1 italic">
                                Sedang melacak koordinat GPS...
                            </div>
                        </div>

                        @endif

                            <div class="rounded-3xl border border-slate-100/70 dark:border-white/10 bg-slate-50/60 dark:bg-white/5 p-5">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Instruksi</h3>
                                <ul class="mt-2 text-sm font-medium text-slate-600 dark:text-slate-200 space-y-1">

                                    @if($jadwal?->use_camera)
                                        <li>- Pastikan wajah terlihat jelas.</li>
                                        <li>- Kedipkan mata, lalu toleh ke kiri dan ke kanan.</li>
                                    @endif

                                    @if($jadwal?->use_location)
                                        <li>- Izinkan akses lokasi GPS.</li>
                                        <li>- Tunggu status lokasi “terkunci”.</li>
                                    @endif

                                    @if($jadwal?->is_wfh)
                                        <li>- Mode WFH aktif hari ini.</li>
                                    @endif

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
                        @if($jadwal?->use_camera)

                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10 px-4 py-3">
                            <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Kamera</span>
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-100">Aktif</span>
                        </div>

                        @endif

                        @if($jadwal?->use_location)

                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50/70 dark:bg-white/5 ring-1 ring-slate-900/5 dark:ring-white/10 px-4 py-3">
                            <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Lokasi</span>
                            <span id="location-status-chip" class="text-sm font-bold text-slate-700 dark:text-slate-100">Menunggu...</span>
                        </div>

                        @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>

    {{-- MODAL SUKSES PRESENSI --}}
    <div id="success-modal"
         class="hidden fixed inset-0 z-50 items-center justify-center p-4"
         role="dialog"
         aria-modal="true"
         aria-labelledby="success-modal-title">

        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

        <div class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden">

            <div class="p-8 text-center">

                <div id="success-modal-icon-masuk"
                     class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-5 ring-1 ring-emerald-600/10">

                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                </div>

                <div id="success-modal-icon-pulang"
                     class="hidden w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-5 ring-1 ring-amber-600/10">

                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                </div>

                <h3 id="success-modal-title" class="text-xl font-black text-slate-900 dark:text-white mb-2">
                    Presensi Berhasil!
                </h3>

                <p id="success-modal-message" class="text-sm font-medium text-slate-600 dark:text-slate-300"></p>

                <button id="success-modal-btn"
                        type="button"
                        class="mt-6 w-full px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.18em] bg-gradient-to-r from-[#004b8d] to-[#006fcf] text-white shadow-[0_10px_25px_rgba(79,_70,_229,_0.25)] hover:scale-[1.01] transition">
                    OK
                </button>

            </div>

        </div>

    </div>

@push('scripts')
<script type="module">
import {
    FaceLandmarker,
    FilesetResolver
} from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/vision_bundle.mjs";

document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const btnAbsen = document.getElementById('btn-absen');
    const btnText = document.getElementById('btn-text');
    const btnLoader = document.getElementById('btn-loader');
    const locationInfo = document.getElementById('location-info');
    const locationCoords = document.getElementById('location-coords');
    const alertContainer = document.getElementById('alert-container');
    const successModal = document.getElementById('success-modal');
    const successModalMessage = document.getElementById('success-modal-message');
    const successModalBtn = document.getElementById('success-modal-btn');
    const successModalIconMasuk = document.getElementById('success-modal-icon-masuk');
    const successModalIconPulang = document.getElementById('success-modal-icon-pulang');
    const livenessStatusEl = document.getElementById('liveness-status');

    let lat = null;
    let lon = null;
    const locationStatusChip = document.getElementById('location-status-chip');

    const useCamera = {{ $jadwal?->use_camera ? 'true' : 'false' }};

    // ============================
    // LIVENESS STATE
    // ============================
    let faceLandmarker = null;
    let livenessPassed = !useCamera; // kalau kamera tidak dipakai, anggap liveness tidak perlu
    let lastVideoTime = -1;

    // State machine: 'blink' -> 'turn_left' -> 'turn_right' -> selesai
    let livenessStep = 'blink';

    // Blink detection
    let eyeWasClosed = false;
    let blinkCount = 0;
    const REQUIRED_BLINKS = 1;
    const BLINK_CLOSE_THRESHOLD = 0.5;

    // Head turn detection
    const YAW_THRESHOLD = 15; // derajat. Naikkan/turunkan jika kurang/terlalu sensitif
    let hasReturnedToCenter = true; // mencegah 1 gerakan menoleh terhitung dobel

    // 1. Get Location
    @if($jadwal?->use_location)

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

    @endif

    // 2. Access Camera
    async function initCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user" },
                audio: false
            });
            video.srcObject = stream;

            video.addEventListener('loadeddata', () => {
                if (useCamera) initLiveness();
            });

        } catch (err) {
            console.error("Error accessing camera: ", err);
            showAlert('Gagal mengakses kamera. Pastikan izin diberikan.', 'error');
            btnAbsen.disabled = true;
        }
    }

    @if($jadwal?->use_camera)
    initCamera();
    updateButtonState();
    @endif

    // ============================
    // 3. LIVENESS DETECTION (MediaPipe)
    // ============================
    async function initLiveness() {
        try {
            const vision = await FilesetResolver.forVisionTasks(
                "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/wasm"
            );

            faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
                baseOptions: {
                    modelAssetPath: "https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task",
                    delegate: "GPU"
                },
                runningMode: "VIDEO",
                numFaces: 1,
                outputFaceBlendshapes: true,
                outputFacialTransformationMatrixes: true
            });

            if (livenessStatusEl) {
                livenessStatusEl.textContent = "👀 Posisikan wajah di kamera, lalu kedipkan mata";
            }

            requestAnimationFrame(detectLoop);

        } catch (err) {
            console.error('Gagal load model liveness:', err);
            if (livenessStatusEl) {
                livenessStatusEl.textContent = "❌ Gagal memuat model deteksi wajah.";
                livenessStatusEl.className = "mt-3 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold text-center";
            }
        }
    }

    function getYawDegrees(matrix) {
        // matrix.data: 4x4 column-major
        const m = matrix.data;
        const m02 = m[8];
        const m11 = m[5], m12 = m[6];
        const yawRad = Math.atan2(-m02, Math.sqrt(m11 * m11 + m12 * m12));
        return yawRad * (180 / Math.PI);
    }

    function detectLoop() {
        if (livenessPassed || !faceLandmarker) return;

        if (video.currentTime !== lastVideoTime) {
            lastVideoTime = video.currentTime;

            const result = faceLandmarker.detectForVideo(video, performance.now());

            if (result.faceLandmarks.length === 0) {
                setLivenessStatus("⚠️ Wajah tidak terdeteksi, mendekatlah ke kamera", 'warn');
            } else if (result.faceLandmarks.length > 1) {
                setLivenessStatus("⚠️ Terdeteksi lebih dari 1 wajah", 'warn');
            } else {

                // === STEP 1: KEDIP ===
                if (livenessStep === 'blink' && result.faceBlendshapes?.length > 0) {
                    const shapes = result.faceBlendshapes[0].categories;
                    const blinkLeft  = shapes.find(s => s.categoryName === 'eyeBlinkLeft')?.score  ?? 0;
                    const blinkRight = shapes.find(s => s.categoryName === 'eyeBlinkRight')?.score ?? 0;
                    const avgBlink   = (blinkLeft + blinkRight) / 2;
                    const isClosedNow = avgBlink > BLINK_CLOSE_THRESHOLD;

                    if (isClosedNow) {
                        eyeWasClosed = true;
                    } else if (eyeWasClosed && !isClosedNow) {
                        eyeWasClosed = false;
                        blinkCount++;
                    }

                    if (blinkCount < REQUIRED_BLINKS) {
                        setLivenessStatus(`👁️ Kedipkan mata untuk verifikasi (${blinkCount}/${REQUIRED_BLINKS})`, 'info');
                    } else {
                        livenessStep = 'turn_left';
                        setLivenessStatus("↩️ Sekarang, tolehkan wajah ke KIRI", 'info');
                    }
                }

                // === STEP 2 & 3: TOLEH KIRI / KANAN ===
                else if ((livenessStep === 'turn_left' || livenessStep === 'turn_right')
                          && result.facialTransformationMatrixes?.length > 0) {

                    const yaw = getYawDegrees(result.facialTransformationMatrixes[0]);

                    if (livenessStep === 'turn_left') {
                        if (yaw < -YAW_THRESHOLD && hasReturnedToCenter) {
                            livenessStep = 'turn_right';
                            hasReturnedToCenter = false;
                            setLivenessStatus("↪️ Bagus! Sekarang tolehkan wajah ke KANAN", 'info');
                        } else {
                            setLivenessStatus("↩️ Tolehkan wajah ke KIRI", 'info');
                        }
                    } else if (livenessStep === 'turn_right') {
                        if (!hasReturnedToCenter && Math.abs(yaw) < 5) {
                            hasReturnedToCenter = true;
                        }
                        if (yaw > YAW_THRESHOLD && hasReturnedToCenter) {
                            passLiveness();
                        } else if (!hasReturnedToCenter) {
                            setLivenessStatus("↪️ Kembalikan wajah ke tengah dulu, lalu toleh ke KANAN", 'info');
                        } else {
                            setLivenessStatus("↪️ Tolehkan wajah ke KANAN", 'info');
                        }
                    }
                }
            }
        }

        requestAnimationFrame(detectLoop);
    }

    function passLiveness() {
        livenessPassed = true;
        setLivenessStatus("✅ Verifikasi wajah berhasil", 'success');
        updateButtonState();
    }

    function setLivenessStatus(text, type) {
        if (!livenessStatusEl) return;
        livenessStatusEl.textContent = text;

        const base = "mt-3 p-3 rounded-2xl text-xs font-bold text-center border ";
        const styles = {
            info:    "bg-amber-50 dark:bg-amber-500/10 border-amber-200 dark:border-amber-500/20 text-amber-800 dark:text-amber-200",
            warn:    "bg-rose-50 dark:bg-rose-500/10 border-rose-200 dark:border-rose-500/20 text-rose-800 dark:text-rose-200",
            success: "bg-emerald-50 dark:bg-emerald-500/10 border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200",
        };
        livenessStatusEl.className = base + styles[type];
    }

    function updateButtonState() {
        btnAbsen.disabled = !livenessPassed;
    }

    // 4. Handle Capture and Submit
    btnAbsen.addEventListener('click', async function() {

        if (useCamera && !livenessPassed) {
            showAlert('Selesaikan verifikasi wajah (kedip, lalu toleh kiri & kanan) terlebih dahulu.', 'warning');
            return;
        }

        @if($jadwal?->use_location)

        if (!lat || !lon) {
            showAlert('Harap tunggu hingga koordinat lokasi terkunci.', 'warning');
            return;
        }

        @endif

        setLoading(true);

        // Capture image from video
        let imageData = null;

        @if($jadwal?->use_camera)

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        imageData = canvas.toDataURL('image/png');

        @endif

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
                    latitude: lat ? lat.toString() : null,
                    longitude: lon ? lon.toString() : null,
                    foto: imageData,
                    is_live: livenessPassed ? 1 : 0,
                })
            });

            const result = await response.json();

            if (response.ok) {
                showSuccessModal(result.message, result.type);
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

    function showSuccessModal(message, type) {
        successModalMessage.textContent = message;

        if (type === 'pulang') {
            successModalIconMasuk.classList.add('hidden');
            successModalIconPulang.classList.remove('hidden');
        } else {
            successModalIconMasuk.classList.remove('hidden');
            successModalIconPulang.classList.add('hidden');
        }

        successModal.classList.remove('hidden');
        successModal.classList.add('flex');
    }

    successModalBtn.addEventListener('click', function() {
        window.location.reload();
    });

    function showAlert(message, type) {
        alertContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700', 'bg-emerald-50', 'text-emerald-800', 'bg-rose-50', 'text-rose-800', 'bg-amber-50', 'text-amber-800', 'ring-emerald-600/10', 'ring-rose-600/10', 'ring-amber-600/10');
        alertContainer.textContent = message;

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
            btnAbsen.disabled = !livenessPassed;
        }
    }
});
</script>
@endpush
</x-app-layout>