<?php
   $title = '国学好课荟萃 不容错过_伟东云学堂-带梦想远航';
   $description = '品国学精髓，悟和谐至理，享智慧人生！伟东云学堂汇聚国学精品好课，打造“国学好课荟萃”专题，为您提供童蒙养正、经典诵读、文化通识、传统技艺、人物赏析等丰富精彩的内容。';
   $viewport = 'width=320,user-scalable=no';
?>

@extends('pc.common')

@section('content')
<div class="clearfix new-year">

    @if($is_app!=1)
    <header class="g-header">
        <div class="header-nav">
            <a class="logo" href="/"></a>
        </div>
    </header>
    @endif

    <div class="head">
        <div class="head-bg"></div>
    </div>
    <div class="data-start">
        <div class="data-title">
            <i class="title-icon"></i>
            <span class="title-text">国学启蒙</span>
            <a href="/course/discovery/?type=1-7" class="more">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="list clearfix">
            @forEach($tplData['gxqm'] as $key=>$item)
            <div class="col-3">
                <a href="/course/{{ $item['course_id'] }}" class="cover">
                    <img class="lazy"   src="{{$item['course_img']}}" alt="">
                    <div class="single-row title">
                        {{ $item['course_name'] }}
                    </div>
                    <div class="bottom">
                        <div class="single-row price">
                            @if($item['cur_price'] == 0)
                            <span class="price-free">
                            免费
                        </span>
                            @else
                            <span>
                            ¥ {{ $item['cur_price'] }}
                        </span>
                            @endif
                        </div>
                        <span class="single-row institute">{{ $item['from_name'] }}</span>
                    </div>
                </a>
            </div>
            @endforEach
        </div>
    </div>
    <div class="data-book">
        <div class="data-title">
            <i class="title-icon"></i>
            <span class="title-text">国学启蒙</span>
            <a href="/course/discovery/?type=1" class="more">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="free-bg"></div>
        <div class="list clearfix">
            @forEach($tplData['gxjt'] as $key=>$item)
            <div class="col-3">
                <a href="/course/{{ $item['course_id'] }}" class="cover">
                    <img class="lazy"   src="{{$item['course_img']}}" alt="">
                    <div class="single-row title">
                        {{ $item['course_name'] }}
                    </div>
                    <div class="bottom">
                        <div class="single-row price">
                            @if($item['cur_price'] == 0)
                            <span class="price-free">
                            免费
                        </span>
                            @else
                            <span>
                            ¥ {{ $item['cur_price'] }}
                        </span>
                            @endif
                        </div>
                        <span class="single-row institute">{{ $item['from_name'] }}</span>
                    </div>
                </a>
            </div>
            @endforEach
        </div>
        <div class="pay-bg"></div>
        <div class="list clearfix">
            @forEach($tplData['hkzq'] as $key=>$item)
            <div class="col-3">
                <a href="/course/{{ $item['course_id'] }}" class="cover">
                    <img class="lazy"   src="{{$item['course_img']}}" alt="">
                    <div class="single-row title">
                        {{ $item['course_name'] }}
                    </div>
                    <div class="bottom">
                        <div class="single-row price">
                            @if($item['cur_price'] == 0)
                            <span class="price-free">
                            免费
                        </span>
                            @else
                            <span>
                            ¥ {{ $item['cur_price'] }}
                        </span>
                            @endif
                        </div>
                        <span class="single-row institute">{{ $item['from_name'] }}</span>
                    </div>
                </a>
            </div>
            @endforEach
        </div>
    </div>
    <div class="notice" >
        <!--<div class="title">精彩活动</div>-->
        <div class="title">
            <span class="one">精</span>
            <span class="two">彩</span>
            <span class="there">活</span>
            <span class="four">动</span>
        </div>

        <div class="clearfix single one">
            <div class="one-bottom">
                <span class="china">中国教育电视台</span>
                <span>2018年2月16日(大年初一)晚</span>
            </div>
        </div>
        <div class="clearfix single two">
            <div class="two-bottom">敬请期待！</div>
        </div>
        <div class="clearfix single there">
            <img src="/build/img/activity/new-year/activity-code.png" alt="">
            <div class="there-bottom">微信扫码立即参加</div>
        </div>
    </div>
    <div class="foot">
        <a class="logo" href="/"></a>
        <div class="text">
            ©2018 All Rights Reserved<br/>
            伟东云教育 · 版权所有<br>
            京ICP证161318号<br>
            <a class="batb" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=11010802025060" target="_blank">京公网安备11010802025060号</a>
        </div>

    </div>
</div>
<script>
    window.isApp = {!!json_encode($is_app)!!}
</script>
@stop

