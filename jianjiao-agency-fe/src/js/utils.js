export default {

    sizeWithUnit(size, d = 1024, fixedLength = 0, units = ['B', 'K', 'M', 'G']) {
        let i = 0;
        let length = units.length;
        while (size >= d && i < length) {
            i++;
            size = size / 1024;
        }
        return size.toFixed(fixedLength) + units[i];
    },

    countdown(seconds, option) {
        var sTime = +new Date();
        var timer = setInterval(function() {
            var s = seconds - Math.round((+new Date() - sTime) / 1e3);
            if (s < 0) {
                s = 0;
                option.onProgress && option.onProgress(s);
                option.onEnd && option.onEnd();
                clearInterval(timer);
            } else {
                option.onProgress && option.onProgress(s);
            }
        }, option.interval || 1000);

        return function destroy() {
            clearInterval(timer);
        }
    },

    /*
     * 频率控制 返回函数连续调用时，fn 执行频率限定为每多少时间执行一次
     * @param fn {function}  需要调用的函数
     * @param delay  {number}    延迟时间，单位毫秒
     * @param immediate  {bool} 给 immediate参数传递false 绑定的函数先执行，而不是delay后后执行。
     * @return {function}实际调用函数
     */
    throttle: function(fn, delay, immediate, debounce) {
        var curr = +new Date(), //当前事件
            last_call = 0,
            last_exec = 0,
            timer = null,
            diff, //时间差
            context, //上下文
            args,
            exec = function() {
                last_exec = curr;
                fn.apply(context, args);
            };
        return function() {
            curr = +new Date();
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
    },

    param: function(obj) {
        var ret = [];
        for (var key in obj) {
            if (obj.hasOwnProperty(key) && obj[key] != null) {
                ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
            }
        }
        return ret.join('&');
    },

    log: function(data) {
        var opts = {
            app_name: 'biz',
            termial: 'pc',
            timestamp: +new Date(),
            uid: window.USERINFO ? window.USERINFO.user_id : 0
        };
        data = Object.assign(opts, data);
        var host = 'http://click.weichuangedu.com/v.gif';
        var image = new Image();
        image.src = host + '?' + this.param(data);
    },

    secToTime(s) {
        var t;
        if (s > -1) {
            var hour = Math.floor(s / 3600);
            var min = Math.floor(s / 60) % 60;
            var sec = s % 60;
            if (hour < 10) {
                t = '0' + hour + ":";
            } else {
                t = hour + ":";
            }

            if (min < 10) {
                t += "0";
            }
            t += min + ":";
            if (sec < 10) {
                t += "0";
            }
            t += sec;
        }
        return t;
    }
}