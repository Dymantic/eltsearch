const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

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

mix.js("resources/js/app.js", "public/js")
    .less("resources/less/app.less", "public/css")
    .js("resources/js/front.js", "public/js")
    .less("resources/less/front.less", "public/css")
    .js("resources/js/teacher-app.js", "public/js")
    .js("resources/js/school-app.js", "public/js")
    .js("resources/js/admin-app.js", "public/js")
    .options({
        postCss: [tailwindcss("./tailwind.config.js")],
    })
    .version();
