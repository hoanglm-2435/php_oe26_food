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

mix.js('resources/js/confirm_delete.js', 'public/js')
    .js('resources/js/ajax.js', 'public/js')
    .js('resources/js/filter_validate.js', 'public/js')
    .js('resources/js/suggest_status.js', 'public/js')
    .js('resources/js/rating.js', 'public/js')
