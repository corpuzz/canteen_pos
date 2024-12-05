import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                coral: {
                    50: '#fff5f2',
                    100: '#ffe6e1',
                    200: '#ffc9bc',
                    300: '#ffa28e',
                    400: '#ff7a5c',
                    500: '#ff4d1c',
                    600: '#ff3d0f',
                    700: '#cc3109',
                    800: '#a32707',
                    900: '#7a1d05',
                },
            },
        },
    },

    plugins: [forms],
};
