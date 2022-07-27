mix.js('resources/js/app.js', 'public/js')
.postCss('resources/css/app.css', 'public/css')
.sass('resources/sass/app.scss', 'public/css')
.sourceMaps();

if(mix.inProduction()){
mix.version();
} 