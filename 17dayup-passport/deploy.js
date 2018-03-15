var webpack = require('webpack');
var BosClient = require('bce-sdk-js').BosClient;

let config = {
    endpoint: 'http://bos.bj.baidubce.com',
    credentials: {
        ak: 'ef79696626b64531855acabfd78c1c69',
        sk: '9168f3a5371d4bd89e6f7fae626cff92'
    }
};

webpack(require('./webpack.config.js'), function(err, stats) {
    if (err) throw err;
    console.log(stats.toString({
        chunks: false,
        colors: true
    }));

    let client = new BosClient(config);
    let options = {
        //x-bce-meta-foo1: 'bar1', // 添加自定义meta信息
        //x-bce-meta-foo2: 'bar2', // 添加自定义meta信息
        //x-bce-meta-foo3: 'bar3' // 添加自定义meta信息
        "Cache-Control": 'no-cache'
    };

    Promise.all([
            client.putObjectFromFile('17dayup-passport-dev', 'passport.js', './build/passport.js', options),
            client.putObjectFromFile('17dayup-passport-dev', 'passport.css', './build/passport.css', options)
        ])
        .then(function() {
            console.log('发布完成')
        })
        .catch(console.log);
});