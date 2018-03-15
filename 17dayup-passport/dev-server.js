
var express = require('express');
var proxy = require('http-proxy-middleware');
var app = express();
var opn = require('opn');

var webpackConfig = require('./webpack.config.js');
webpackConfig.watch = true;

var port = 17171;
var hasOpen = false;
var compiler = require('webpack')(webpackConfig, function(err, stats) {
    if (err) throw err;
    console.log(stats.toString({
        chunks: false,
        colors: true
    }));

    if (!hasOpen){
        opn('http://dev.ac.enimo.cn:' + port);
        hasOpen = true;
    }

});


app.use('/api', proxy({
    target: 'http://passport.ac.enimo.cn',
    changeOrigin: true
}));
app.use('/', express.static('./build'));

app.listen(port);