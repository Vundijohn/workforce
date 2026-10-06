import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                outlier: {
                    50: '#FFF7F2',
                    100: '#FFEFE5',
                    200: '#FFDEC9',
                    300: '#FFBE9B',
                    400: '#F28A52',
                    500: '#E06927',
                    600: '#C8581E',
                    700: '#A64315',
                    800: '#853412',
                    900: '#6C2B10',
                },
                ink: {
                    900: '#111111',
                    800: '#1E1E1E',
                    700: '#2D2D2D',
                    600: '#4A4A4A',
                    500: '#666666',
                    400: '#8A8A8A',
                    300: '#B0B0B0',
                    200: '#E5E5E5',
                    100: '#F4F5F7',
                    50: '#F8F9FA',
                }
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03)',
                'card': '0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 5px 15px -5px rgba(0, 0, 0, 0.02)',
                'glow': '0 0 40px -10px rgba(224, 105, 39, 0.25)',
            }
        },
    },

    plugins: [forms],
};
