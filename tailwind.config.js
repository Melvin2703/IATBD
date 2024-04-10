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
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                "turquoise-main": "#65CCB8",
                "turquoise-base": "#CAEFE8",
                "pink-accent": "#CC8E65",
                "pink-accent-hover": "#C96A2B",
                "beige-accent": "#CC65B6",
                "beige-accent-hover": "#CC3DAD",
                "fair-pink": "#EEE2DC"
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
