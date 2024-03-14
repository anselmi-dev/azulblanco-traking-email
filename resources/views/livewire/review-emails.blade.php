<div class="max-w-7xl mx-auto px-6 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            Envios
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-12 w-full">

    <div class="w-full text-2xl mb-10">
        <span class="flex items-center text-gray-500">
            <x-icon name="mail" class="h-10 w-10 mr-1 rounded-full bg-gray-200 p-1"></x-icon>
            Correos enviados
        </span>
        <p class="text-base text-gray-500">
            Visualización de cada una de los envios de correos que fueron realizados por el archivo XLSX.
        </p>
    </div>

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
