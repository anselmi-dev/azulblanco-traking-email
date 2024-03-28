<div class="max-w-7xl mx-auto px-4 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            Envios
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-10 w-full">
        <div class="w-full flex-col text-xl mb-2 pb-1 | flex space-y-5">
            <div class="flex-1">
                <span class="flex items-center text-gray-800 dark:text-gray-100">
                    Correos enviados
                </span>
                <p class="text-base text-gray-500 dark:text-gray-100">
                    Visualización de cada una de los envios de correos que fueron realizados por el archivo XLSX.
                </p>
            </div>
            <div class="flex flex-col lg:flex-row items-end justify-end gap-2 flex-1">
                <div class="w-full lg:w-auto flex-1">
                    <x-input wire:model="filters.search" wire:keydown.enter="resetPage" aria-placeholder="Buscar" placeholder="Buscar..."></x-input>
                </div>
                <div class="w-full lg:w-auto">
                    <x-native-select placeholder="Buscar por estado" :options="[
                        [
                            'name' => __('status:pending'),
                            'value' => 'pending',
                        ],
                        [
                            'name' => __('status:progress'),
                            'value' => 'progress',
                        ],
                        [
                            'name' => __('status:done'),
                            'value' => 'done',
                        ],
                        [
                            'name' => __('status:error'),
                            'value' => 'error',
                        ],
                    ]" option-label="name"
                        option-value="value" wire:model.live="filters.status" />
                </div>
                <div class="w-full lg:w-auto">
                    <x-native-select placeholder="Buscar por rol" :options="[
                            [
                                'name' => __('ARQUITECTO'),
                                'value' => 'ARQUITECTO',
                            ],
                            [
                                'name' => __('PROMOTOR'),
                                'value' => 'PROMOTOR',
                            ],
                            [
                                'name' => __('CONSTRUCTOR'),
                                'value' => 'CONSTRUCTOR',
                            ],
                        ]" option-label="name"
                    option-value="value" wire:model.live="filters.role" />
                </div>
            </div>
        </div>

        <ul role="list" class="divide-y divide-gray-100 bg-white dark:bg-gray-900 rounded">
            @forelse ($excel_emails as $excel_email)
                <li class="w-full">
                    <x-cards.excel-email :$excel_email :key="$excel_email->id"></x-cards.excel-email>
                </li>
            @empty
                <li class="relative flex justify-between gap-x-6 py-5 px-5">
                    <div class="flex min-w-0 gap-x-4 items-center">
                        <x-icon name="exclamation" class="h-12 w-12 flex-none text-indigo-200" />
                        <div class="min-w-0 flex-auto">
                            <p class="mt-1 flex text-xl leading-5 text-gray-500 dark:text-white">
                                <span class="relative">
                                    No se encontró correos para este documento de importación
                                </span>
                            </p>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>

        <div class="w-full mt-5">
            {{ $excel_emails->links() }}
        </div>
    </div>
</div>
