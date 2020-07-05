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
            'public/app/container/index.js',
            'public/app/container/common.js'
        ],
        'public/js/container')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/detail-shippers/index.js'
        ],
        'public/js/detail-shippers/index')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/map/index.js'
        ],
        'public/js/map/index')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/map/location.js'
        ],
        'public/js/map/location')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/orders/create.js'
        ],
        'public/js/orders/create')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/orders/edit.js',
        ],
        'public/js/orders/edit')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/portal/index.js',
        ],
        'public/js/portal/index')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/prices/index.js',
        ],
        'public/js/prices/index')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/units/index.js',
        ],
        'public/js/units/index')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/users/create.js',
        ],
        'public/js/users/create')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/users/edit.js',
        ],
        'public/js/users/edit')
    .js([
            'resources/js/app.js',
            'public/app/container/index.js',
            'public/app/users/info.js',
        ],
        'public/js/users/info');
