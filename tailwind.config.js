import colors from 'tailwindcss/colors';
// Silence deprecated color rename warnings
const { lightBlue, warmGray, trueGray, coolGray, blueGray, ...safeColors } = colors;

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                ...colors,
                glaciar: {
                    black: '#000000',
                    white: '#FFFFFF',
                    'gray-50': '#F9F9F9',
                    'gray-100': '#F0F0F0',
                    'gray-300': '#D0D0D0',
                    'gray-500': '#888888',
                    'gray-700': '#444444',
                    'gray-900': '#111111',
                    accent: '#1A1A1A',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
