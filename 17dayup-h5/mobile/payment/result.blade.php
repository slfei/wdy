@extends('mobile.base')
@section('style')
<link rel="stylesheet" href="/static/css/page/payment/success.css"> 
@stop 


@section('header') 
    @component("mobile.components.header", [ 
        'data' => [ 
            'type' => 'text', 
            'title'=> '支付结果',
            'backward' => true
        ] ]) 
    @endcomponent 
@stop


@section('content')
<div class="has-header pay-type-wrap">
    <div class="loading pay-type-0">
        <img src="/static/img/payment/pay.gif">
        <!-- <p>请稍后</p> -->
    </div>
    <div class='pay-type-1'>
        
        <div class='main success-wrap'>
            <div class="cont">
                <img src="/static/img/payment/pay-success.png">
                <p class="type-text color-blue">支付成功</p>
                <p class="tips blue">课程已经添加到您的课表中，马上学习吧！</p>
            </div>
            <div class="btn-cont btn-list-2 clearfix">
                <a class="pay_btn no-bg" href="/center/order?status=3">查看订单</a>
                <a class="pay_btn" href="/course/{{$tplData['data']['result']['course_id']}}?tab=1&autoPlay=true">开始学习</a>
            </div>
        </div>
        <div class="main fall-wrap">
            <div class="cont">
                <img src="/static/img/payment/pay-fall.png">
                <p class="type-text color-red">支付失败</p>
                <p class="tips">该订单会为您保留24小时，24小时如果还未付款，系统将自动取消订单</p>
            </div>
            <div class="btn-cont btn-list-2 clearfix">
                <a class="pay_btn no-bg" href="/center/order?status=1">查看订单</a>
                <a class="pay_btn js_pay" href="javascript:void(0)" data-id="{{$tplData['data']['result']['order_id']}}">重新支付</a>
            </div>
        </div>
    </div>

</div>



@section('footer')
@stop

@stop @section('script')
<script type="text/javascript">
    var order_id=$tplData['data']['result']['order_id']
</script>

<script src="/static/js/page/payment/payment.js"></script>
@stop
