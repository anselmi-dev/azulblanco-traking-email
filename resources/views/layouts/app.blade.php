<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: localStorage.getItem('darkMode') || localStorage.setItem('darkMode', 'system'),
        toggleDarkMode () {
            if (this.darkMode == 'dark') {
                this.darkMode = 'light';
            } else if (this.darkMode == 'light') {
                this.darkMode = 'dark';
            } else {
                this.darkMode = 'dark';
            }
        },
    }"
    x-init="
        $watch('darkMode', val => localStorage.setItem('darkMode', val))
    "
    x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Azulblanco') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            [x-cloak] {
                display: none;
            }
        </style>

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <wireui:scripts />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-800" x-cloak style=".dark\:bg-gray-800:where(.dark, .dark *) {
        --tw-bg-opacity: 1;
        background-color: rgb(31 41 55 / var(--tw-bg-opacity));
    }">
        <x-banner />
        <x-notifications  position="bottom-center" />

        <div class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')

        @stack('modals')

        {{-- @livewireScripts --}}
        @livewireScriptConfig
    </body>
</html>
