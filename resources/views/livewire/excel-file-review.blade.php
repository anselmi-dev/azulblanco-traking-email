<div class="max-w-7xl mx-auto px-6 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            Hitorial
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-12 w-full relative">
        <x-loading wire:loading.class.remove="hidden" class="hidden"/>
        <div class="lg:flex lg:items-center lg:justify-between mb-10">
            <div class="min-w-0 flex-1">
                <h2
                    class="text-2xl font-bold leading-7 text-gray-600 sm:truncate sm:text-3xl sm:tracking-tight truncate">
                    # 00{{ $file->id }} - {{ $file->original_name }}
                </h2>
                <div class="mt-1 flex sm:mt-0 flex-wrap space-x-4 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-600">
                        <x-icon name="user-circle" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-500"></x-icon>
                        {{ optional($file->user)->name }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-600">
                        <x-icon name="mail" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-500"></x-icon>
                        Emails ({{ $excel_emails->count() }})
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-600">
                        <x-status class="text-sm leading-6 text-gray-900" status="{{ $file->status }}">
                            {{ $file->status_label }}
                        </x-status>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-600">
                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $file->created_at->format('Y-m-d h:i') }}
                    </div>
                </div>
            </div>

            <div class="mt-5 flex lg:ml-4 lg:mt-0">

                @if ($file->is_pending)
                    <x-button type="button" wire:click="dispatchFile" spinner>
                        Procesar
                    </x-button>
                @endif

                <span class="sm:ml-3">
                    <a href="{{ $file->file_path }}" target="__blank"
                        class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        <x-icon name="download" class="-ml-0.5 mr-1.5 h-5 w-5"></x-icon>
                        Decargar documento importado
                    </a>
                </span>
            </div>
        </div>

        <div class="w-full text-xl mb-2 border-gray-200 border-b pb-1 | flex items-start justify-between">
            <div class="flex-1">
                <span class="flex items-center text-gray-800">
                    Correos enviados
                </span>
                <p class="text-base text-gray-500">
                    Visualización de cada una de los envios de correos que fueron realizados por el archivo XLSX.
                </p>
            </div>
            <div>
                <x-native-select
                    placeholder="Buscar por estado"
                    :options="[
                        [
                            'name' => __('status:pending'),
                            'value' => 'pending'
                        ],
                        [
                            'name' => __('status:progress'),
                            'value' => 'progress'
                        ],
                        [
                            'name' => __('status:done'),
                            'value' => 'done'
                        ],
                        [
                            'name' => __('status:error'),
                            'value' => 'error'
                        ],
                    ]"
                    option-label="name"
                    option-value="value"
                    wire:model.live="filters.status"
                />
            </div>
        </div>

        @if ($this->no_emails_sent)
            <div class="border-l-4 border-red-400 bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Algunos correos no se han podido enviar. Por favor, haz
                            <button type="button" class="font-medium text-red-700 underline hover:text-red-600" wire:click="dispatchFile()">
                                clic aquí para intentar reenviarlos
                            </button>.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <ul role="list" class="divide-y divide-gray-100 bg-white rounded">
            @forelse ($excel_emails as $excel_email)
                <li class="w-full">
                    <x-cards.excel-email :$excel_email :key="$excel_email->id"></x-cards.excel-email>
                </li>
            @empty
                <li class="relative flex justify-between gap-x-6 py-5 px-5">
                    <div class="flex min-w-0 gap-x-4 items-center">
                        <x-icon name="exclamation" class="h-12 w-12 flex-none text-indigo-200" />
                        <div class="min-w-0 flex-auto">
                            <p class="mt-1 flex text-xl leading-5 text-gray-500">
                                <span class="relative truncate">
                                    No se encontró correos para este documento de importación
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-x-4"></div>
                </li>
            @endforelse
        </ul>

        <div class="w-full mt-5">
            {{ $excel_emails->links() }}
        </div>
    </div>
