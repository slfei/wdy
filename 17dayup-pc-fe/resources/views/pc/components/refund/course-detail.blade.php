<?php

?>
<div class="course-detail">
    <div class="div-padding-min">@lang('refund.common.course_info.title'):</div>
    <div class="row div-padding-min">
        <div class="col-xs-6 order_col_img"><img class="img-responsive" src="{{$data['course_img']}}" alt="" style="width: 100px; height: 56px;"/></div>
        <div class="col-xs-6 titel">{{$data['course_name']}}</div>
    </div>
    <div class="div-padding-min color_gray">@lang('order.order_num'){{$data['order_id']}}</div>
    <div class="div-padding-min color_gray">@lang('order.order_price')￥{{$data['cur_price']}}</div>
    <div class="div-padding-min color_gray">@lang('order.order_payment')@if($data['pay_type']==1) @lang('order.wechat') @elseif($data['pay_type']==11) @lang('order.balance') @else @lang('order.alipay')  @endif</div>
</div>
