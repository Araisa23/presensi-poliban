<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Verifikasi Email</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">
            Kami sudah mengirim link verifikasi ke email kamu. Klik link tersebut untuk melanjutkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft text-sm font-bold">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl shadow-[0_10px_20px_rgba(11,_44,_82,_0.20)] text-sm font-black text-white bg-gradient-to-b from-[#2f6aa8] to-[#214e83] hover:to-[#1b416c] transition active:scale-95">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-bold text-slate-500 hover:text-slate-800 dark:text-slate-300 dark:hover:text-white transition-colors">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
