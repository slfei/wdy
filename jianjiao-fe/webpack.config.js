var path = require('path')
var fs = require('fs')
var webpack = require('webpack')
var merge = require('webpack-merge')
var vueStyleLoader = require('./vueStyleLoader')
var ExtractTextPlugin = require('extract-text-webpack-plugin')
var OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin')

var isProduction = process.env.NODE_ENV === 'production'

function resolve (dir) {
    return path.join(__dirname, dir)
}
var config =  {
    //entry: { index: './src/entry/index.js', category: './src/entry/category.js'},
    output: {
        //path: path.resolve(__dirname, './build'),
        //publicPath: '/build/',
        filename: 'js/[name].js'
    },
    //watch: true,
    cache: true,
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: vueStyleLoader.cssLoaders({
                        sourceMap: isProduction,
                        extract: true
                    }),
                    postcss: require('./postcss.config.js').plugins
                }
            },

            {
                test: /\.js$/,
                loader: 'babel-loader?cacheDirectory',
                include: [resolve('src')],
                options: {
                    "presets": ['es2015'],
                    "plugins": ["transform-runtime"],
                }
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            }
        ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            'iscroll': 'src/lib/iscroll.js',
            '@': resolve('src')
        }
    },

    performance: {
        hints: false
    },
    devtool: '#eval-source-map'
}

var stylesLoaders = vueStyleLoader.styleLoaders({sourceMap: isProduction, extract: true}).map(rule => {
    rule.exclude = fs.realpathSync(resolve('node_modules/mint-ui'));
    rule.use.push('postcss-loader');
    return rule;
});
var mintUiStyleLoaders = vueStyleLoader.styleLoaders({sourceMap: isProduction, extract: true}).map(rule => {
    rule.include = fs.realpathSync(resolve('node_modules/mint-ui'));
    rule.use.push({
        loader: 'postcss-loader',
        options: {
            plugins: [
                require('./postcss-px2rem')({
                    remUnit: 37.5
                })
            ]
        }
    });
    //console.log(rule.use);
    return rule;
});
stylesLoaders = stylesLoaders.concat(mintUiStyleLoaders);
config = merge(config, {
    module: {
        rules: stylesLoaders
    }
});

module.exports = config;

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            //sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        // extract css into its own file
        new ExtractTextPlugin({
            filename: 'css/[name].css'
        }),
        // Compress extracted CSS. We are using this plugin so that possible
        // duplicated CSS from different components can be deduped.
        new OptimizeCSSPlugin({
            cssProcessorOptions: {
                safe: true
            }
        }),
        // split vendor js into its own file
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vendor',
            minChunks: function (module, count) {
                // any required modules inside node_modules are extracted to vendor
                return (
                    module.resource &&
                    /\.js$/.test(module.resource) &&
                    module.resource.indexOf(
                        path.join(__dirname, '/node_modules')
                    ) === 0
                )
            }
        }),
        // extract webpack runtime and module manifest to its own file in order to
        // prevent vendor hash from being updated whenever app bundle is updated
        //new webpack.optimize.CommonsChunkPlugin({
        //    name: 'manifest',
        //    chunks: ['vendor']
        //}),
        //new webpack.LoaderOptionsPlugin({
        //    minimize: true
        //})
    ])
} else {
    module.exports.devtool = '#source-map';
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"development"'
            }
        }),
        //new webpack.optimize.UglifyJsPlugin({
        //    sourceMap: true,
        //    compress: {
        //        warnings: false
        //    }
        //}),
        // extract css into its own file
        new ExtractTextPlugin({
            filename: 'css/[name].css'
        }),
        // Compress extracted CSS. We are using this plugin so that possible
        // duplicated CSS from different components can be deduped.
        // new OptimizeCSSPlugin({
        //    cssProcessorOptions: {
        //        safe: true
        //    }
        // }),
        // split vendor js into its own file
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vendor',
            minChunks: function (module, count) {
                // any required modules inside node_modules are extracted to vendor
                return (
                    module.resource &&
                    /\.js$/.test(module.resource) &&
                    module.resource.indexOf(
                        path.join(__dirname, '/node_modules')
                    ) === 0
                )
            }
        }),
        // extract webpack runtime and module manifest to its own file in order to
        // prevent vendor hash from being updated whenever app bundle is updated
        //new webpack.optimize.CommonsChunkPlugin({
        //    name: 'manifest',
        //    chunks: ['vendor']
        //}),

    ])
}


