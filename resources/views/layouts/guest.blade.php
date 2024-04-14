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
    <body x-cloak>
        <div class="absolute top-5 right-5">
            <x-selector-dark-mode/>
        </div>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        {{-- @livewireScripts --}}
        @livewireScriptConfig
    </body>
</html>
