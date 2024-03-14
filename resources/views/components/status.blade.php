@props(['status'])

@php
    // bg-indigo-500 bg-indigo-500/20
    // bg-green-500 bg-green-500/20
    // bg-yellow-500 bg-yellow-500/20
    // bg-red-500 bg-red-500/20

    $color = 'indigo';
    switch ($status) {
        case 'done':
            $color = 'green';
            break;
        case 'pending':
            $color = 'yellow';
            break;
        case 'error':
            $color = 'red';
            break;
    }
@endphp

<div {{ $attributes->merge([
        'class' => "flex items-center bg-$color-500/20 px-1 rounded"
    ]) }}>
    <div @class([
        'flex-none rounded-full p-1',
        'bg-' . $color. '-500/20'
    ])>
        <div @class([
            'h-1.5 w-1.5 rounded-full',
            'bg-' . $color . '-500'
        ])></div>
    </div>
    <span class="ml-1">
        {{ $slot }}
    </span>
</div>
