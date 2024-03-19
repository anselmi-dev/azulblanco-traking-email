<button
    type="button"
    x-cloak
    x-on:click="toggleDarkMode()"
    class="flex items-center justify-center w-5 h-6 text-gray-600 dark:text-white">
    <span :class="{ 'hidden': darkMode == 'dark'}">
        <x-icon name="sun" class="h-5 w-5"></x-icon>
    </span>
    <span :class="{ 'hidden': darkMode == 'light'}">
        <x-icon name="moon" class="h-5 w-5"></x-icon>
    </span>
</button>
