import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Shared
                'resources/js/shared/theme.js',
                // Guest
                'resources/js/guest.js',
                // User
                'resources/js/user.js',
                // Admin
                'resources/js/admin.js',
                'resources/js/admin/chart-area-demo.js',
                'resources/js/admin/chart-bar-demo.js',
                'resources/js/admin/chart-pie-demo.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ],
    server: {
        host: '127.0.0.1',
        watch: {
            usePolling: true,
        },
    },
    resolve: {
        alias: {
            $fonts: resolve('./resources/fonts')
        }
    },
    build: {
        outDir: 'public/build',
        manifest: 'manifest.json',
        chunkSizeWarningLimit: 1000,
        // rollupOptions: {
        //     output: {
        //         manualChunks: {
        //             app: [
        //                 'lodash',
        //                 'jquery',
        //                 'axios',
        //                 '@popperjs/core',
        //                 'bootstrap',
        //                 '@fortawesome/fontawesome-free',
        //                 'flatpickr',
        //                 'sweetalert',
        //                 'vue',
        //                 'moment',
        //             ],
        //             admin: [
        //                 'chart.js',
        //                 'trix',
        //             ]
        //         }
        //     }
        // },
    },
});
