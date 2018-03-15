import common from '../../common'
import api from '../../api'


function toQueryString(obj) {
    var ret = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key) && obj[key] != null) {
            ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
        }
    }
    return ret.join('&');
}

function log(opType, courseId) {
    var img = new Image();
    var host = 'http://click.wdyedu.com/v.gif';
    var data = {
        app_name: '17dayup',
        pageType: 'activity',
        url: location.href,
        tl: 'pc',
        opType_spring: opType,
        course_id: courseId
    };
    img.src = host + '?' + toQueryString(data);
}

/*分享
    * 分享当前页面
    * */
if (/MicroMessenger/.test(navigator.userAgent)) {
    initWechatShare({
        title: '伟东云学堂-国学闹春晚，精品好课学不停！',
        desc: '国学大咖强烈推荐~！100000+人正在学习...',
        url: location.href
    });
}

function initWechatShare(params) {
    params.thumbnail = params.thumbnail || 'http://wdyedu-static.bj.bcebos.com/img/share_logo.png';
    params.url = params.url || location.protocol + '//' + location.host + '/topic/answer';
    var $shareCont = $('.share-cont');
    $.ajax({
        type: 'POST',
        // url: '/api/universal/wechatjsconfig',
        url: '/api/universal/wechatjsconfig',
        data: {url: encodeURIComponent(location.href)},
        success: function (data) {
            if (data.status == 200) {
                if (data.data) {
                    var wx = window.wx;
                    var config = data.data;
                    try {
                        var conf = {
                            debug: false,
                            appId: config.appId,
                            timestamp: config.timestamp,
                            nonceStr: config.nonceStr,
                            signature: config.signature,
                            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareQZone', 'onMenuShareWeibo']
                        };
                        wx.config(conf);
                        wx.ready(function () {
                            wx.onMenuShareTimeline({
                                title: params.title,
                                link: params.url,
                                imgUrl: params.thumbnail,
                                success: function () {
                                    $shareCont.hide();
                                    log('share', '', 'weixin');
                                },
                                cancel: function () {

                                }
                            });
                            wx.onMenuShareAppMessage({
                                title: params.title,
                                desc: params.desc,
                                link: params.url,
                                imgUrl: params.thumbnail,
                                trigger: function (res) {
                                    // 涓嶈灏濊瘯鍦╰rigger涓娇鐢╝jax寮傛璇锋眰淇敼鏈鍒嗕韩鐨勫唴瀹癸紝
                                    // 鍥犱负瀹㈡埛绔垎浜搷浣滄槸涓€涓悓姝ユ搷浣滐紝杩欐椂鍊欎娇鐢╝jax鐨勫洖鍖呬細杩樻病鏈夎繑鍥�
                                },
                                success: function (res) {
                                    $shareCont.hide();
                                    log('share', '', 'weixin');
                                },
                                cancel: function (res) {
                                },
                                fail: function (res) {
                                    // alert(JSON.stringify(res));
                                },
                                complete: function () {
                                }
                            });
                            wx.onMenuShareQQ({
                                title: params.title,
                                desc: params.desc,
                                link: params.url,
                                imgUrl: params.thumbnail,
                                success: function () {
                                    $shareCont.hide();
                                    log('share', '', 'qq');
                                },
                                cancel: function () {

                                }
                            });
                            wx.onMenuShareQZone({
                                title: params.title,
                                desc: params.desc,
                                link: params.url,
                                imgUrl: params.thumbnail,
                                success: function () {
                                    $shareCont.hide();
                                    log('share', '', 'qq');
                                },
                                cancel: function () {

                                }
                            });
                            wx.onMenuShareWeibo({
                                title: params.title,
                                desc: params.desc,
                                link: params.url,
                                imgUrl: params.thumbnail,
                                success: function () {
                                    $shareCont.hide();
                                    log('share', '', 'weibo');
                                },
                                cancel: function () {

                                }
                            });
                        });

                        wx.error(function (res) {

                        })
                    } catch (e) {
                    }
                }
            } else {
            }
        }
    })
}

