import utils from '@/js/utils';
import api from '@/js/api';
import { Toast } from 'mint-ui';

//  base.js is used for importing common js file over every page
function initWechatShare(params) {
    params.nid = params.nid || undefined;
    params.title = params.title || '尖椒网';
    params.desc = params.desc || '尖椒帮您找到更优质的教育机构';
    params.thumbnail = params.thumbnail ||
        'http://www.51jianjiao.com/topic/weibochoujiang/img/logo.png';
    params.url = params.url || location.protocol + '//' + location.host;
    // alert(JSON.stringify(params))
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
                        id: params.nid,
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            // alert('分享到朋友圈成功');
                            log({
                                share_url: params.url,
                                share_to: 'timeline',
                                timestamp: +new Date(),
                                from_url: location.href,
                                id: params.nid
                            });
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
                        id: params.nid,
                        trigger: function (res) {
                            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，
                            // 因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                            log({
                                share_url: params.url,
                                timestamp: +new Date(),
                                share_to: 'appMessage',
                                from_url: location.href,
                                id: params.nid
                            });
                        },
                        success: function (res) {
                            if (params.url.indexOf('/activity/newsdetail/') > 0) {
                                // alert(JSON.stringify(params))
                                let shareObj = {
                                    object_id: params.nid,
                                    object_type: 1
                                }
                                api.shareScore(shareObj).then(function (data) {
                                    if (data.msg) {
                                        Toast(data.msg)
                                    }
                                }, function (err) {
                                    Toast(err)
                                })
                            }
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


function toQueryString(obj) {
    var ret = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key) && obj[key] != null) {
            ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
        }
    }
    return ret.join('&');
}

function log(param) {
    var img = new Image();
    var host = location.host;
    var data = {
        app_name: 'jianjiao',
        uid: $tplData['user_info'] ? $tplData['user_info']['user_id'] : 0,
        terminal: 'mobile',
        opType: 'wechat_share_success'
    };
    Object.assign(data, param);
    img.src = host + '?' + toQueryString(data);
}

function _init() {
    if ($tplData.activity) {
              initWechatShare({
                   nid: $tplData.news_id,
                  title: $tplData.title ,
                  desc: '看尖椒辛辣点评资讯，点赞、收藏、分享赚积分兑豪礼',
                  url: location.protocol + '//' + location.host + '/activity/newsdetail/' + $tplData.news_id,
              });
       } else if ($tplData.topic315=='index') {
        initWechatShare({
            title: '你有一份5000元的大奖等待领取',
            desc: '我正在赚积分，600积分可获得500元京东卡哦！先送你1积分',
            url: location.protocol + '//' + location.host + location.pathname + ($tplData['user_info']['user_id'] ? '?from_user=' + $tplData['user_info']['user_id'] : ''),
            thumbnail: ''
        })
       } else if ($tplData.news_title) {
        initWechatShare({
            title: $tplData.news_title + '-尖椒教育点评',
            desc: utils.htmlToText($tplData.news_text),
            url: location.protocol + '//' + location.host + location.pathname,
            thumbnail: $tplData.img
        })
    } else if ($tplData.institute_name) {
        initWechatShare({
            title: $tplData.institute_name + '-尖椒教育点评',
            desc: $tplData.intro || '尖椒帮您找到更优质的教育机构',
            url: location.protocol + '//' + location.host + location.pathname,
            thumbnail: $tplData.cover_pic
        });
    } else if ($tplData.is_quiz) {
        var descrp = $tplData.description
        var quiz_desc = descrp.replace(new RegExp('<p>', 'g'), '').replace(new RegExp('</p>', 'g'), '');
        initWechatShare({
            title: $tplData.title + '-尖椒教育点评',
            desc: quiz_desc || '尖椒帮您找到更优质的教育机构',
            url: location.protocol + '//' + location.host + location.pathname,
            thumbnail: $tplData.cover_pic
        });
    } else if ($tplData.result) {
        initWechatShare({
            title: `我在尖椒测出【${$tplData.result.title}】,超准哦！你也试试？`,
            desc: $tplData.quiz_title,
            url: location.protocol + '//' + location.host + '/quiz/shareresult/' + $tplData.result_id,
            thumbnail: $tplData.quiz_pic
        });
    } else if ($tplData.question_content) {
        initWechatShare({
            title: $tplData.question_content + '-尖椒教育点评',
            desc: `还有${$tplData.focus_count}人和我一起关注了此问题`,
            url: location.protocol + '//' + location.host + '/circle/question/detail/' + $tplData.question_id
        });
    } else if ($tplData.exposure) {
           initWechatShare({
               title: $tplData.title ,
               desc: '天价学费、虚假宣传、退费无门，守护兰芷之室，尖椒教育在行动',
               url: location.protocol + '//' + location.host + '/activity/exposuredetail/' + $tplData.id
           });
    } else {
        initWechatShare({
            title: '尖椒教育点评-帮您找到更优质的教育机构',
            desc: '尖椒是中国专业的教育机构点评与资讯服务平台，通过丰富的数据采集以及海量的用户生产内容，为用户提供教育机构的全方面点评信息以及个性化教育资讯。',
            url: location.protocol + '//' + location.host + location.pathname
        })
    }
}
_init();

