<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-[0.2em] bg-white/80 dark:bg-white/10 text-slate-700 dark:text-slate-100 hover:bg-white dark:hover:bg-white/15 ring-1 ring-slate-900/10 dark:ring-white/10 shadow-soft focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 transition']) }}>
    {{ $slot }}
</button>
