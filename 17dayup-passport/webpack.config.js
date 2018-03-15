var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    entry: {
        passport: './src/passport.js'
    },

    output: {
        filename: 'build/[name].js',
        library: 'wdy',
        libraryTarget: 'umd'
    },

    module: {
        loaders: [
            {
                test: /\.js$/,
                //loader: 'babel-loader?presets[]=es2015',
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: ['es2015']
                    }
                }]
            },
            {   test: /\.html$/,
                use: [{
                    loader: 'html-loader',
                    options: {
                        minimize: true
                    }
                }]
            },
            {   test: /\.css$/,
                use: ExtractTextPlugin.extract(['style-loader', 'css-loader'])
            },
            {
                test: /\.styl$/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'stylus-loader'],
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.png$/,
                use: ['url-loader']
            }
        ]
    },

    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: false,
            compress: {
                warnings: false
            },
            comments: false
        }),
        new ExtractTextPlugin('./build/[name].css'),
        new OptimizeCSSPlugin({
            cssProcessorOptions: {
                safe: true
            }
         })
    ]
};
