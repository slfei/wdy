<?php
   $title = "伟东云学堂下载_APP下载_伟东云学堂";
?>
@extends('pc.common')
@section('content')
    <header class="navbar fixed-header">
      <div class="navbar-text row">
        <div class="nav-icon-left js-backward" id='js-backward'>
          <span class="ion  go-back"></span>
        </div>
                    
        <div class="nav-title col">
            <i class="icon icon-logo"></i>伟东云学堂APP下载
        </div>
        <div class="nav-icon-right"></div>
      </div>

    </header>

      <article class='h5-wrap'>
        <div class="h5-content cont1">
            <h2>伟东云学堂&nbsp;&nbsp;&nbsp;&nbsp;带梦想起航</h2>
            <ul>
              <li><a href="https://itunes.apple.com/cn/app/%E4%BC%9F%E4%B8%9C%E4%BA%91%E5%AD%A6%E5%A0%82/id1352182829?l=en&mt=8"><span><i class='ios'></i>App Store</span></a></li>
              <li><a href="/app/download?type=android"><span><i class='android'></i>Android</span></a></li>
            </ul>
            <div class="mobile-bg">
              <p>扫一扫 下载APP</p>
              <img src="/build/img/activity/code.png">
            </div>
            <p class="hide">iOS端即将上线，敬请期待！</p>
            
        </div>
        <div class="h5-content cont2 ">
            <h2>教育资源</h2>
            <p>全球化教育机构、各领域专家汇聚在此，只为您提供 更丰富的课程内容</p>
        </div>
        <div class="h5-content cont3 ">
            <div class='text'>
                <h2>终身教育</h2>
                <p>
                  涵盖国学、早教、K12、 语言、互联网、生活兴趣等 人生各种阶段及生活领域的 精品课程，让您打造专属 的教育人生
                </p>
            </div>
        </div>
        <div class="h5-content cont4 ">
          <h2>特色课程</h2>
          <p>
            伟东云学堂重资打造原创国学及K12相关课程，专业 师资、精品团队只为您提供优品质课程
          </p>
            
        </div>
        <div class="h5-content cont5 ">
            <div class='text'>
                <h2>学习体系</h2>
                <p>
                  集资讯、问答、课程多种 学习形式，为您打造看、学、 问、答一体化学习体系平台
                </p>
            </div>
        </div>
        <div class="h5-content cont6 ">
            <h2>下载看课</h2>
            <p>伟东云学堂课程支持下载后离线观看，离线课程让您 可以随时随地任意学</p>
        </div>
        <div class="h5-content cont7 ">
            <h2> 一切皆由您一手掌握</h2>
            <p><!-- 扫码下载App， -->让梦想不再遥远</p>
            <div class='code'>
              <img src="/build/img/activity/code1.jpg">
              <p>扫一扫 关注微信服务号</p>
            </div>
        </div>
      </article>
@endsection
@section('style')
      <link rel="stylesheet" type="text/css" href="/build/css/page/activity/apph5.css">
      <script type="text/javascript">
         document.documentElement.style.fontSize = Math.round(document.documentElement.clientWidth / 375 * 100) + 'px';
      </script>

@endsection
@section('script')
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
var configDetail = '';
function initWechatShare() {
    var params = {};
    params.title = '伟东云学堂APP下载_伟东云学堂';
    params.desc = '伟东云学堂推出iPhone和Android版专业在线教育平台APP,欢迎下载体验。';
    params.thumbnail = 'http://wdyedu-static.bj.bcebos.com/img/share_logo.png';
    params.url = location.href;
    
    getConfigAjax(params);
};
function getConfigAjax(params){
    $.ajax({
            type: 'POST',
            url: '/api/universal/wechatjsconfig', 
            data:{url : encodeURIComponent(location.href)},   
            success: function (data) {
               
                if (data.status == 200) {
                    if (data.data) {
                        
                        configDetail = data.data;
                        wxInit(configDetail,params);    
                        
                    }
                } else {}
            }
    })
};
function wxInit(config,params){
    try {
        var conf = {
            debug: false,
            appId: config.appId,
            timestamp: config.timestamp,
            nonceStr: config.nonceStr,
            signature: config.signature,
            jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','onMenuShareWeibo']
        };
        wx.config(conf);
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: params.title,
                link: params.url,
                imgUrl: params.thumbnail,
                success: function () {
                    // 用户确认分享后执行的回调函数
                    shareTime();   
                    log('weixin');                                  
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                   
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
                    shareTime(); 
                    log('weixin');       
                },
                cancel: function (res) {
                    // alert('你没有分享给朋友');
                },
                fail: function (res) {
                    // alert(JSON.stringify(res));
                }
            });
            wx.onMenuShareQQ({
                title: params.title, // 分享标题
                desc: params.desc, // 分享描述
                link: params.url, // 分享链接
                imgUrl: params.thumbnail, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    shareTime();
                    log('qq');        
                },
                cancel: function () {
                // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareQZone({
                title: params.title, // 分享标题
                desc: params.desc, // 分享描述
                link: params.url, // 分享链接
                imgUrl: params.thumbnail, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    shareTime(); 
                    log('qq'); 
                },
                cancel: function () {
                // 用户取消分享后执行的回调函数
                }
            }); 
            wx.onMenuShareWeibo({
                title: params.title, // 分享标题
                desc: params.desc, // 分享描述
                link: params.url, // 分享链接
                imgUrl: params.thumbnail, // 分享图标
                success: function () {
                // 用户确认分享后执行的回调函数
                    shareTime(); 
                    log('weibo'); 
                },
                cancel: function () {
                // 用户取消分享后执行的回调函数
                }
            });                         
        });

        wx.error(function (res) {

        })
    } catch (e) {
    }
};

initWechatShare()
</script>
<script type="text/javascript">
  var backward=document.getElementById('js-backward');

  function goBack(url) {
    console.log("goback")
    var historyLength = history && history.length;
    try {
        if (historyLength == 1 && (url && url[0] == '/')) {
                location.href = url;
        } else {
            if ((historyLength ===1 || historyLength ===2)) {
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
  backward.onclick=function(){
    goBack()
  }
</script>
@stop
