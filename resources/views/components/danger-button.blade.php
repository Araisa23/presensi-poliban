<button {{ $attributes->merge([
    'class' => 'inline-flex items-center justify-center px-5 py-3 rounded-2xl
    font-black text-xs text-white uppercase tracking-[0.2em]
    bg-gradient-to-r from-rose-500 to-rose-600
    hover:from-rose-600 hover:to-rose-700
    shadow-[0_14px_30px_rgba(244,_63,_94,_0.25)]
    ring-1 ring-rose-600/20
    active:scale-[0.99]
    transition'
]) }}>
    {{ $slot }}
</button>