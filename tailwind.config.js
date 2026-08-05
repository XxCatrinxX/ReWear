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
            colors: {
                primary: '#2E7D32',
                'primary-hover': '#1B5E20',

                secondary: '#4CAF50',

                accent: '#D4A373',

                background: '#F8FAF7',

                surface: '#FFFFFF',

                border: '#E5E7EB',

                text: '#263238',

                muted: '#607D8B',

                success: '#43A047',

                warning: '#FFB300',

                danger: '#E53935',
            },

            borderRadius: {
                card: '24px',

                button: '14px',

                input: '14px',
            },

            boxShadow: {
                card: '0 10px 30px rgba(0,0,0,.08)',

                soft: '0 4px 16px rgba(0,0,0,.06)',
            },

            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                outfit: ['Outfit', ...defaultTheme.fontFamily.sans],
            }
            
        },

    },

    plugins: [forms],
};
