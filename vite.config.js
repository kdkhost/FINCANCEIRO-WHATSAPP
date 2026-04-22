import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/frontend.css',
                'resources/js/frontend/app.jsx',
            ],
            refresh: true,
        }),
        tailwindcss(),
        react(),
    ],
});
