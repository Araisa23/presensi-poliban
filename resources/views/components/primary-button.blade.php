<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-5 py-3 rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] 
    bg-gradient-to-r from-[#004b8d] to-[#006fcf] 
    hover:from-[#006fcf] hover:to-[#004b8d]
    shadow-[0_14px_30px_rgba(79,_70,_229,_0.30)] dark:shadow-none ring-1 ring-indigo-600/20 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent transition'
]) }}>
    {{ $slot }}
</button>