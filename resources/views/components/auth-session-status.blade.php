@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-500/10 border border-emerald-200/70 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-200 shadow-soft text-sm font-bold']) }}>
        {{ $status }}
    </div>
@endif
