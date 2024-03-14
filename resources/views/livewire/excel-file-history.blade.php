<div class="w-full">
    <div class="w-full text-2xl mb-2">
        <span class="flex items-center text-gray-500">
            <x-icon name="document-duplicate" class="h-6 w-6"></x-icon>
            Historial de importación
        </span>
        <p class="text-base text-gray-500">
            Visualización de cada una de las importaciones realizadas a través del archivo XLSX, reflejando así todos los documentos importados en la lista.
        </p>
    </div>

    <div class="relative">
        <x-loading wire:loading.class.remove="hidden" class="hidden"/>
        <ul role="list" class="divide-y divide-gray-100 bg-white rounded">
            @foreach ($files as $file)
                <li class="w-full">
                    <livewire:excel-file-card :file="$file" :key="$file->id"/>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="w-full mt-5">
        {{ $files->links() }}
    </div>
</div>
