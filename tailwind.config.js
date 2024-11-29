import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],

    theme: {
        extend: {
            backgroundImage: {
                'brown-gradient': 'linear-gradient(to bottom, #ab550f, #f09224)',
                'brown-gradient-invert': 'linear-gradient(to bottom, #f09224, #ab550f)',
            },
            screens: {
                'max-620': { max: '620px' },
                'max-768': { max: '768px' },
            },
        },
    },

    plugins: [forms],
};

// #e9dfcd gris/blanco
//#f09224 naranja
//#ab550f  marron
//#fcba50 amarillo claro
//#0000d negro
