
var px2rem = require('./postcss-px2rem');
var px2remPlugin = px2rem();

module.exports = {
    plugins: [px2remPlugin]
};