const mix = require('laravel-mix');
const del = require('del');

mix.setPublicPath('./dist');

mix.babel('./src/js/main.js', './dist/main.js');

mix.minify('./dist/main.js').then(() => {
	del('./dist/main.js');
});

mix.sass('./src/scss/back.scss', './dist/back.css');
mix.sass('./src/scss/front.scss', './dist/front.css');

mix.disableSuccessNotifications();

module.exports = {
	watch: true,
	mode: 'production',
};
