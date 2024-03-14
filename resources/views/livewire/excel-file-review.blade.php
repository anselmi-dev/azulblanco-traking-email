<div class="max-w-7xl mx-auto px-6 lg:px-8 pt-5">
    <x-breadcrumbs.container>
        <x-breadcrumbs.item href="{{ route('dashboard') }}">
            Dashboard
        </x-breadcrumbs.item>
        <x-breadcrumbs.item>
            Hitorial
        </x-breadcrumbs.item>
    </x-breadcrumbs.container>
    <div class="py-12 w-full">

    <div class="lg:flex lg:items-center lg:justify-between mb-10">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-600 sm:truncate sm:text-3xl sm:tracking-tight">
                # 00{{ $file->id }} - {{ $file->original_name }}
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-600">
                    <x-icon name="user-circle" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-500"></x-icon>
                    {{ optional($file->user)->name }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-600">
                    <x-icon name="mail" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-500"></x-icon>
                    Emails ({{ $emails->count() }})
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
            {{-- <span class="block">
                <button type="button"
                    class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-gray-600 shadow-sm hover:bg-white/20">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path
                            d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                    </svg>
                    Edit
                </button>
            </span>
            <span class="ml-3 block">
                <button type="button"
                    class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-gray-600 shadow-sm hover:bg-white/20">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path
                            d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z" />
                        <path
                            d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z" />
                    </svg>
                    View
                </button>
            </span> --}}
            <span class="sm:ml-3">
                <a href="{{ $file->file_path }}" target="__blank"
                    class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    <x-icon name="download" class="-ml-0.5 mr-1.5 h-5 w-5" ></x-icon>
                    Decargar documento importado
                </a>
            </span>
        </div>
    </div>

    <div class="w-full text-2xl mb-2">
        <span class="flex items-center text-gray-500">
            <x-icon name="mail" class="h-10 w-10 mr-1 rounded-full bg-gray-200 p-1"></x-icon>
            Correos enviados
        </span>
        <p class="text-base text-gray-500">
            Visualización de cada una de los envios de correos que fueron realizados por el archivo XLSX.
        </p>
    </div>

    <ul role="list" class="divide-y divide-gray-100 bg-white rounded">
        @forelse ($emails as $email)
            <li class="w-full">
                <x-cards.excel-email :$email :key="$email->id"></x-cards.excel-email>
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
        {{ $emails->links() }}
    </div>
</div>
