@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400']) }}>
    {{ $value ?? $slot }}
</label>
