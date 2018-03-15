@extends('mobile.base')



@section('header') 
    @component("mobile.components.header", [ 
        'data' => [ 
            'type' => 'text', 
            'title'=> '确认订单',
            'backward' => true
        ] ]) 
    @endcomponent 
@stop


@section('content')

<div class="buyertrade_area">
  <div class="buyertrade_title">确认商品</div>
  <div class="buyertrade_line"></div>
  <div class="buyertrade_edu"><img src="{{$tplData['course']['institute_logo']}}" alt="">{{$tplData['course']['institute_name']}}</div>
  <div class="buyertrade_info">
      <div class="left">
           <img src="{{$tplData['course']['course_img']}}" alt="">
      </div>
      <div class="right">
           <div class="name">{{$tplData['course']['course_name']}}</div>
           <div class="price">￥{{$tplData['course']['cur_price']}}</div>
      </div>
  </div>
  <div class="buyertrade_coupon" id="pickerBtn">
       <div class="coupon_title">优惠券</div>
       <span class="ion-ios-arrow-back"></span>
       <div class="coupon_select @if(count($tplData['coupon'])) js_coupon @endif" id="name">@if(count($tplData['coupon'])) {{$tplData['coupon']['0']['coupon_name']}}  @else 无可用 @endif</div>
  </div>
  <div class="buyertrade_footer">
     <div>
        <div class="left">
            合计金额：<span class="price" id="price">￥{{$tplData['course']['cur_price']}}</span>
        </div>
        <div class="right btn js_submit">
            提交订单
        </div>
     </div>
  </div>
</div>


@section('footer')
@stop

@section('style')
<link rel="stylesheet" href="/static/css/page/payment/buyertrade.css"> 
@stop 

@stop @section('script')
<script>
   var name = '{!!isset($tplData['coupon']['0'])? $tplData['coupon']['0']['coupon_name'] :'无可用'!!}';
   var couponId = {!!json_encode(isset($tplData['coupon']['0'])? $tplData['coupon']['0']['id'] :0)!!};
   var couponJson = {!!json_encode($tplData['coupon'])!!};
   var courseId = {!!json_encode($tplData['course']['course_id'])!!};
   var price = {!!json_encode($tplData['course']['cur_price'])!!};   
</script>
<script src="/static/js/page/payment/buyertrade.js"></script>
@stop
