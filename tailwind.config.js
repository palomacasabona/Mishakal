import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                celeste: '#007bff', // Azul celeste personalizado
                verde: '#28a745',  // Verde para botones
            },
            screens: {
                xs: '475px', // Extra pequeño (para dispositivos móviles más pequeños)
            },
        },
    },
    plugins: [],
};
