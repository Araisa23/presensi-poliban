<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-black-70 text-xs font-black uppercase tracking-[0.25em]">Akun</p>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                {{ __('Profile') }}
            </h2>
            <p class="text-black-70 text-sm font-medium mt-1">
                Perbarui informasi akun, kata sandi, atau hapus akun Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 sm:px-0 space-y-6">
            <div class="p-6 sm:p-10 bg-white dark:bg-slate-900 shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white dark:bg-slate-900 shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white dark:bg-slate-900 shadow-soft rounded-3xl border border-slate-100/70 dark:border-white/10">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
