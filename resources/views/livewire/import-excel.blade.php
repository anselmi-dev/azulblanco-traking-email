<div class="max-w-7xl mx-auto px-4 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>

    @if (!$production)
        <div class="bg-yellow-200 rounded p-4 mt-5">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-700">
                        El entorno actual está en <strong class="text-gray-900">modo de prueba</strong>. Esto significa que no se enviarán correos electrónicos a las direcciones de correo electrónico que estén en el documento excel. Para cambiar al modo de producción, es necesario ajustar la configuración <a href="{{ route('settings') }}" class="font-bold text-gray-900 underline hover:text-gray-600">aquí</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="py-5 w-full divide-y divide-gray-300 dark:divide-gray-600">
        <form wire:submit.prevent="submit" class="relative">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-950 overflow-hidden shadow-xl sm:rounded-lg">

                    <livewire:dropzone wire:model="files" :rules="['mimes:xlsx', 'max:10420']" :multiple="false" class="w-full" />

                    <div class="px-4 sm:px-6 lg:px-8 w-full pt-2">

                        <x-errors />

                        <div class="w-full  mt-2 pt-2 justify-between flex pb-4">
                            <x-button href="{{ asset('files/template.xlsx') }}" dark right-icon="download" target="__blank">
                                <span class="hidden sm:flex">{{ __('Descargar plantilla') }}</span>
                            </x-button>

                            <x-button primary right-icon="arrow-circle-right" spinner type="submit">
                                {{ __('Procesar') }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
            <x-loading wire:loading.class.remove="hidden" class="hidden"/>
        </form>

        <div  class="max-w-7xl mx-auto my-5 pt-4">
            <livewire:excel-file-history></livewire:excel-file-history>
        </div>
    </div>
</div>
