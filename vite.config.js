import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base : '/',
    server: {
        https: true, // Force Vite to use HTTPS in dev (optional)
        hmr: {
            host: 'full-stack-challenge-production-ddbc.up.railway.app',
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/js/app.ts'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
