<?php
   $title = '国学闹春晚 精品好课学不停_伟东云学堂-带梦想远航';
   $keywords = '国学,国学春晚,国学课程,历史名人,国学启蒙,国学教育';
   $description = '国学闹春晚，好课学不停！伟东云学堂汇聚精品课程，狂送大额神券！满51减50，满109减100，满219减200…不容错过！';
?>

@extends('pc.common')
@section('main')
<div class="section-head-bg">
    <img src="/build/img/activity/spring-festival/code.png">
</div>
<div class="section-notice-bg">
    <div class="main-container">
        <ul class="discount">
            <li><a href="javascript:void(0)" class="discount-20  js_discount @if($tplData['coupon'][0]['has_send']!=0) active @endif" value="{{$tplData['coupon'][0]['coupon_id']}}">@if($tplData['coupon'][0]['has_send']!=0) 已经领券 @else 立即领券 @endif</a></li>
            <li><a href="javascript:void(0)" class="discount-50 js_discount @if($tplData['coupon'][1]['has_send']!=0) active @endif" value="{{$tplData['coupon'][1]['coupon_id']}}">@if($tplData['coupon'][1]['has_send']!=0) 已经领券 @else 立即领券 @endif</a></li>
            <li><a href="javascript:void(0)" class="discount-100 js_discount @if($tplData['coupon'][2]['has_send']!=0) active @endif" value="{{$tplData['coupon'][2]['coupon_id']}}">@if($tplData['coupon'][2]['has_send']!=0) 已经领券 @else 立即领券 @endif</a></li>
            <li><a href="javascript:void(0)" class="discount-200 js_discount @if($tplData['coupon'][3]['has_send']!=0) active @endif" value="{{$tplData['coupon'][3]['coupon_id']}}">@if($tplData['coupon'][3]['has_send']!=0) 已经领券 @else 立即领券 @endif</a></li>
        </ul>
    </div>

    <div class="main-container hot-course">
        <div class="title">
            <h3>人气好课</h3>
            <a href="/course/discovery" class="pull-right more">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="clearfix list hot-list">
            @forEach($tplData['rqhk'] as $key=>$item)
            <div class="col-3">
                @component('pc.components.course.item', ['data' => $item, 'institute_visible' => false])@endcomponent
            </div>
            @endforEach
        </div>
    </div>
    <div class="main-container">
        <div class="course-list course-20">
            <div class="title">
                <h3></h3>
                <a href="/course/discovery/248" class="pull-right more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="border-top"></div>
            <div class="border-left">
                <div class="clearfix list">
                    @forEach($tplData['coupon_20'] as $key=>$item)
                    <div class="col-3">
                        @component('pc.components.course.item', ['data' => $item, 'institute_visible' => false])@endcomponent
                    </div>
                    @endforEach
                </div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <div class="course-list course-50">
            <div class="title">
                <h3></h3>
                <a href="/course/discovery/248" class="pull-right more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="border-top"></div>
            <div class="border-left">
                <div class="clearfix list">
                    @forEach($tplData['coupon_50'] as $key=>$item)
                    <div class="col-3">
                        @component('pc.components.course.item', ['data' => $item, 'institute_visible' => false])@endcomponent
                    </div>
                    @endforEach
                </div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <div class="course-list course-100">
            <div class="title">
                <h3></h3>
                <a href="/course/discovery/248" class="pull-right more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="border-top"></div>
            <div class="border-left">
                <div class="clearfix list">
                    @forEach($tplData['coupon_100'] as $key=>$item)
                    <div class="col-3">
                        @component('pc.components.course.item', ['data' => $item, 'institute_visible' => false])@endcomponent
                    </div>
                    @endforEach
                </div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <div class="course-list course-200">
            <div class="title">
                <h3></h3>
                <a href="/course/discovery/248" class="pull-right more">更多好课<i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="border-top"></div>
            <div class="border-left">
                <div class="clearfix list">
                    @forEach($tplData['coupon_200'] as $key=>$item)
                    <div class="col-3">
                        @component('pc.components.course.item', ['data' => $item, 'institute_visible' => false])@endcomponent
                    </div>
                    @endforEach
                </div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <div class="rules">
            <h3 class="title">活动规则</h3>
            <div class="text">
                1、活动时间为：2018.02.14-2018.04.15； <br>

                2、活动期间用户可以领取优惠券，每个账号每种优惠券只能领一次； <br>

                3、活动期间用户购买网站参与优惠券抵用活动的课程，则可以使用优惠券抵课程售价，每个课程只能使用一张优惠券； <br>

                4、伟东云学堂对本活动拥有最终解释权。 <br>
            </div>
        </div>
        <ul class="returnTop-new">
            <li><a href="javascript:void(0)" value="hot" class="js_slide slide-hot">人气好课</a></li>
            <li><a href="javascript:void(0)" value="20" class="js_slide">20无门槛</a></li>
            <li><a href="javascript:void(0)" value="50" class="js_slide">满51减50</a></li>
            <li><a href="javascript:void(0)" value="100" class="js_slide">满109减100</a></li>
            <li><a href="javascript:void(0)" value="200" class="js_slide">满219减200</a></li>
            <li class="share">
                <a href="javascript:void(0)">我要分享</a>
                <div class="code-common share-code">
                    <img src="/build/img/activity/spring-festival/share-code.png">
                    <span class="return_sweep_text">微信扫一扫分享</span>
                </div>
            </li>
            <li class="js_toTop">
                <a href="javascript:void(0)" value="top" class="js_slide">回到顶部 <i class="ion-arrow-up-b"></i></a>
            </li>
        </ul>
    </div>