/*// 课程点击数*/
$('.col-3 a').on('click', function (e) {
    var _this = this;
    var courseId;
    courseId = $(_this).attr('href').split('/')[2];
    // 统计
    log('click', courseId)

});

/*app跳转
*  todo:领券
* */


/*$('.js_discount').click(function (e) {
    var _this  = this;
    api.get('/api/coupon/send?coupon_id=' + $(_this).attr('value')).then(function(data){
        $(_this).parent().parent().addClass('active');
        $(_this).html('已经领取');
    })
});*/
var discount = {
    _this: ''
};

function setupWebViewJavascriptBridge(callback) {
    if (window.WebViewJavascriptBridge) {
        return callback(WebViewJavascriptBridge);
    }
    if (window.WVJBCallbacks) {
        return window.WVJBCallbacks.push(callback);
    }
    window.WVJBCallbacks = [callback];
    var WVJBIframe = document.createElement('iframe');
    WVJBIframe.style.display = 'none';
    WVJBIframe.src = 'https://__bridge_loaded__';
    document.documentElement.appendChild(WVJBIframe);
    setTimeout(function () {
        document.documentElement.removeChild(WVJBIframe)
    }, 0)
}


window.spring_js = function () {
    var _this = discount._this;

    $.ajax({
        url: '/api/coupon/send?coupon_id=' + $(_this).attr('value'),
        method: 'GET',
    }).done(function (res) {
        if (res.status == 200) {
            $(_this).parent().parent().addClass('active');
            $(_this).html('已经领取');
            discount._this = '';
        }
    }).fail(function (err) {
        reject(err)
    })
}

if (window.isApp) {
    var isAndroid = navigator.userAgent.indexOf('Android') > -1 || navigator.userAgent.indexOf('Adr') > -1;
    if (isAndroid) {
        /*跳转课程*/
        $('.col-3 a').on('click', function (e) {
            e.preventDefault();
            var _this = this;
            var courseId;
            courseId = $(_this).attr('href').split('/')[2];
            // 统计
            log('click', courseId)
            var json = {
                type: '01',
                course_id: courseId
            };

            Android.detail(JSON.stringify(json));

        });

        /*// 跳转更多*/
        $('.js_more').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('value')
            var json = {
                type: '02',
                course_id: id
            };
            Android.detail(JSON.stringify(json));
        });

        /*// 跳转首页*/
        $('.foot .logo').on('click', function (e) {
            e.preventDefault();
            var json = {
                type: '04',
            };
            Android.detail(JSON.stringify(json));
        });

        /*领券*/
        $('.js_discount').click(function () {
            discount._this = this;
            Android.detail(JSON.stringify({
                type: '05'
            }));
        });

    } else {
        setupWebViewJavascriptBridge(function (bridge) {
            $('.col-3 a').on('click', function (e) {
                e.preventDefault();
                var _this = this;
                var courseId;
                courseId = $(_this).attr('href').split('/')[2];
                // 统计
                log('click', courseId)

                bridge.callHandler('detail', {'key': courseId});

            });

            /*// 跳转更多*/
            $('.js_more').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('value');
                bridge.callHandler('courseList', {'key': id});
            });

            /* // 跳转首页*/
            $('.foot .logo').on('click', function (e) {
                e.preventDefault();
                bridge.callHandler('home');
            });

            /*领券
            * todo: ios领卷方法未定义
            * */
            $('.js_discount').click(function () {
                discount._this = this;
                bridge.callHandler('discount', function (data) {
                    if (data.userkey) {
                        spring_js()
                    }
                });
            });

            // 跳转h5
            // $('.foot .logo').on('click', function(e){
            //     e.preventDefault();
            //     bridge.callHandler('webView',{'key': 'http://www.baidu.com'});
            // })
        });


    }

} else {
    $('.col-3 a').on('click', function (e) {
        var _this = this;
        var courseId;
        courseId = $(_this).attr('href').split('/')[2];
        // 统计
        log('click', courseId)
    });
    $('.js_discount').click(function (e) {
        var _this = this;
        api.get('/api/coupon/send?coupon_id=' + $(_this).attr('value')).then(function (data) {
            $(_this).parent().parent().addClass('active');
            $(_this).html('已经领取');
        })
    });
}