@section('style')
<link rel="stylesheet" href="/build/css/page/activity/new-year-app.css">
@endsection
@section('script')
<script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script >
    /* 统计点击数量 */
    /*$('.col-3 a').on('click',function(e){
        var _this = this ;
        var courseId ;
        courseId = $(_this).attr('href').split('/')[2];
        // 统计
        log('click', courseId)

    });*/


    function toQueryString(obj) {
        var ret = [];
        for (var key in obj) {
            if (obj.hasOwnProperty(key) && obj[key] != null) {
                ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
            }
        }
        return ret.join('&');
    }
    function log (opType, courseId) {
        var img = new Image();
        var host = 'http://click.wdyedu.com/v.gif';
        var data = {
            app_name: '17dayup',
            pageType:'activity',
            url:location.href,
            terminal: 'pc',
            opType_china: opType,
            course_id: courseId
        };
        img.src = host + '?' + toQueryString(data);
    }

    /*分享
    * 分享当前页面
    * */
    if(/MicroMessenger/.test(navigator.userAgent)){
        initWechatShare({
            title: '我正在学习伟东云学堂的国学精品课,超赞！快来看',
            desc: '国学大咖强烈推荐~！100000+人正在学习...',
            url: location.href
        });
    }
    function initWechatShare(params) {
        params.title = params.title ;
        params.desc = params.desc ;
        params.thumbnail = params.thumbnail ||'http://wdyedu-static.bj.bcebos.com/img/share_logo.png';
        params.url = params.url || location.protocol + '//' + location.host +'/topic/answer';
        var $shareCont=$('.share-cont');
        $.ajax({
            type: 'POST',
            // url: '/api/universal/wechatjsconfig',
            url: '/api/universal/wechatjsconfig',
            data:{url : encodeURIComponent(location.href)},
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
                                jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','onMenuShareWeibo']
                            };
                            wx.config(conf);
                            wx.ready(function () {
                                wx.onMenuShareTimeline({
                                    title: params.title,
                                    link: params.url,
                                    imgUrl: params.thumbnail,
                                    success: function () {
                                        $shareCont.hide();
                                        log('share','','weixin');
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
                                        log('share','','weixin');
                                    },
                                    cancel: function (res) {
                                    },
                                    fail: function (res) {
                                        // alert(JSON.stringify(res));
                                    },
                                    complete: function(){
                                    }
                                });
                                wx.onMenuShareQQ({
                                    title: params.title,
                                    desc: params.desc,
                                    link: params.url,
                                    imgUrl: params.thumbnail,
                                    success: function () {
                                        $shareCont.hide();
                                        log('share','','qq');
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
                                        log('share','','qq');
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
                                        log('share','','weibo');
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
                } else {}
            }
        })
    };

    /*app跳转*/
    function setupWebViewJavascriptBridge(callback) {
        if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
        if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
        window.WVJBCallbacks = [callback];
        var WVJBIframe = document.createElement('iframe');
        WVJBIframe.style.display = 'none';
        WVJBIframe.src = 'https://__bridge_loaded__';
        document.documentElement.appendChild(WVJBIframe);
        setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
    };

    if(isApp){
        var isAndroid = navigator.userAgent.indexOf('Android')> -1||navigator.userAgent.indexOf('Adr')> -1;
        if(isAndroid){
            $('.col-3 a').on('click',function(e){
                e.preventDefault();
                var _this = this ;
                var courseId ;
                courseId = $(_this).attr('href').split('/')[2];
                // 统计
                log('click', courseId)
                var json = {
                    type: '01',
                    course_id: courseId
                };

                Android.detail(JSON.stringify(json));

            });
            function discovery(id){
                var json = {
                    type: '02',
                    course_id: id
                };
                Android.detail(JSON.stringify(json));
            }
            // 跳转更多
            $('.data-book .data-title .more').on('click',function(e){
                e.preventDefault();
                discovery(7)
            });
            $('.data-start .data-title .more').on('click',function(e){
                e.preventDefault();
                discovery(1)
            });
            // 跳转首页
            $('.foot .logo').on('click', function(e){
                e.preventDefault();
                var json = {
                    type: '04',
                };
                Android.detail(JSON.stringify(json));
            })
        }else{
            setupWebViewJavascriptBridge(function(bridge) {
                $('.col-3 a').on('click',function(e){
                    e.preventDefault();
                    var _this = this ;
                    var courseId ;
                    courseId = $(_this).attr('href').split('/')[2];
                    // 统计
                    log('click', courseId)

                    bridge.callHandler('detail', {'key': courseId});

                });

                // 跳转更多
                $('.data-start .data-title .more').on('click',function(e){
                    e.preventDefault();
                    bridge.callHandler('courseList', {'key': 7});
                });

                $('.data-book .data-title .more').on('click',function(e){
                    e.preventDefault();
                    bridge.callHandler('courseList', {'key': 1});
                });
                // 跳转首页
                $('.foot .logo').on('click', function(e){
                    e.preventDefault();
                    bridge.callHandler('home');
                });

                // 跳转h5
                // $('.foot .logo').on('click', function(e){
                //     e.preventDefault();
                //     bridge.callHandler('webView',{'key': 'http://www.baidu.com'});
                // })
            });

        }
    }else{
        $('.col-3 a').on('click',function(e){
            var _this = this ;
            var courseId ;
            courseId = $(_this).attr('href').split('/')[2];
            // 统计
            log('click', courseId)

        });
    }
</script>
@stop
