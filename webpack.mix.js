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

mix.js('resources/js/custom.js', 'public/js/custom.js')
   .sass('resources/sass/app.scss', 'public/css/custom.css')
   .scripts([
   		'node_modules/jquery/dist/jquery.js',
	    'resources/js/agency/popcalendar.js',
	    'resources/js/agency/cor_fundo.js',
	    'resources/js/agency/menu_array.js.htm',
	    'resources/js/agency/menu_script.js'
	], 'public/js/app.js');
