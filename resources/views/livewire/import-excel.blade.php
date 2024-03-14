<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-12 w-full">
        <form wire:submit.prevent="submit" class="relative">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:dropzone wire:model="files" :rules="['mimes:xls,xlsx', 'max:10420']" :multiple="false" class="w-full" />
                    <div class="sm:px-6 lg:px-8 w-full">
                        <x-errors />
                        <div class="w-full border-t border-gray-1 mt-2 pt-2 justify-between flex pb-4">
                            <x-button href="{{ asset('files/template.xls') }}" dark right-icon="download" target="__blank">
                                {{ __('Descargar plantilla') }}
                            </x-button>

                            <x-button primary right-icon="check" spinner type="submit">
                                {{ __('Procesar') }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
            <x-loading wire:loading.class.remove="hidden" class="hidden"/>
        </form>

        <div  class="max-w-7xl mx-auto mt-10 pt-10">
            <livewire:excel-file-history></livewire:excel-file-history>
        </div>
    </div>
</div>
