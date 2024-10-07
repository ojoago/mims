import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                bahaus: ['bauhaus 93'],
            },
            colors: {
            optimal: {
            light: '#3bb3c2',
            DEFAULT: '#3bb3c2',
            dark: '#3bb3c2',
            },
        },
        keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
        'fade-in-down':{
          "from":{
            transform: "translateY(-0.75rem)",
            opacity:'0'
          },
          "to":{
            transform: "translateY(0rem)",
            opacity:'1'
          }
        }
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        "fade-in-down": "fade-in-down 0.2s ease-in-out both",
      },
        },
    },

    plugins: [forms],
};
