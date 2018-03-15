
import Rules from './rule';

/**
 * 转换成element-ui validator function
 */
function generateValidators(rules) {
    var ret = {};
    for (var key in rules) {
        if (rules.hasOwnProperty(key)) {
            let rule = rules[key];
            ret[key] = function(_, value, callback) {
                if (!rule.valid(value)) {
                    callback(rule.message);
                } else {
                    callback();
                }
            }
        }
    }
    return ret;
}

export default generateValidators(Rules);
