@props(['excel_email'])

@php
    $own_email = $excel_email->own_email;
@endphp

<div class="w-full relative gap-x-2 py-5 px-2 md:gap-x-6 flex flex-col space-y-5" x-data="{ show: false }">
    <div class="flex justify-between">
        <div class="flex flex-1 min-w-0 gap-x-4">
            <div class="min-w-0 flex-auto">
                <p class="text-base font-semibold leading-6 text-gray-600">
                    <span class="flex items-center">
                        <span class="truncate">{{ $excel_email->obra }}</span>
                    </span>
                </p>
                <p class="mt-1 flex text-base leading-5 text-gray-500">
                    <x-icon name="mail" class="h-5 w-5 flex-none hidden sm:flex mr-1" />
                    <span class="relative truncate">
                        {{ $excel_email->email }}
                    </span>
                </p>
            </div>
        </div>
        <div class="flex flex-1 min-w-0 gap-x-4">
            <div class="flex flex-col flex-start justify-start items-start">
                @if ($own_email)
                    <x-status class="text-sm leading-6 text-gray-900" status="{{ $own_email->opened_at ? 'done' : 'pending' }}">
                        <span class="flex items-center">
                            @if ($own_email->opened_at)
                                <span class="mr-1">Leido el </span> {{ $own_email->opened_at->format('Y-m-d') }}
                            @else
                                Pendiente por leer
                            @endif
                        </span>
                    </x-status>
                    <p class="mt-1 text-xs leading-5 text-gray-500 flex items-center"
                        title="Enviado el: {{ $own_email->created_at->format('Y-m-d') }}">
                        <x-icon name="cursor-click" class="h-5 w-5 flex-none mr-1" />
                        <span class="mr-1">Clicks</span> <span
                            class="bg-gray-100 rounded px-1">{{ $own_email->clicks }}</span>
                    </p>
                @else
                    <p class="mt-1 text-xs leading-5 text-gray-500 flex items-center">
                        <x-icon name="cursor-click" class="h-5 w-5 flex-none mr-1" />
                        <span>Pendiente por enviar</span>
                    </p>
                @endif

            </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
            <div class="hidden sm:flex sm:flex-col sm:items-end">
                <span class="px-1 rounded ml-1">{{ $excel_email->role }}</span>
                <p class="mt-1 text-xs leading-5 text-gray-500 flex items-center"
                    title="Enviado el: {{ $excel_email->created_at->format('Y-m-d') }}">
                    <x-icon name="calendar" class="h-5 w-5 flex-none mr-1" />
                    <span class="mr-1">Enviado el</span>
                    <time>{{ $excel_email->created_at->format('Y-m-d') }}</time>
                </p>
            </div>
            <button type="button" @click="show = !show"
                class="flex items-center px-2 justify-center bg-gray-100 hover:bg-indigo-500 hover:text-white rounded h-full">
                <svg class="h-5 w-5 flex-none fill-current" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    <div x-cloak x-show="show" class="relative flex flex-col ustify-between gap-x-6 py-5 px-5 bg-gray-100">
        <div class="flex flex-wrap justify-between mb-2">
            <div class="flex min-w-0 gap-x-2">
                <div class="min-w-0 flex-auto">
                  <p class="text-base leading-6 text-gray-500">
                        <span class="flex items-center">
                            <span class="font-semibold mr-1">N. OBRA:</span>
                            <span class="relative truncate">
                                {{ $excel_email->num_obra }}
                            </span>
                        </span>
                    </p>
                    <p class="mt-1 flex text-base leading-5 text-gray-500">
                        <span class="font-semibold mr-1">OBRA: </span>
                        <span class="relative truncate">
                            {{ $excel_email->obra }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex min-w-0 gap-x-2">
                <div class="min-w-0 flex-auto">
                  <p class="text-base leading-6 text-gray-500">
                        <span class="flex items-center">
                            <span class="font-semibold mr-1">DIR-OBRA:</span>
                            <span class="relative truncate">
                                {{ $excel_email->dir_obra }}
                            </span>
                        </span>
                    </p>
                    <p class="mt-1 flex text-base leading-5 text-gray-500">
                        <span class="font-semibold mr-1">POBLA_OBRA: </span>
                        <span class="relative truncate">
                            {{ $excel_email->pobla_obra }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex min-w-0 gap-x-2">
                <div class="min-w-0 flex-auto">
                    <p class="mt-1 flex text-base leading-5 text-gray-500">
                        <span class="font-semibold mr-1">PROVI_OBRA: </span>
                        <span class="relative truncate">
                            {{ $excel_email->provi_obra }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full">
            @if ($own_email)
                {!! $own_email->content !!}
            @else
                <div class="text-gray-600 p-5 text-center">
                    <p>PENDIENTE POR ENVIAR</p>
                </div>
            @endif
        </div>
    </div>
</div>
