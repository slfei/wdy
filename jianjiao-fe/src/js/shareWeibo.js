import utils from '@/js/utils';
import api from '@/js/api';
import { Toast } from 'mint-ui';
var initData;
var href = window.location.href;
if($tplData.topic315=='index'){
    var params = {
        "icon": 'https://www.51jianjiao.com/app/images/icon.png',
        "title": '一起看资讯，赚积分赢大礼',
        "desc": '我正在赚积分，600积分可获得500元京东卡哦！先送你1积分'
    };

}else{
    var params = {
        "icon": 'https://www.51jianjiao.com/app/images/icon.png',
        "title": $tplData.title,
        "desc": utils.htmlToText($tplData.text)
    };
}

if (/Weibo/.test(navigator.userAgent)) {

    api.weiboInfo({url:href}).then(function(data){
        initData = data
        initData.scope = [
            'getNetworkType',
            'networkTypeChanged',
            'getBrowserInfo',
            'checkAvailability',
            'setBrowserTitle',
            'openMenu',
            'setMenuItems',
            'menuItemSelected',
            'setSharingContent',
            'openImage',
            'scanQRCode',
            'pickImage',
            'getLocation',
            'pickContact',
            'apiFromTheFuture'
        ];
        window.WeiboJS.init(initData, function(ret){
            if (ret.code==200) {
                // 设置微博分享标题
                WeiboJS.invoke("setBrowserTitle", {
                        title: params.title + Math.round(Math.random() * 100)
                    },
                    function() {});

                //设置分享按钮
                // WeiboJS.invoke("setMenuItems", {
                //     menus: ["shareToWeibo", "shareToWeixin", "shareToPYQ", , "copyURL"],
                //     content:params.desc,
                //     title: params.title,
                //     icon: "http://ww1.sinaimg.cn/large/a9ebe653jw1ek6afarfwcj20go1064ad.jpg"
                // },
                // function(e) {
                //     alert("setMenuItems 返回数据：" + JSON.stringify(e))
                // });

                // 设置第三方分享内容
                WeiboJS.invoke("setSharingContent",
                    params, function(params,success,code){
                    });

                // 分享加分
                if(/newsdetail/.test(href)){
                    WeiboJS.on('menuItemSelected', function(e){
                        // var node=document.createElement("LI");
                        // var textnode=document.createTextNode(JSON.stringify(e));
                        // node.appendChild(textnode);
                        // document.getElementById("new_label").appendChild(node);
                        var shareObj = {
                            object_id: $tplData.news_id,
                            object_type: 1
                        };
                        if (e.selected_code!=1003) {
                            api.shareScore(shareObj).then(function (data) {
                                if (data.msg) {
                                    Toast(data.msg)
                                }
                            }, function (err) {
                                Toast(err)
                            })
                        }
                    });
                }
            }
        });
    })
}


