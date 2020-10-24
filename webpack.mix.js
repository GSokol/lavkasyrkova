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

// copy directories
mix.copyDirectory('resources/fonts', 'public/fonts');

// scripts
mix.js('resources/js/face/entry/profile-order.js', 'public/js/face');
mix.js('resources/js/admin/entry/category.js', 'public/js/admin');
mix.js('resources/js/admin/entry/order.js', 'public/js/admin');

// face
mix.styles([
    'resources/style/bootstrap.css',
    'resources/style/bootstrap-switch.css',
    'resources/style/bootstrap-toggle.min.css',
    'resources/style/core.css',
    'resources/style/components.css',
    'resources/fonts/icomoon/styles.css',
    'resources/style/top.css',
    'resources/style/main.css',
    'resources/style/products.css',
    'resources/style/loader.css',
    'resources/style/owl.carousel.min.css',
    'resources/style/owl.theme.default.min.css',
], 'public/style/common.css');

// auth
mix.styles([
    'resources/fonts/icomoon/styles.css',
    'resources/style/bootstrap.css',
    'resources/style/core.css',
    'resources/style/components.css',
    'resources/style/colors.css',
    'resources/style/main.css',
    'resources/style/auth.css',
], 'public/style/auth.css');

mix.scripts([
    'public/js/core/libraries/jquery.min.js',
    'public/js/core/libraries/bootstrap.min.js',
    'public/js/plugins/forms/styling/uniform.min.js',
    'public/js/plugins/forms/styling/bootstrap-switch.js',
    'public/js/plugins/media/fancybox.min.js',
    'public/js/core/main.controls.js',
    'public/js/scrollreveal.min.js',
    'public/js/jquery.easing.1.3.js',
    'public/js/jquery.maskedinput.min.js',
    'public/js/input-value.js',
    'public/js/products.js',
    'public/js/loader.js',
    'public/js/owl.carousel.js',
    'public/js/main.js',
], 'public/js/face/app.js');

mix.version();
