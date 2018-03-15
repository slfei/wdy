
module.exports = {
    module: {
        loaders: [{
            test   : /\.js$/,
            exclude: /(node_modules|bower_components)/,
            loader : 'babel-loader',

            options: {
                presets: ['env']
            }

        }]
    },
    resolve: {
        alias: {
            "swiper$": 'swiper/dist/js/swiper.min.js'
        }
    }

};
