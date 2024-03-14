@props(['status'])

<div {{ $attributes->merge(['class' => "flex items-center"]) }}>
    <div @class([
        'flex-none rounded-full p-1',
        'bg-indigo-500/20' => $status === 'done',
        'bg-yellow-500/20' => $status === 'pending',
        'bg-red-500/20' => $status === 'error',
        'bg-blue-500/20' => $status === 'progress',
    ])>
        <div @class([
            'h-1.5 w-1.5 rounded-full',
            'bg-indigo-500' => $status === 'done',
            'bg-yellow-500' => $status === 'pending',
            'bg-red-500' => $status === 'error',
            'bg-blue-500' => $status === 'progress',
        ])></div>
    </div>
    <span class="ml-1">
        {{ $slot }}
    </span>
</div>
