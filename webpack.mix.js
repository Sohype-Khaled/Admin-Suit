const mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
	plugins: [
		new webpack.DefinePlugin({
			__VUE_OPTIONS_API__: false,
			__VUE_PROD_DEVTOOLS__: false
		})
	]
});

mix.js('resources/src/js/app.js', 'resources/assets/admin-suit')
	.vue()
	.setPublicPath('resources/assets/admin-suit');
//
// mix.js('resources/src/js/app.js', '../../MOS/Backend/public/admin-suit/ad-su')
// 	.vue({version: 3})
// 	.setPublicPath('../../MOS/Backend/public/admin-suit/ad-su');