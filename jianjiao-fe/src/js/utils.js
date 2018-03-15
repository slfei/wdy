function goBack(url) {
    // console.log(url)
    // console.log(window.history)
    var historyLength = history && history.length;
    try {
        if (historyLength == 1 && (url && url[0] == '/')) {
                location.href = url;
        } else {
            if ((historyLength ===1 || historyLength ===2) && url.indexOf('quiz/detail/')>0) {
                location.href = '/';
            }
            else{
                history.go(-1);
            }
        }

    } catch (e) {
        location.href = '/';
    }
}
function login_page() {
    location.href = '/account/login';
}
function test_result_detail(id) {
    console.log(id)
    location.href = '/quiz/result/'+id;
}
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function apiFeedback(data, sucMsg, errMsg) {
}

/*
 * 频率控制 返回函数连续调用时，fn 执行频率限定为每多少时间执行一次
 * @param fn {function}  需要调用的函数
 * @param delay  {number}    延迟时间，单位毫秒
 * @param immediate  {bool} 给 immediate参数传递false 绑定的函数先执行，而不是delay后后执行。
 * @return {function}实际调用函数
 */
var throttle = function (fn, delay, immediate, debounce) {
    var curr = +new Date(),//当前事件
        last_call = 0,
        last_exec = 0,
        timer = null,
        diff, //时间差
        context,//上下文
        args,
        exec = function () {
            last_exec = curr;
            fn.apply(context, args);
        };
    return function () {
        curr= +new Date();
        context = this,
            args = arguments,
            diff = curr - (debounce ? last_call : last_exec) - delay;
        clearTimeout(timer);
        if (debounce) {
            if (immediate) {
                timer = setTimeout(exec, delay);
            } else if (diff >= 0) {
                exec();
            }
        } else {
            if (diff >= 0) {
                exec();
            } else if (immediate) {
                timer = setTimeout(exec, -diff);
            }
        }
        last_call = curr;
    }
};

/*
 * 空闲控制 返回函数连续调用时，空闲时间必须大于或等于 delay，fn 才会执行
 * @param fn {function}  要调用的函数
 * @param delay   {number}    空闲时间
 * @param immediate  {bool} 给 immediate参数传递false 绑定的函数先执行，而不是delay后后执行。
 * @return {function}实际调用函数
 */

var debounce = function (fn, delay, immediate) {
    return throttle(fn, delay, immediate, true);
};

function getQuery(key, search) {
    var reg = new RegExp('(?:^|\\?|&)' + key  + '=([^&]*)');
    search = search || location.search;
    if (reg.test(search)) {
        return RegExp.$1;
    }
}

/**
 * 统一成 {id: '', name: ''}
 * @param positions
 * @param distances
 * @param category
 */
export function transformFilterData(positions, distances, categoryData) {
    var area = [{
        id: 'distance_filter',
        name: '附近',
        sub: distanceToPosition(distances)
    }, {
        id: 'position_filter',
        name: '区域',
        sub: positions.map(item => {
            item.id = item.cityid;
            return item;
        })
    }];

    function distanceToPosition(distance) {
        var ret = [];
        for (var k in distance) {
            if (distance.hasOwnProperty(k)) {
                ret.push({
                    id: 'distance_' + k,
                    parent_id: 'distance_filter',
                    distance_key: k,
                    name: distance[k]
                })
            }
        }
        return ret;
    }
    function normalizeCategory(list) {
        list.forEach(handle);
        function handle(item) {
            item.id = item.cat_id;
            item.name = item.cat_name;
            delete item.cat_id;
            delete item.cat_name;
            if (item.child_cat) {
                item.sub = item.child_cat;
                delete item.child_cat;
                item.sub.forEach(handle)
            }
        }
        return list;
    }
    return {
        area: area,
        category: normalizeCategory(categoryData)
    }

}


function htmlToText(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}


export default {
    goBack,
    login_page,
    test_result_detail,
    apiFeedback,
    getParameterByName,
    throttle,
    debounce,
    getQuery,
    transformFilterData,
    htmlToText
}
