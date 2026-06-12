<div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm">
    <header class="mb-5">
        <h3 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Perbarui Password
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">Gunakan password yang panjang dan acak demi keamanan akun</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="current_password" :value="__('Password Saat Ini')" class="text-xs font-semibold text-slate-600 mb-1" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Masukkan password saat ini"
                    class="pl-10 pr-10 w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                <button
                    type="button"
                    onclick="togglePassword('current_password', 'eyeOpen1', 'eyeClose1')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700">
                    <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eyeClose1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.489A3 3 0 0013.5 13.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.227"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7a9.95 9.95 0 005.772-1.772"/>
                    </svg>
                </button>
            </div>
            <x-input-error class="mt-1 text-xs" :messages="$errors->get('current_password')" />
        </div>

        {{-- New Password + Confirm --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- New Password --}}
            <div>
                <x-input-label for="password" :value="__('Password Baru')" class="text-xs font-semibold text-slate-600 mb-1" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="Masukkan password baru"
                        class="pl-10 pr-10 w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password', 'eyeOpen2', 'eyeClose2')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700">
                        <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeClose2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.489A3 3 0 0013.5 13.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.227"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7a9.95 9.95 0 005.772-1.772"/>
                        </svg>
                    </button>
                </div>
                <p id="passwordStatus" class="mt-2 text-xs text-slate-400">
                    Minimal 8 karakter, huruf besar, huruf kecil, angka, dan simbol.
                </p>
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('password')" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-semibold text-slate-600 mb-1" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="Konfirmasi password baru"
                        class="pl-10 pr-10 w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', 'eyeOpen3', 'eyeClose3')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700">
                        <svg id="eyeOpen3" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeClose3" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.489A3 3 0 0013.5 13.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.227"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7a9.95 9.95 0 005.772-1.772"/>
                        </svg>
                    </button>
                </div>
                <x-input-error class="mt-1 text-xs" :messages="$errors->get('password_confirmation')" />
            </div>
        </div>

        {{-- Warning Banner --}}
        <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex gap-2 items-start text-xs text-amber-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end pt-3 border-t border-slate-50 dark:border-slate-700/50">
            <button
                id="submitPasswordBtn"
                type="submit"
                disabled
                class="px-4 py-2.5 bg-slate-400 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Perbarui Password
            </button>
        </div>
    </form>
</div>

<script>
function togglePassword(inputId, eyeOpenId, eyeCloseId) {
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById(eyeOpenId);
    const eyeClose = document.getElementById(eyeCloseId);

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClose.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClose.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const statusText = document.getElementById('passwordStatus');
    const submitBtn = document.getElementById('submitPasswordBtn');

    function validatePassword() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        const valid =
            password.length >= 8 &&
            /[A-Z]/.test(password) &&
            /[a-z]/.test(password) &&
            /[0-9]/.test(password) &&
            /[^A-Za-z0-9]/.test(password);

        if (password.length === 0) {
            statusText.innerHTML = 'Minimal 8 karakter, huruf besar, huruf kecil, angka, dan simbol.';
            statusText.className = 'mt-2 text-xs text-slate-400';
            submitBtn.disabled = true;
            submitBtn.className = 'px-4 py-2.5 bg-slate-400 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-not-allowed';
            return;
        }

        if (!valid) {
            statusText.innerHTML = '✗ Password belum memenuhi syarat keamanan';
            statusText.className = 'mt-2 text-xs text-red-500 font-semibold';
            submitBtn.disabled = true;
            submitBtn.className = 'px-4 py-2.5 bg-slate-400 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-not-allowed';
            return;
        }

        if (confirm.length > 0 && password !== confirm) {
            statusText.innerHTML = '✗ Konfirmasi password tidak cocok';
            statusText.className = 'mt-2 text-xs text-red-500 font-semibold';
            submitBtn.disabled = true;
            submitBtn.className = 'px-4 py-2.5 bg-slate-400 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-not-allowed';
            return;
        }

        statusText.innerHTML = '✓ Password memenuhi syarat keamanan';
        statusText.className = 'mt-2 text-xs text-emerald-600 font-semibold';
        submitBtn.disabled = false;
        submitBtn.className = 'px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-pointer';
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);
});
</script>