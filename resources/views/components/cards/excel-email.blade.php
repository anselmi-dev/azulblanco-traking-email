@props(['email'])

<div class="w-full relative gap-x-2 md:gap-x-6 py-5 px-5 flex flex-col space-y-5" x-data="{ show: false }">
    <div class="flex justify-between">
        <div class="flex min-w-0 gap-x-2">
            <x-icon name="mail" class="h-10 w-10 flex-none hidden sm:flex" />
            <div class="min-w-0 flex-auto">
                <p class="text-base font-semibold leading-6 text-gray-900">
                    <span class="flex items-center">
                        <x-icon name="user-circle" class="h-5 w-5 flex-none hidden sm:flex" />
                        {{ $email->sender_name }}
                    </span>
                </p>
                <p class="mt-1 flex text-base leading-5 text-gray-500">
                    {{-- <x-icon name="user-circle" class="h-5 w-5 flex-none" /> --}}
                    <span class="relative truncate">
                        {{ $email->excel_email->email_arqui }}
                        {{-- {{ $email->recipient_email }} --}}
                    </span>
                </p>
            </div>
        </div>
        <div class="flex shrink-0 gap-x-4">
            <div class="flex flex-col flex-start justify-start items-start">
                <x-status class="text-sm leading-6 text-gray-900" status="{{ $email->opened_at ? 'done' : 'pending' }}">
                    <span class="flex items-center">
                        @if ($email->opened_at)
                            <span class="mr-1">Leido el </span> {{ $email->opened_at->format('Y-m-d') }}
                        @else
                            Pendiente por leer
                        @endif
                    </span>
                </x-status>
                <p class="mt-1 text-xs leading-5 text-gray-500 flex items-center"
                    title="Enviado el: {{ $email->created_at->format('Y-m-d') }}">
                    <x-icon name="cursor-click" class="h-5 w-5 flex-none mr-1" />
                    <span class="mr-1">Clicks</span> <span
                        class="bg-gray-100 rounded px-1">{{ $email->clicks }}</span>
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
            <div class="hidden sm:flex sm:flex-col sm:items-end">
                <x-status class="text-sm leading-6 text-gray-900" status="{{ $email->status }}">
                    {{ $email->status_label }}
                </x-status>
                <p class="mt-1 text-xs leading-5 text-gray-500 flex items-center"
                    title="Enviado el: {{ $email->created_at->format('Y-m-d') }}">
                    <x-icon name="calendar" class="h-5 w-5 flex-none mr-1" />
                    <span class="mr-1">Enviado el</span>
                    <time>{{ $email->created_at->format('Y-m-d') }}</time>
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
    <div x-cloak x-show="show" class="relative flex justify-between gap-x-6 py-5 px-5 bg-gray-100">
        {!! $email->content !!}
    </div>
</div>
