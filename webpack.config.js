'use strict';
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const env = process.env.NODE_ENV;
const devMode = process.env.NODE_ENV !== 'production';
// const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const location = {
    build: './public/site/assets/',
    js: './resources/site/assets/js/',

    style: './resources/site/assets/style/'
};

const output = {
    js: location.js,

    style: location.style
};

// define plugins
/*const plugins = (function(env) {
	let plugins = [
		new UglifyJsPlugin({
			sourceMap: false
		}),
	];

	if(env === 'production') {
		plugins.push(new CleanWebpackPlugin([location.build]));
	}

	return plugins;
})(env);*/

module.exports = {
	mode: 'production',
	/* stats: 'minimal', */
	entry: output,
	output: {
		filename: '[name].bundle.js',
		path: path.resolve(__dirname, location.build),
	},
	plugins: [
		/*new MomentLocalesPlugin({
			localesToKeep: ['es-us', 'uk'],
		}),*/
		new MiniCssExtractPlugin({
			filename: '[name].css',
		}),
		new webpack.SourceMapDevToolPlugin({
			exclude: ['popper.js']
		})
		/*new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })*/
	],
	module: {
		// configuration regarding modules
		rules: [
			{
				/*rules for modules (configure loaders, parser options, etc.)*/
				enforce: 'pre',
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'eslint-loader',
				options: {
					fix: true,
					smarttabs: true,
				},
			},
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
			},
			{
				test: /\.woff($|\?)|\.otf($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)|\.png($|\?)|\.jpg($|\?)|\.gif($|\?)/,
				use: 'url-loader',
			},
			{
				test: /\.handlebars$/,
				loader: 'handlebars-loader',
			},
			{
				test: /\.(sass|scss|css)$/,
				use: [
					{
						// creates style nodes from JS strings
						loader: 'style-loader',
						options: {},
					},
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							esModule: false,
						},
					},
					{
						/*translates CSS into CommonJS*/
						loader: 'css-loader',
						options: {
							url: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [
									[
										'autoprefixer',
										{
											// Options
										},
									],
								],
							},
						},
					},
					{
						/*compiles Sass to CSS, using Node Sass by default*/
						loader: 'sass-loader',
						options: {
							sassOptions: {
								outputStyle: 'compressed',
							},
						},
					},
				],
			},
		],
	},
	resolve: {
		extensions: ['.js', '.json', '.jsx', '.css'],
		modules: ['node_modules'],
		// fallback: {
		// 	fs: false,
		// },
	},
	watchOptions: {
		aggregateTimeout: 300,
		poll: false,
		ignored: ['assets/fonts/*', 'assets/images/*', 'node_modules'],
	},
	/*
	 * Don`s use, i have some problem with cashed files
	 */
	devServer: {
		host: '10.10.2.135',
		port: 3000,
		open: true,
		hot: true,
		inline: true,
		watchContentBase: true,
		historyApiFallback: true,
		/*contentBase: resolve(__dirname, ''),*/
		stats: {
			// children: true,
		},
	},
	node: {
		// fs: 'empty',
	},
	performance: {
		maxEntrypointSize: 40000000,
		maxAssetSize: 40000000,
	},
	optimization: {
		// minimize: false,
		minimizer: [
			new TerserPlugin({
				parallel: 4,
				// cache: true,
				extractComments: false,
				terserOptions: {
					ecma: 2019,
					parse: {},
					compress: {
						ecma: 2019,
					},
					mangle: true, // Note `mangle.properties` is `false` by default.
					module: false,
				},
			}),
			/*new OptimizeCssAssetsPlugin({
                assetNameRegExp: /\.css$/g,
                cssProcessor: require('cssnano'),
                cssProcessorPluginOptions: {
                    preset: ['default', { discardComments: { removeAll: true } }],
                },
                canPrint: true
            }),*/
		],
	},
};