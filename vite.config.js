import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base : 'http://full-stack-challenge-production-ddbc.up.railway.app:8000/build/',
    server: {
        host: '0.0.0.0', // Allow external connections
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
        emptyOutDir: true,     
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
                entryFileNames: 'assets/[name]-[hash].js',
            }
        }
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    }
});
