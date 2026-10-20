/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                serif: ['"Cinzel"', 'Georgia', 'serif'],
                display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'monospace'],
            },
            letterSpacing: {
                tighter: '-0.04em',
                tight: '-0.02em',
                normal: '0em',
                wide: '0.05em',
                wider: '0.12em',
                widest: '0.22em',
                ultra: '0.35em',
            },
            colors: {
                glaciar: {
                    obsidian: '#06090e',
                    horizon: '#07111e',
                    black: '#0a0f18',
                    dark: '#0f172a',
                    surface: '#121a29',
                    'surface-light': '#1a2436',
                    border: 'rgba(255, 255, 255, 0.08)',
                    'border-light': 'rgba(0, 0, 0, 0.06)',
                    white: '#ffffff',
                    'gray-50': '#f8fafc',
                    'gray-100': '#f1f5f9',
                    'gray-200': '#e2e8f0',
                    'gray-300': '#cbd5e1',
                    'gray-400': '#94a3b8',
                    'gray-500': '#64748b',
                    'gray-600': '#475569',
                    'gray-700': '#334155',
                    'gray-800': '#1e293b',
                    'gray-900': '#0f172a',
                    ice: '#38bdf8',
                    'ice-light': '#7dd3fc',
                    'ice-dark': '#0284c7',
                    'ice-glow': 'rgba(56, 189, 248, 0.15)',
                    accent: '#38bdf8',
                    'accent-light': '#7dd3fc',
                    'accent-dark': '#0284c7',
                },
            },
            boxShadow: {
                'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.37)',
                'soft': '0 20px 40px -15px rgba(0, 0, 0, 0.05)',
                'glow': '0 0 30px rgba(56, 189, 248, 0.25)',
                'card': '0 10px 30px -10px rgba(0, 0, 0, 0.04)',
            },
            animation: {
                'fade-in': 'fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'slide-up': 'slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 6s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-8px)' },
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
