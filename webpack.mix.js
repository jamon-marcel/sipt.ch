const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            //'vue$': 'vue/dist/vue.esm.js',
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
mix.sass('resources/sass/app.scss', 'public/css');
      
// Dashboard
mix.js('resources/js/dashboard/student/app.js', 'public/assets/dashboard/js/bundle.student.js');
mix.js('resources/js/dashboard/administration/app.js', 'public/assets/dashboard/js/bundle.administration.js');
mix.sass('resources/sass/dashboard/app.scss', 'public/assets/dashboard/css/app.css').options({processCssUrls: false}).version();

