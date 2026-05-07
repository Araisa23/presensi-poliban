@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 rounded-2xl text-start text-base font-black text-indigo-700 dark:text-indigo-200 bg-indigo-50/80 dark:bg-indigo-500/10 ring-1 ring-indigo-600/15 shadow-soft transition'
            : 'block w-full px-4 py-3 rounded-2xl text-start text-base font-bold text-slate-600 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white hover:bg-white/80 dark:hover:bg-white/10 ring-1 ring-transparent hover:ring-slate-900/5 dark:hover:ring-white/10 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
