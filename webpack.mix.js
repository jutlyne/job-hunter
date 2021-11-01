const webpack = require('webpack');
const mix = require('laravel-mix');

require("dotenv").config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
  plugins: [
    new webpack.ContextReplacementPlugin(
      /moment[\/\\]locale/,
      // A regular expression matching files that should be included
      /(vi)\.js/
    )
  ],
  resolve: {
    alias: {
      '~': path.join(__dirname, './resources/assets/vue')
    }
  },
});

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/moment.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/store/review.scss', 'public/css/store/pages')
  .sass('resources/sass/user/profile.scss', 'public/css')
  .sass('resources/sass/user/pages/garage/show.scss', 'public/css/user/pages/garage')
  .sass('resources/sass/user/pages/garage/index.scss', 'public/css/user/pages/garage')
  .sass('resources/sass/user/pages/reservation/index.scss', 'public/css/user/pages/reservation')
  .sass('resources/sass/user/footer.scss', 'public/css/user')
  .sass('resources/sass/user/user.scss', 'public/css');

mix.js('node_modules/@coreui/coreui/dist/js/coreui.js', 'public/coreui/js')
  .copy('node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css', 'public/tempusdominus-bootstrap-4/')
  .copy('node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js', 'public/tempusdominus-bootstrap-4/')
  .copy('node_modules/daterangepicker/daterangepicker.css', 'public/daterangepicker/')
  .copy('node_modules/daterangepicker/daterangepicker.js', 'public/daterangepicker/')
  .sass('resources/sass/coreui/style.scss', 'public/coreui/css');

mix.copy('resources/css/', 'public/custom/css');
mix.copy('resources/js/', 'public/custom/js');
// font awesome
mix.copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/css/font-awesome-free.min.css');
mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

/* CKeditor-4 */
mix.copy('node_modules/ckeditor4/adapters', 'public/ckeditor/adapters');
mix.copy('node_modules/ckeditor4/lang', 'public/ckeditor/lang');
mix.copy('node_modules/ckeditor4/plugins', 'public/ckeditor/plugins');
mix.copy('node_modules/ckeditor4/skins', 'public/ckeditor/skins');
mix.copy('node_modules/ckeditor4/vendor', 'public/ckeditor/vendor');
mix.copy('node_modules/ckeditor4/styles.js', 'public/ckeditor/styles.js');
mix.copy('node_modules/ckeditor4/package.json', 'public/ckeditor/package.json');
mix.copy('node_modules/ckeditor4/ckeditor.js', 'public/ckeditor/ckeditor.js');
mix.copy('node_modules/ckeditor4/config.js', 'public/ckeditor/config.js');
mix.copy('node_modules/ckeditor4/composer.json', 'public/ckeditor/composer.json');
mix.copy('node_modules/ckeditor4/contents.css', 'public/ckeditor/contents.css');

// Summernote 4
mix.copyDirectory('node_modules/summernote/', 'public/summernote/');

mix.copy('resources/assets/img/', 'public/img/');
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/');
mix.copy('node_modules/@coreui/icons/sprites/free.svg', 'public/coreui/icons/');

// onesignal
mix.copy('resources/assets/js/OneSignalSDKUpdaterWorker.js', 'public/');
mix.copy('resources/assets/js/OneSignalSDKWorker.js', 'public/');

// google maps
mix.copy('resources/assets/js/mapInput.js', 'public/js');
mix.copy('resources/assets/js/AjaxAct.js', 'public/js');

// Bootstrap toggle
mix.copy('node_modules/bootstrap4-toggle/css/bootstrap4-toggle.min.css', 'public/css');
mix.copy('node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js', 'public/js');

//select 2
mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/js');
mix.copy('node_modules/select2/dist/css/select2.min.css', 'public/css');

//rating
mix.copy('node_modules/jquery-bar-rating/dist/jquery.barrating.min.js', 'public/rating');
mix.copy('node_modules/jquery-bar-rating/dist/themes', 'public/rating/themes');

//sweetalert2
mix.copy('node_modules/sweetalert2/dist/sweetalert2.all.min.js', 'public/js')
mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css')
// mix.copy('storage/app/public', 'public/storage');
