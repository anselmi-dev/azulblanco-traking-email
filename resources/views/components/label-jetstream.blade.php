@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-white/50']) }}>
    {{ $value ?? $slot }}
</label>
