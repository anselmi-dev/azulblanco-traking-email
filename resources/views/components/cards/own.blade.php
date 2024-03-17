@props([
    'own_email' => null
])

@if ($own_email)
    <x-status class="text-sm leading-6 text-gray-900" status="{{ $own_email ? 'done' : 'pending' }}">
        <span class="flex items-center">
            {{--
                @if ($own_email->opened_at)
                    <span class="mr-1">Leido el </span> {{ $own_email->opened_at->format('Y-m-d') }}
                @else
                    Pendiente por leer
                @endif
            --}}
            Correo enviado
        </span>
    </x-status>
@else
    <p class="mt-1 text-xs leading-5 flex items-center">
        <div class="flex items-center px-1 bg-red-200 rounded">
            <x-icon name="fire" class="h-5 w-5 flex-none mr-1 text-red-600" />
            <span class="text-gray-700">Pendiente por enviar</span>
        </div>
    </p>
@endif
