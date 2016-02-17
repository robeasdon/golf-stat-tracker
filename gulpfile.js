var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': './vendor/bower_components/bootstrap-sass/assets/',
    'jquery': './vendor/bower_components/jquery/',
    'd3': './vendor/bower_components/d3/'
};

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scripts([
        paths.jquery + 'dist/jquery.min.js',
        paths.bootstrap + 'javascripts/bootstrap.min.js'
    ], 'public/js/app.js', './');

    mix.copy(paths.d3 + 'd3.min.js', 'public/js/d3.min.js', './');
    mix.copy('resources/assets/js/modules', 'public/js/modules', './');

    mix.version(['css/app.css', 'js/app.js', 'js/d3.min.js', 'js/modules/*.js']);

    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap');
});

