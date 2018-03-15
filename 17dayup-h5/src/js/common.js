import config from "./config"
import weui from 'weui.js'
import {Promise} from "./utils"

window.weui = weui;

function login(){
    if(window.isWechat){ return wechatLogin(); }
    location.href = config.host.passport + '/account/login?redirect_to=' + location.href;
}


function wechatLogin(){
    location.href = config.host.passport + 
        '/api/account/thirdpartylogin?type=2&returnUrl=' + location.href;
}


function logout(){

}

function goBack(url) {
    console.log("goback")
    var historyLength = history && history.length;

    try {
        if(document.referrer){
            if (historyLength == 1 && (url && url[0] == '/')) {
                    location.href = url;
            } else {
                if ((historyLength ===1)) {
                    location.href = '/';
                }
                else{
                    history.go(-1);
                }
            }

        }else{
            location.href = '/';
        }
    } catch (e) {
        location.href = '/';
    }
}

function toast(text){
    return new Promise(function(resolve, reject){
        weui.toast(text, {
            duration: 2000,
            className: 'bears'
        })
        setTimeout(function(){
            resolve()
        }, 1800)
    })
}


function confirm(title, content){
    return new Promise(function(resolve, reject){
        weui.confirm(content, resolve, reject, {
            title: title
        });
    })
}

function initWechatShare(params) {
    params.title = params.title || '伟东云学堂';
    params.desc = params.desc || '互联网、早教、外语、国学、生活等各类精品课，总有一款你值得拥有!';
    params.thumbnail = params.thumbnail ||
    'http://www.wdyedu.com/build/img/fav-2711d55b2c.ico';
    params.url = params.url || location.protocol + '//' + location.host;
    setTimeout(function () {
        if ($tplData.wxconfig) {
            var wx = window.wx;
            var config = $tplData.wxconfig;
            try {
                var conf = {
                    debug: config.debug,
                    appId: config.appId,
                    timestamp: config.timestamp,
                    nonceStr: config.nonceStr,
                    signature: config.signature,
                    jsApiList: config.jsApiList
                };
                wx.config(conf);
                wx.ready(function () {
                    wx.onMenuShareTimeline({
                        title: params.title,
                        link: params.url,
                        imgUrl: params.thumbnail,
                        success: function () {
                            // 用户确认分享后执行的回调函数
                             //alert('分享到朋友圈成功');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                            // alert('你没有分享到朋友圈');
                        }
                    });
                    wx.onMenuShareAppMessage({
                        title: params.title,
                        desc: params.desc,
                        link: params.url,
                        imgUrl: params.thumbnail,
                        trigger: function (res) {
                            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，
                            // 因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                        },
                        success: function (res) {
                            // alert('分享给朋友成功');
                        },
                        cancel: function (res) {
                            // alert('你没有分享给朋友');
                        },
                        fail: function (res) {
                            // alert(JSON.stringify(res));
                        }
                    });
                  
                });

                wx.error(function (res) {

                })
            } catch (e) {
            }
        }
    }, 300);
}


const ui = {
    picker(options, current){
        return new Promise(function(resolve, reject){
            weui.picker(options, {
                defaultValue: [current],
                className: 'custom-classname',
                onChange: function (result) {
                    //console.log(item, index);
                    // console.log(result);
                },

                onConfirm: function (result) {
                    resolve(result[0])
                },
                id: 'picker'
            })
        })
    },
    topTips(msg){
        weui.topTips(msg, {
            duration: 3000,
            className: "custom-classname",
            callback: function () {
                console.log('close');
            }
        });
    },
    loading:{
        show(str){
            this.loading = weui.loading(str || '请稍候...');
        },
        hide(){
            this.loading && this.loading.hide();
        }
    },
    toast: toast
}

export default {
    login,
    wechatLogin,
    logout,

    goBack,

    toast,
    confirm,

    ui,

    initWechatShare
}
