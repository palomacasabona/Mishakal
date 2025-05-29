import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/sidebar.js',
                'resources/js/chatbot.js', // 👈 AÑADE ESTA LÍNEA
            ],
            refresh: true,
        }),
    ],
});
