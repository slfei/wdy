<?php
   $title = '国学好课荟萃 不容错过_伟东云学堂-带梦想远航';
   $description = '品国学精髓，悟和谐至理，享智慧人生！伟东云学堂汇聚国学精品好课，打造“国学好课荟萃”专题，为您提供童蒙养正、经典诵读、文化通识、传统技艺、人物赏析等丰富精彩的内容。';
?>

@extends('pc.common')
@section('main')

<div class="section-head-bg">
    <a href="/"></a>
</div>
<div class="section-notice-bg">
    <div class="main-container section-notice">
        <div class="clearfix data-start" id="data-start">
            <div class="lantern-left-bg"></div>
            <div class="lantern-right-bg"></div>
            <div class="data-title">
               <i class="title-icon"></i>
                <span class="title-text">国学启蒙</span>
                <span class="title-desc">利用幼儿记忆力发展的关键时间，学习中国传统经典文化</span>
                <a href="/course/discovery/7" class="more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="list">
                @forEach($tplData['gxqm'] as $key=>$item)
                <div class="col-3">
                    @component('pc.components.course.item', ['data' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="clearfix data-book" id="data-book">
            <div class="lantern-left-bg"></div>
            <div class="lantern-right-bg"></div>
            <div class="data-title">
                <i class="title-icon"></i>
                <span class="title-text">国学讲堂</span>
                <span class="title-desc">品国学精髓，悟和谐至理，享智慧人生</span>
                <a href="/course/discovery/1" class="more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="free-bg"></div>
            <div class="clearfix list">
                @forEach($tplData['gxjt'] as $key=>$item)
                <div class="col-3">
                    @component('pc.components.course.item', ['data' => $item])@endcomponent
                </div>
                @endforEach
            </div>
            <div class="pay-bg"></div>
            <div class="clearfix list">
                @forEach($tplData['hkzq'] as $key=>$item)
                <div class="col-3 js-statistics">
                    @component('pc.components.course.item', ['data' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="notice" id="notice">
            <div class="title">精彩活动</div>
            <div class="content">
                <div class="single one">
                    <div  class="one-title">家国迎新·2018第二届国学春晚</div>
                    <div class="one-desc">传承中华国粹 传播传统文化</div>
                    <div class="one-bottom">
                        中国教育电视台<br>
                        2018年2月16日(大年初一)晚
                    </div>
                </div>
                <div class="single two">
                    <div class="two-title">国学闹春晚</div>
                    <div class="two-desc1">亿万红包发不停</div>
                    <div class="two-desc2">每天100%中奖 分享得现金红包</div>
                    <div class="two-bottom">敬请期待！</div>
                </div>
                <div class="single there">
                    <div class="there-title">国学知识大挑战</div>
                    <img src="/build/img/activity/new-year/activity-code.png" alt="">
                    <div class="there-bottom">微信扫码立即参加</div>
                </div>
            </div>

        </div>
        <ul class="returnTop-new">
            <li><a href="#data-start">国学启蒙</a></li>
            <li><a href="#data-book">国学讲堂</a></li>
            <li><a href="#notice">精彩活动</a></li>
            <li class="share">
                <a href="javascript:void(0)">我要分享</a>
                <div class="code-common share-code">
                    <img src="/build/img/activity/new-year/share-code.png">
                    <span class="return_sweep_text">微信扫一扫分享</span>
                </div>
            </li>
            <li class="like">
                <a href="javascript:void(0)">关注我们</a>
                <div class="code-common like-code">
                    <img src="/build/img/returntop/code.png">
                    <span class="return_sweep_text">微信扫一扫关注</span>
                </div>
            </li>
            <li class="js-to-top to-top"></li>
        </ul>
    </div>
</div>

<script>

</script>
@stop

@section('style')
<link rel="stylesheet" type="text/css" href="/build/css/pc.css">
<link rel="stylesheet" type="text/css" href="/build/css/page/activity/new-year.css">

@endsection
@section('script')
<script>
    var winHeight = window.innerHeight;

    $(window).scroll(function(e){
        var el = document.scrollingElement || document.body;
        if (el.scrollTop > winHeight) {
            $('.returnTop-new').css({
                'background': 'url(/build/img/activity/new-year/returnTop-new-top.png) no-repeat'
            });
        } else {
            $('.returnTop-new').css({
                'background': 'url(/build/img/activity/new-year/returnTop-new.png) no-repeat'
            });
        }
    });

    $('.js-to-top').on('click',function(){
        $('html, body').animate({
            scrollTop: 0
        });
    });

    /* 统计数量 */
    $('.thumbnail a').on('click',function(e){
        var _this = this ;
        var courseId ;
        courseId = $(_this).attr('href').split('/')[2];
        // 统计
        log('click', courseId)
    });

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
            opType: opType,
            course_id: courseId
        };
        img.src = host + '?' + toQueryString(data);
    }
</script>
@stop
