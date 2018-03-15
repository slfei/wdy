module.exports = {
    localDir: './',

    // It decides the root path to upload to.
    remoteDir: '/home/bae/wwwroot/17dayup-h5/',

    // It decides the root accessible path.
    rootAllowed: '/',
    host: /*'111.202.110.66',*/ '111.202.110.66',
    port: 8345,
    pattern: ['src/**/*.*', 'mobile/**/*.*', './*.js'],
    pollingInterval: 500,
    password: 'jiaojiao!@#',

    // If it is set, transfer data will be encrypted with the algorithm.
    //algorithm: 'aes128',

    onChange: function (type, path, oldPath) {
        // It can also return a promise.
        console.log('Write your custom code here')
    }
}

