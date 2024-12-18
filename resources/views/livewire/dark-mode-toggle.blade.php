<div x-data="{ darkMode: $persist(false).as('darkMode') }" 
    x-init="$watch('darkMode', value => document.documentElement.classList.toggle('dark', value))">
    <button
        @click="darkMode = !darkMode"
        type="button"
        class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        role="switch"
        :aria-checked="darkMode"
        :class="{ 'bg-indigo-600': darkMode, 'bg-gray-200': !darkMode }"
    >
        <span class="sr-only">Toggle dark mode</span>
        <span
            aria-hidden="true"
            class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow pointer-events-none ring-0"
            :class="{ 'translate-x-5': darkMode, 'translate-x-0': !darkMode }"
        >
            <!-- Sun icon -->
            <span
                class="absolute inset-0 flex items-center justify-center transition-opacity"
                :class="{ 'opacity-0': darkMode, 'opacity-100': !darkMode }"
            >
                <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                </svg>
            </span>
            <!-- Moon icon -->
            <span
                class="absolute inset-0 flex items-center justify-center transition-opacity"
                :class="{ 'opacity-100': darkMode, 'opacity-0': !darkMode }"
            >
                <svg class="w-3 h-3 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                </svg>
            </span>
        </span>
    </button>
</div>
