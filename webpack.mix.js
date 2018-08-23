let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js/backend.js')
   .sass('resources/assets/sass/app.scss', 'public/css/backend.css');


mix.js('resources/assets/frontend/js/app.js', 'public/js/frontend.js')
    .sass('resources/assets/frontend/sass/app.scss', 'public/css/frontend.css');
