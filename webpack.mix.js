require("dotenv").config();
const mix = require("laravel-mix");

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
    .js("resources/js/login.js", "public/js")
    .js("resources/js/admin.js", "public/js")
    .js("resources/js/user.js", "public/js")
    .js("resources/js/user_profile.js", "public/js")
    .js("resources/js/vue_initialization.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css");

// mix.webpackConfig(webpack => {
//     return {
//         plugins: [
//             new webpack.EnvironmentPlugin([
//                 "MIX_VUE_BASE_URL",
//                 "MIX_VUE_API_URL"
//             ])
//         ]
//     };
// });

mix.browserSync("127.0.0.1:8000");
