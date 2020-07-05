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
mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
});
mix.js([
        'resources/js/app.js',
        'public/app/index.js',
        'public/app/container/index.js',
        'public/app/container/common.js',
        'public/app/detail-shippers/index.js',
        'public/app/map/index.js',
        'public/app/map/location.js',
        'public/app/orders/create.js',
        'public/app/orders/edit.js',
        'public/app/portal/index.js',
        'public/app/prices/index.js',
        'public/app/units/index.js',
        'public/app/users/create.js',
        'public/app/users/edit.js',
        'public/app/users/info.js',
    ],
    'public/js');
