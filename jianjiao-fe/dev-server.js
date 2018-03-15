var express = require('express');
var laravelBladeCompiler = require('laravel-blade-compiler')
var request = require('request');
var proxy = require('http-proxy-middleware');
//'/xxx/', 'xxx.index'  配置页面对应的路由

// var routerMap = {
//     '/new': 'new',
//     '/': 'index'
// };

var routerMap = {
    '/institute/category': 'category',
    '/institute/detail/:id': 'institute/detail',
    '/news/discovery': 'news/discovery',
    '/news/:id': 'news/detail',
    '/account/register': 'uc/register',
    '/account/login': 'uc/login',
    '/account/center': 'uc',
    '/account/mycomment': 'uc/comments',
    '/favorite/collection': 'uc/collections',
    '/account/mytag': 'uc/tags',
    '/feedback/writefeedback': 'uc/feedback',
    '/institute/category/:id': 'institute/list',
    '/': 'index',
    '/aboutus': 'content',
    '/search': 'search/index',
    '/selectcity': 'common/set_location',
    '/account/edit': 'uc/edit',
    '/circle/question/detail': 'circle/question_detail'
};
var remoteUrl = 'http://test.jj2.enimo.cn';

module.exports = function () {
    var app = express();
    app.use('/build', express.static('./build'));

    app.use('/api', proxy({
        target: remoteUrl,
        changeOrigin: true
    }));

    var keys = Object.keys(routerMap);
    for (var i = 0, len = keys.length; i <len; i++) {
        app.get(keys[i], handler)
    }
    //app.get("*", handler);
    function handler(req, res) {
        var pathname = req.route.path;
        console.log(pathname, req.path);
        var templatePath = routerMap[pathname] ||
            pathname.slice(1) || 'index';

        if (templatePath.indexOf('.') > -1) {
            res.sendStatus(404);
            return res.end();
        }

        var str = bladeToHtml(templatePath);

        var apiPath = remoteUrl + req.url;
        ( apiPath.indexOf('?') == -1 ) ? apiPath += '?is_debug=1' : apiPath += '&is_debug=1';

        request(apiPath, {timeout: 2000}, function (err, response, body) {
            var tplData;
            try{
                tplData = JSON.parse(body).tplData || {};
            }catch (e){
                tplData = {};
            }
            str = str.replace(/try{(\w|\W)+?}catch/, 'try{$tplData = ' + JSON.stringify(tplData) + '}catch');
            return res.send(str);
        })
    }

    app.listen(8080);

};
function bladeToHtml(path) {
    path = path.replace(/\./g, '/');

    return laravelBladeCompiler({
        folder: './resources/views/',
        path: './resources/views/' + path + '.blade.php'
    })
}
