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

 mix.sass('resources/scss/app.scss', 'public/css')
 .options({ processCssUrls: false })
 .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css')
 .copy('node_modules/@selectize/selectize/dist/css/selectize.css', 'public/css')
 .copy('node_modules/@selectize/selectize/dist/css/selectize.default.css', 'public/css')
 .copy('node_modules/@selectize/selectize/dist/css/selectize.bootstrap5.css', 'public/css')
 .version();

// Compile and bundle JavaScript
mix.js('resources/js/app.js', 'public/js')
 .copy('node_modules/jquery/dist/jquery.min.js', 'public/js')
 .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js')
 .copy('node_modules/@popperjs/core/dist/umd/popper.min.js', 'public/js')
 .copy('node_modules/@selectize/selectize/dist/js/selectize.min.js', 'public/js')
 .version();




