const mix = require('laravel-mix');

// Configure Vue 2 for Laravel Mix v6
mix.vue({ version: 2 });

mix.webpackConfig({
    resolve: {
        extensions: ['*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'],
        alias: {
            '@': __dirname + '/resources/js/dashboard/'
        },
    },
});


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

// Web
mix.sass('resources/sass/web/app.scss', 'public/assets/css/app.css').options({processCssUrls: false}).version();
mix.js('resources/js/web/app.js', 'public/assets/js/app.js');
      
// Dashboard
mix.js('resources/js/dashboard/student/app.js', 'public/assets/dashboard/js/bundle.student.js').version();
mix.js('resources/js/dashboard/tutor/app.js', 'public/assets/dashboard/js/bundle.tutor.js').version();
mix.js('resources/js/dashboard/administration/app.js', 'public/assets/dashboard/js/bundle.administration.js').version();
mix.sass('resources/sass/dashboard/app.scss', 'public/assets/dashboard/css/app.css').options({processCssUrls: false}).version();

