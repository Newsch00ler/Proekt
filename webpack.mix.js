const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/css/app.scss', 'public/css')
   .version();

mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            proxy: 'localhost', // Замените на ваш домен
            files: [
                'app/**/*.php',
                'resources/views/**/*.php',
                'public/js/**/*.js',
                'public/css/**/*.css',
            ],
        }),
    ],
});
