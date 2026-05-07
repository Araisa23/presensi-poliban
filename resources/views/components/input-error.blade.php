@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs font-bold text-rose-600 dark:text-rose-300 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-start gap-2">
                <span class="mt-[2px] inline-flex h-4 w-4 items-center justify-center rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-300 ring-1 ring-rose-500/20">!</span>
                <span class="flex-1">{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
