@props([
    'opened_at'
])

<x-status class="text-sm leading-6 text-gray-900" status="{{ $opened_at ? 'done' : 'pending' }}">
    <span class="flex items-center">
        @if ($opened_at)
            <span class="mr-1">Leido el </span> {{ $opened_at->format('Y-m-d') }}
        @else
            Pendiente por leer
        @endif
    </span>
</x-status>
