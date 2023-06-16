import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

import { createRequire } from 'module';
const require = createRequire(import.meta.url);

export default defineConfig({
    server: {
        hmr: {
            host: '127.0.0.1',
            overlay: false
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
