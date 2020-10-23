let mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Mix Setting
|--------------------------------------------------------------------------
|
| Some project setting
|
*/

mix.options({
    terser: {
        extractComments: false,
    }
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

mix.js('resources/js/face/entry/profile-order.js', 'public/js/face');
mix.js('resources/js/admin/entry/category.js', 'public/js/admin');
mix.js('resources/js/admin/entry/order.js', 'public/js/admin');

mix.styles([
    'public/css/bootstrap.css',
    'public/css/bootstrap-switch.css',
    'public/css/bootstrap-toggle.min.css',
    'public/css/core.css',
    'public/css/components.css',
    'public/css/icons/icomoon/styles.css',
    'public/css/top.css',
    'public/css/main.css',
    'public/css/products.css',
    'public/css/loader.css',
    'public/css/owl.carousel.min.css',
    'public/css/owl.theme.default.min.css',
], 'public/style/common.css');

mix.version();
