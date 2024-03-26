@props([
    'excel_email'
])

@if ($excel_email->own_email)
    <x-status class="text-sm leading-6 text-gray-900 | dark:text-white"
        status="{{ $excel_email->status }}">
        <span class="flex items-center">
            Enviado
        </span>
    </x-status>
@else
    <x-status class="text-sm leading-6 text-gray-900 | dark:text-white"
        status="{{ $excel_email->status }}">
        <span class="flex items-center">
            {{ __('status:email:' . $excel_email->status) }}
        </span>
    </x-status>
@endif
