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
                    black: '#0f172a',
                    dark: '#1e293b',
                    white: '#ffffff',
                    'gray-50': '#f8fafc',
                    'gray-100': '#f1f5f9',
                    'gray-300': '#cbd5e1',
                    'gray-500': '#64748b',
                    'gray-700': '#334155',
                    'gray-900': '#0f172a',
                    accent: '#3b82f6',
                    'accent-light': '#60a5fa',
                    'accent-dark': '#2563eb',
                },
            },
            boxShadow: {
                'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
                'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                'glow': '0 0 20px rgba(59, 130, 246, 0.5)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.4s ease-out forwards',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
