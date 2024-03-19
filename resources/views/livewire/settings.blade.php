<div class="max-w-7xl mx-auto px-6 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            {{ __('Settings') }}
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-10 w-full">
        <div class="w-full text-2xl mb-10">
            <span class="flex items-center text-gray-500 dark:text-white">
                <x-icon name="cog" class="h-10 w-10 mr-1 p-1"></x-icon>
                {{ __('Settings') }}
            </span>
        </div>
        <div class="relative">
            <div class="lg:flex lg:items-center lg:justify-between mb-10 text-gray-600 dark:text-white w-full">
                <form wire:submit.prevent="submit" class="relative w-full">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white dark:bg-gray-950 overflow-hidden shadow-xl sm:rounded-lg pt-5">
                            <div class="px-4 sm:px-6 lg:px-8 w-full pt-2 divide-y divide-gray-100 dark:divide-gray-600">
                                <div class="min-w-0 flex-1">
                                    <x-label class="text-xl mb-2">
                                        Modo de producción
                                    </x-label>

                                    <x-checkbox id="lg" lg wire:model.live="production" label="Esto significa que los correos electrónicos del documento de Excel serán enviados."/>
                                </div>

                                <x-errors />

                                <div class="w-full  mt-2 pt-2 justify-end flex pb-4">
                                    <x-button primary right-icon="arrow-circle-right" spinner type="submit">
                                        {{ __('Save') }}
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-loading wire:loading.class.remove="hidden" class="hidden"/>
                </form>
            </div>
        </div>
    </div>
</div>
