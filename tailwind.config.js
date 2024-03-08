import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import daisyui from "daisyui";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundColor: {
                'p-primary': '#eb826b',
                'p-secondary': '#f4ac84',
            },
            textColor: {
                'p-primary': '#eb826b',
                'p-secondary': '#f4ac84',
            }
        },
    },

    plugins: [forms, typography, daisyui],

    daisyui: {
        themes: [
            {
                light: {
                    "color-scheme": "light",
                    "primary": "#eb826b",
                    "secondary": "#f4ac84",
                    "secondary-content": "oklch(98.71% 0.0106 342.55)",
                    "accent": "#8300E9",
                    "neutral": "#2B3440",
                    "neutral-content": "#D7DDE4",
                    "base-100": "oklch(100% 0 0)",
                    "base-200": "#F2F2F2",
                    "base-300": "#E5E6E6",
                    "base-content": "#1f2937",
                },
            },
        ]
    },
};
