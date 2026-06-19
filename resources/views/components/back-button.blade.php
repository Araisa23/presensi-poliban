<a {{ $attributes->merge([
    'class' => 'inline-flex items-center justify-center gap-2
    px-5 py-3 rounded-2xl
    border border-slate-300
    bg-white
    text-slate-700
    font-black text-xs uppercase tracking-[0.2em]
    hover:bg-slate-100
    shadow-sm
    transition'
]) }}>

    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-4 h-4"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7" />
    </svg>

    {{ $slot }}

</a>