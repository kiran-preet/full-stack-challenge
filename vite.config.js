import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base : 'https://full-stack-challenge-production-ddbc.up.railway.app/',
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
    build: {
        manifest: true,
        outDir: 'public/build', // Explicitly set output directory
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
                entryFileNames: 'assets/[name]-[hash].js',
            }
        },
        base: '/build',
    },
});
