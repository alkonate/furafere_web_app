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
    .sass('resources/sass/app.scss', 'public/css');

mix.setPublicPath('public');
mix.setResourceRoot('../');

//bring jquery lib
mix.copy('node_modules/jquery/dist/jquery.min.js','public/js');

//bring bootstrap autocomplete lib
mix.copy('node_modules/bootstrap-4-autocomplete/dist/bootstrap-4-autocomplete.min.js','public/js');

//bring typeahead lib
mix.copy('node_modules/jquery-typeahead/dist/jquery.typeahead.min.js','public/js');
mix.copy('node_modules/jquery-typeahead/dist/jquery.typeahead.min.css','public/css');

//bring autonumeric
mix.copy('node_modules/autonumeric/dist/autoNumeric.min.js','public/js');

//bring chart graph
mix.copy('node_modules/chart.js/dist/Chart.bundle.min.js','public/js');

//bring quagga barcode reader
mix.copy('node_modules/quagga/dist/quagga.min.js','public/js');

//bring @Zxing barcode reader
mix.copy('node_modules/@zxing/library/umd/index.min.js','public/js/zxing.min.js');
