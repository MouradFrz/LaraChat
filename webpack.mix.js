const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/anyMessage.js', 'public/js')
.js('resources/js/privateListener.js', 'public/js')
.js('resources/js/userSearch.js', 'public/js')
.sass('resources/sass/homepage.scss','public/css')
.sass('resources/sass/extra.scss','public/css')
.sass('resources/sass/convo.scss','public/css')