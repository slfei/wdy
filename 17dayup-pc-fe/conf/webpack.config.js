var webpack = require('webpack');
var path = require('path');

function resolve (dir) {
    console.log(path.join(__dirname, '..', dir))
    return path.join(__dirname, '..' ,dir)
}

module.exports = {
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|src\/lib)/,
                loader: 'babel-loader'
            }
        ]
    },
    resolve: {
        alias: {
            '~': resolve('src')
        }
    },

    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: false,
            compress: {
                warnings: false
            },
            comments: false
        })
    ]
};
