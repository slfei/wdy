/**
 * Created by huangzhongjian on 17/11/20.
 */


export function parseQuery(queryString) {
    if (queryString === undefined) {
        queryString = location.search.slice(1);
    }
    if (queryString.length == 0) {
        return {};
    }
    var ret = {};
    var tmp = queryString.split('&');
    tmp.forEach(field => {
        var arr = field.split('=');
        if (arr.length == 2) {
            ret[ arr[0] ] = arr[1]
        }
    });

    return ret;
}

