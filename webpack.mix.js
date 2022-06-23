const mix = require('laravel-mix');

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
}).webpackConfig((webpack) => {
    return {
        resolve: {
            alias: {
                // vue: 'vue/dist/vue.js',
            }
        },
    };
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

mix.setPublicPath('public');
// copy directories
mix.copyDirectory('resources/fonts', 'public/fonts');

// scripts
mix.js('resources/js/entry/store/index.js', 'js/face/store.js').vue({version: 3});
mix.js('resources/js/entry/profile-order.js', 'js/face').vue({version: 3});
mix.js('dashboard/resources/js/entry/category.js', 'js/dashboard').vue({version: 3});
mix.js('dashboard/resources/js/entry/order.js', 'js/dashboard').vue({version: 3});
mix.js('dashboard/resources/js/entry/product-item/index.js', 'js/dashboard/product-item.js').vue({version: 3});

// face
mix.sass('resources/style/entry/common.scss', 'style/face').options({
    processCssUrls: false,
});

// face auth
mix.styles([
    'resources/fonts/icomoon/styles.css',
    'resources/style/bootstrap.css',
    'resources/style/core.css',
    'resources/style/components.css',
    'resources/style/colors.css',
    'resources/style/main.css',
    'resources/style/auth.css',
], 'style/auth.css');

// dashboard
mix.styles([
    'resources/fonts/icomoon/styles.css',
    'resources/style/bootstrap.css',
    'resources/style/core.css',
    'resources/style/components.css',
    'resources/style/colors.css',
    'resources/style/dashboard.css',
    'resources/style/products.css',
    'resources/style/loader.css',
], 'style/managment.css');
mix.sass('dashboard/resources/style/entry/product-item.scss', 'public/style/dashboard');

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
], 'js/face/app.js');

mix.version();
