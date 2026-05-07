<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] bg-gradient-to-b from-rose-600 to-rose-700 hover:to-rose-800 shadow-[0_14px_30px_rgba(225,_29,_72,_0.25)] dark:shadow-none ring-1 ring-rose-600/20 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 focus:ring-offset-transparent transition']) }}>
    {{ $slot }}
</button>
