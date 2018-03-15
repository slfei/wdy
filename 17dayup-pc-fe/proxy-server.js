

var express = require('express');
var app = express();
var proxy = require('http-proxy-middleware');
var opn = require('opn');

app.use('/build', express.static(__dirname + '/build'));

app.use(proxy('/', {
    //target: 'http://test.ac.enimo.cn',
    target: 'http://live.ac.enimo.cn',
    changeOrigin: true
}));

app.listen('10086');
opn('http://proxy.ac.enimo.cn:10086');
