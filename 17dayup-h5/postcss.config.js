
var postcss = require('postcss');
var Px2rem = require('px2rem');
var defaultOption = {
    // border 1px不处理
    filter: function(declaration) {
        var pxReg = /\b(\d+(\.\d+)?)px\b/;
        //var pxReg = /\b1px
        if (
            /border(?:-(top|left|right|bottom))?/.test(declaration.property)
            && pxReg.test(declaration.value)
        ) {
            var n = +RegExp.$1;
            return n > 1;
        }
        return true;
    },
    remUnit: 37.5
};
var plugin = postcss.plugin('postcss-px2rem', function (options) {
    return function (css, result) {
        var oldCssText = css.toString();
        var px2remIns = new Px2rem(Object.assign({}, defaultOption, options));
        var newCssText = px2remIns.generateRem(oldCssText);
        var newCssObj = postcss.parse(newCssText);
        result.root = newCssObj;
    };
});

var px2remPlugin = plugin();

module.exports = {
    // plugins: [px2remPlugin]
};
