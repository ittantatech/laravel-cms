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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.styles([
    'public/global/css/icons/icomoon/styles.css',
    'public/global/css/icons/fontawesome/styles.min.css',
    'public/global/css/bootstrap.min.css',
    'public/global/css/bootstrap_limitless.min.css',
    'public/global/css/layout.min.css',
    'public/global/css/components.min.css',
    'public/global/css/colors.min.css',
    'public/global/css/toastr.css',
], 'public/admin/css/backend.css');


mix.scripts([
    'public/global/js/main/jquery.min.js',
    'public/global/js/main/bootstrap.bundle.min.js',
    'public/global/js/plugins/extensions/jquery_ui/widgets.min.js',
    'public/global/js/plugins/extensions/jquery_ui/interactions.min.js',
    'public/global/js/plugins/extensions/jquery_ui/touch.min.js',
    'public/global/js/plugins/loaders/blockui.min.js',
    'public/global/js/plugins/tables/datatables/datatables.min.js',
    'public/global/js/plugins/forms/selects/select2.min.js',
    'public/global/js/plugins/forms/styling/uniform.min.js',
    'public/global/js/toastr.min.js',
    'public/global/js/jquery.form.js',
    'public/global/js/app.js',
    'public/global/js/demo_pages/datatables_advanced.js',
    'public/global/js/plugins/uploaders/dropzone.min.js',
    'public/global/js/plugins/forms/wizards/steps.min.js',
    'public/global/js/plugins/forms/validation/validate.min.js'
], 'public/admin/js/backend.js');