<div class="max-w-7xl mx-auto px-4 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            {{ __('Settings') }}
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-10 w-full">
        <div class="w-full text-xl lg:text-2xl mb-10">
            <span class="flex items-start text-gray-500 dark:text-white">
                <x-icon name="cog" class="h-10 w-10 mr-1"></x-icon>
                {{ __('Settings') }}
            </span>
        </div>
        <div class="relative">
            <div class="lg:flex lg:items-center lg:justify-between mb-10 text-gray-600 dark:text-white w-full">
                <form wire:submit.prevent="submit" class="relative w-full">
                    <div class="space-y-12 w-full">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-lg font-semibold leading-7 text-gray-900">Entorno</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Esto significa que los correos electrónicos del documento de Excel serán enviados.
                                </p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                                <div class="sm:col-span-4">
                                    <x-checkbox id="lg" lg wire:model="production" label="Modo de producción"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-12 w-full">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3 pt-5">
                            <div>
                                <h2 class="text-lg font-semibold leading-7 text-gray-900">Correo de pruebas</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Este será el correo de pruebas al que se enviarán todos los correos electrónicos que se generen al procesar el documento.
                                </p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                                <div class="sm:col-span-4">
                                    <x-input id="lg" lg wire:model="email_test" placeholder="correo de pruebas" hint="Recuerda que solo se tendrá en cuenta cuando el entorno no esté en producción."/>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="space-y-12 w-full">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3 pt-5">
                            <div>
                                <h2 class="text-lg font-semibold leading-7 text-gray-900">Delay</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Introduce la frecuencia en segundos para el intervalo de tiempo entre cada envío de correo electrónico.
                                </p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                                <div class="sm:col-span-4">
                                    <x-inputs.number wire:model="delay" class="w-auto" min="0"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <x-button primary right-icon="arrow-circle-right" spinner type="submit">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
