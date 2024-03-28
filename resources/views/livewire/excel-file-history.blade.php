<div class="w-full bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-600 rounded py-5 px-5">
    <div class="w-full text-xl lg:text-2xl mb-2 rounded">
        <span class="flex items-start text-gray-600 dark:text-white">
            <x-icon name="clock" class="h-6 w-6"></x-icon>
            Historial de importación
        </span>
        <p class="text-base text-gray-500 dark:text-gray-100">
            Visualización de cada una de las importaciones realizadas a través del archivo XLSX, reflejando así todos los documentos importados en la lista.
        </p>
    </div>

    <div class="relative">
        <x-loading wire:loading.class.remove="hidden" class="hidden"/>

        <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-600">
            @foreach ($files as $file)
                <li class="w-full">
                    <div class="relative flex justify-between gap-x-2 py-4">
                        <div class="relative flex flex-wrap justify-between gap-2 flex-1">
                            <div class="flex sm:flex-1 min-w-0 gap-x-2">
                                <x-icons.excel class="h-12 w-12 flex-none text-gray-400 hidden sm:flex" />
                                <div class="min-w-0 flex-auto">
                                    <p class="text-base font-semibold leading-6 text-gray-900">
                                        <a href="{{ $file->file_path }}" target="__blank" class="text-indigo-500">
                                            <span class="flex">
                                                <x-icon name="download" class="h-5 w-5 flex-none" />
                                                {{ $file->original_name }}
                                            </span>
                                        </a>
                                    </p>
                                    <p class="mt-1 flex text-base leading-5 text-gray-500 dark:text-white">
                                        <span class="flex items-center">
                                            <x-icon name="user-circle" class="w-4 h-4 mr-1"></x-icon>
                                            <span class="relative truncate">
                                                {{ optional($file->user)->name }}
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex sm:flex-1 min-w-0 gap-x-2">
                                <div class="flex flex-col flex-start justify-start items-start">
                                    <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-white flex items-center" >
                                        @if ($file->status != 'pending')
                                            <x-icon name="mail" class="h-5 w-5 flex-none mr-1" />
                                            <span class="bg-gray-100 dark:bg-gray-950 rounded px-1">
                                                {{ $file->excel_emails()->where('status', 'done')->count() }} enviados / {{ $file->excel_emails->count() }} correos
                                            </span>
                                        @else
                                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Procesando
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex sm:hidden flex-col sm:items-end">
                                <div class="text-sm leading-6 text-gray-900 flex items-center">
                                    <x-status class="text-sm leading-6 text-gray-900 dark:text-white" status="{{ $file->status }}">
                                        {{ $file->status_label }}
                                    </x-status>
                                </div>
                                <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-white">
                                    Creado el
                                    <time datetime="2023-01-23T13:23Z">{{ $file->created_at->format('Y-m-d h:i') }}</time>
                                </p>
                            </div>
                        </div>
                        <div class="flex shrink-0 gap-x-2">
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                                <div class="text-sm leading-6 text-gray-900 flex items-center">
                                    <x-status class="text-sm leading-6 text-gray-900 dark:text-white" status="{{ $file->status }}">
                                        {{ $file->status_label }}
                                    </x-status>
                                </div>
                                <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-white">
                                    Creado el
                                    <time datetime="2023-01-23T13:23Z">{{ $file->created_at->format('Y-m-d h:i') }}</time>
                                </p>
                            </div>
                            <a href="{{ route('historial.preview', ['file' => $file->id]) }}" class="flex items-center px-2 justify-center bg-gray-100 hover:bg-indigo-500 hover:text-white rounded h-full">
                                <svg class="h-5 w-5 flex-none fill-current" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="w-full pt-5">
        {{ $files->links() }}
    </div>
</div>