</div>
<div class="cancel-modal bg-modal hide">
    <div class="canscroll">
        <div class="modal-content">
            <div class="m-header clearfix">
                <img src="/build/img/activity/spring-festival/sucess-icon.png" alt="">
                <!--<i class="ion-ios-close close-modal pull-right "></i>-->
                <b class="close-modal pull-right">x</b>
            </div>
            <div class="m-title">
                <div class="title">恭喜您，领取成功</div>
                <p class="desc">感谢您的参与，祝您购课愉快</p>
            </div>
        </div>
    </div>
</div>
<script>


</script>
@stop

@section('style')
<link rel="stylesheet" type="text/css" href="/build/css/pc.css">
<link rel="stylesheet" type="text/css" href="/build/css/page/activity/spring-festival.css">

@endsection
@section('script')
<script>


    /*// 楼层 js实现
        功能
        1.页面滑倒楼层内 右侧，楼层激活
        2.点击楼层跳转到楼层顶部
    */
    var floor = {
        'hot': {
            offsetTop: $('.hot-course')[0].offsetTop
        },
        '20': {
            offsetTop: $('.course-20')[0].offsetTop
        },
        '50': {
            offsetTop: $('.course-50')[0].offsetTop
        },
        '100': {
            offsetTop: $('.course-100')[0].offsetTop
        },
        '200': {
            offsetTop: $('.course-200')[0].offsetTop
        },
        'top': {
            offsetTop: 0
        },

    };
    var winHeight = window.innerHeight;
    $(window).scroll(function (e) {
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        var height = document.documentElement.clientHeight || document.body.clientHeight;
        scrollTop > winHeight ? $('.js_toTop').show() : $('.js_toTop').hide();

        $('.js_slide').removeClass('active');
        if (floor['hot'].offsetTop <= scrollTop && floor['20'].offsetTop > scrollTop) {
            $('[value="hot"]').addClass('active');
        } else if (floor['20'].offsetTop <= scrollTop && floor['50'].offsetTop > scrollTop) {
            $('[value="20"]').addClass('active');
        } else if (floor['50'].offsetTop <= scrollTop && floor['100'].offsetTop > scrollTop) {
            $('[value="50"]').addClass('active');
        } else if (floor['100'].offsetTop <= scrollTop && floor['200'].offsetTop > scrollTop) {
            $('[value="100"]').addClass('active');
        } else if (floor['200'].offsetTop <= scrollTop && scrollTop < floor['200'].offsetTop + 870) {
            $('[value="200"]').addClass('active');
        }
    });


    $('.js_slide').click(function(){
        var _this = this;
        $('html, body').animate({
            scrollTop: floor[$(_this).attr('value')]['offsetTop']
        });
    });


    /*模态框-领卷*/

    $('.close-modal').click(function () {
        $('.cancel-modal').hide();
    });
    $('.js_discount').click(function (e) {
        var _this = this;
        var id = $(this).attr('value');
        $.get(`/api/coupon/send?coupon_id=${id}`).then(function(res){
            if(res.status == 200){
                $(_this).addClass('active').html('已经领取');
                $('.cancel-modal').show();
            }
        })
    });

      /* 统计数量 */
    $('.thumbnail a').on('click', function (e) {
        var _this = this;
        var courseId;
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

    function log(opType, courseId) {
        var img = new Image();
        var host = 'http://click.wdyedu.com/v.gif';
        var data = {
            app_name: '17dayup',
            pageType: 'activity',
            url: location.href,
            terminal: 'pc',
            opType_spring: opType,
            course_id: courseId
        };
        img.src = host + '?' + toQueryString(data);
    }
</script>
@stop
