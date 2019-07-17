const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js([
        './node_modules/amstock3/amcharts/amcharts.js',
        './node_modules/amstock3/amcharts/serial.js',
        './node_modules/amstock3/amcharts/themes/light.js',
        './node_modules/amstock3/amcharts/amstock.js',
        './node_modules/amstock3/amcharts/plugins/dataloader/dataloader.min.js'
    ], 'public/js/amcharts3.js')
    .js('resources/js/currency/detail-chart.js', 'public/js/detail-chart.js')
    .sass('resources/sass/app.scss', 'public/css');
