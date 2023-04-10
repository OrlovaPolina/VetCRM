import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
const path = require('path');
export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/css/app.scss',
            'resources/css/manager.scss',
            'resources/js/app.js',
            'resources/js/fullCalendar/index.global.js',
            'resources/js/calendar.js',
            'resources/js/manager.js',
            'resources/css/public.scss',
        ]),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});