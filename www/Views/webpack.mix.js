const mix = require('laravel-mix');

mix.setPublicPath('./dist');

mix.js('./src/js/main.js', './dist/main.min.js');

mix.sass('./src/scss/back.scss', './dist/back.css');
mix.sass('./src/scss/front.scss', './dist/front.css');
mix.sass('./src/scss/themes/default.scss', './dist/themes/default.css');

mix.disableSuccessNotifications();

module.exports = {
	watch: true,
	mode: 'production',
};
