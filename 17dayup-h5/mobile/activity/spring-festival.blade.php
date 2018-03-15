
<?php
    $viewport_width = 750;
 ?>
@extends('mobile.activity_base')

@section('p-title')国学闹春晚 精品好课学不停_伟东云学堂-带梦想远航@stop
@section('meta-description') 国学闹春晚，好课学不停！伟东云学堂汇聚精品课程，狂送大额神券！满51减50，满109减100，满219减200…不容错过！@stop
@section('meta-keywords')国学,国学春晚,国学课程,历史名人,国学启蒙,国学教育@stop
@section('style')
<link rel="stylesheet" href="/static/css/page/activity/spring-fesival.css">
@stop


@section('header')
@if($is_app!=1)
<header class="g-header">
    <div class="header-nav">
        <a class="logo" href="/"></a>
        <div>
            <a  class="order" href="/center/order">我的订单</a >
            <a   class="lottery" href="http://gxcw.wdyedu.com/topic/guoxuechunwan">我要抽奖</a >
            
        </div>
        
    </div>
</header>
@endif
@stop
@section('content')
<div class="spring clearfix">
    <div class="section-head-bg">
        <img src="/static/img/activity/spring-festival/code.png" alt="">
    </div>
    <ul class="clearfix section-discount">
        <li class="discount-main">
            <ul class="discount @if($tplData['coupon'][0]['has_send']!=0) active @endif">
                <li class="discount-money">
                    <span class="unit">￥</span>
                    <span class="text">20</span>
                </li>
                <li class="discount-rule">无门槛</li>
                <li class="discount-action"><a href="javascript:void(0)" class="discount-get js_discount" value="{{$tplData['coupon'][0]['coupon_id']}}">@if($tplData['coupon'][0]['has_send']!=0) 已经领取 @else 立即领券 @endif</a></li>
            </ul>
        </li>
        <li class="discount-main">
            <ul class="discount @if($tplData['coupon'][1]['has_send']!=0) active @endif">
                <li class="discount-money">
                    <span class="unit">￥</span>
                    <span class="text">50</span>
                </li>
                <li class="discount-rule">
                    满51<br>减50
                </li>
                <li class="discount-action"><a href="javascript:void(0)" class="discount-get js_discount" value="{{$tplData['coupon'][1]['coupon_id']}}">@if($tplData['coupon'][1]['has_send']!=0) 已经领取 @else 立即领券 @endif</a></li>
            </ul>
        </li>
        <li class="discount-main">
            <ul class="discount discount-100 @if($tplData['coupon'][2]['has_send']!=0) active @endif">
                <li class="discount-money">
                    <span class="unit">￥</span>
                    <span class="text">100</span>
                </li>
                <li class="discount-rule">满109<br>减100</li>
                <li class="discount-action"><a href="javascript:void(0)" class="discount-get js_discount" value="{{$tplData['coupon'][2]['coupon_id']}}">@if($tplData['coupon'][2]['has_send']!=0) 已经领取 @else 立即领券 @endif</a></li>
            </ul>
        </li>
        <li class="discount-main">
            <ul class="discount discount-200 @if($tplData['coupon'][3]['has_send']!=0) active @endif">
                <li class="discount-money">
                    <span class="unit">￥</span>
                    <span class="text">200</span>
                </li>
                <li class="discount-rule">满219<br>减200</li>
                <li class="discount-action"><a href="javascript:void(0)" class="discount-get js_discount" value="{{$tplData['coupon'][3]['coupon_id']}}">@if($tplData['coupon'][3]['has_send']!=0) 已经领取 @else 立即领券 @endif</a></li>
            </ul>
        </li>
    </ul>
    <div class="section-hot-course">
        <div class="title">
            <h3 class="text">人气好课</h3>
            <a href="/course/discovery" class="pull-right more js_more" value="-1">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="hot-top"></div>
        <div class="hot-left">
            <div class="clearfix list hot-list">
                @forEach($tplData['rqhk'] as $key=>$item)
                <div class="col-3 clearfix">
                    @component('mobile.components.item', ['item' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="hot-bottom"></div>
    </div>

    <div class="course-list course-20">
        <div class="title">
            <h3></h3>
            <a href="/course/discovery/?type=1-248" class="pull-right more js_more" value="248">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="border-top"></div>
        <div class="border-left">
            <div class="clearfix list">
                @forEach($tplData['coupon_20'] as $key=>$item)
                <div class="col-3">
                    @component('mobile.components.item', ['item' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="border-bottom"></div>
    </div>
    <div class="course-list course-50">
        <div class="title">
            <h3></h3>
            <a href="/course/discovery/?type=1-248" class="pull-right more js_more" value="248">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="border-top"></div>
        <div class="border-left">
            <div class="clearfix list">
                @forEach($tplData['coupon_50'] as $key=>$item)
                <div class="col-3">
                    @component('mobile.components.item', ['item' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="border-bottom"></div>
    </div>
    <div class="course-list course-100">
        <div class="title">
            <h3></h3>
            <a href="/course/discovery/?type=1-248" class="pull-right more js_more" value="248">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="border-top"></div>
        <div class="border-left">
            <div class="clearfix list">
                @forEach($tplData['coupon_100'] as $key=>$item)
                <div class="col-3">
                    @component('mobile.components.item', ['item' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="border-bottom"></div>
    </div>
    <div class="course-list course-200">
        <div class="title">
            <h3></h3>
            <a href="/course/discovery/?type=1-248" class="pull-right more js_more" value="248">更多好课<i class="ion-ios-arrow-right"></i></a>
        </div>
        <div class="border-top"></div>
        <div class="border-left">
            <div class="clearfix list">
                @forEach($tplData['coupon_200'] as $key=>$item)
                <div class="col-3">
                    @component('mobile.components.item', ['item' => $item])@endcomponent
                </div>
                @endforEach
            </div>
        </div>
        <div class="border-bottom"></div>
    </div>
    <div class="course-list rules">
        <div class="title">
            <h3>活动规则</h3>
        </div>
        <div class="border-top"></div>
        <div class="border-left text">
            1、活动时间为：2018.02.14-2018.04.15； <br>

            2、活动期间用户可以领取优惠券，每个账号每种优惠券只能领一次； <br>

            3、活动期间用户购买网站参与优惠券抵用活动的课程，则可以使用优惠券抵课程售价，每个课程只能使用一张优惠券； <br>

            4、伟东云学堂对本活动拥有最终解释权。 <br>
        </div>
        <div class="border-bottom"></div>
    </div>
</div>

<script>
    window.isApp = {!!json_encode($is_app)!!}


</script>
@stop
@section('footer')
<div class="foot">
    <a class="logo" href="/"></a>
    <div class="text">
        ©2018 All Rights Reserved<br/>
        伟东云教育 · 版权所有<br>
        京ICP证161318号<br>
        <a class="batb" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=11010802025060" target="_blank">京公网安备11010802025060号</a>
    </div>
</div>
@stop
@section('script')
<script>
    function spring() {
        spring_js()
    }
</script>
<script src="/static/js/page/activity/spring-festival.js"></script>
@stop

