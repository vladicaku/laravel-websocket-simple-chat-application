var path = require('path');
var webpack = require('webpack');

module.exports = {
	entry: './public/js/chat.js',
	output: {
		path: path.resolve(__dirname, 'public/js'),
		filename: 'chat-bundle.js'
	},
	module: {
		loaders: [
			{
				test: /\.js$/,
				loader: 'babel-loader',
				query: {
					presets: ['es2015']
				}
			}
		]
	},
	stats: {
		colors: true
	},
	devtool: 'source-map'
};