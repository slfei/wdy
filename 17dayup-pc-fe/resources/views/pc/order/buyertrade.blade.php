<?php
    $title = "伟东云学堂_确认订单";
    $no_coupon = __('order.no_coupon');
    if (isset($locale) && $locale != 'zh_CN') {
        unset($title);
    }
?>

<?php
   $price = (isset($locale) && $locale=='zh_CN')?'￥ '.$tplData['course']['cur_price']:'$ '.$tplData['course']['en_cur_price'];
   $save_price = (isset($locale) && $locale=='zh_CN')?'￥ 0.00':'$ 0.00';
?>

@extends('pc.common')
@section('main')
<div class="buyertrade_area">
    <div class="buyertrade_main">
        <div class="buyertrade_title">@lang('order.sure_goods')</div>
        <div class="buyertrade_info">
            <table>
               <thead>
                   <tr>
                       <th width="40%">@lang('order.goods')</th>
                       <th width="25%">@lang('order.goods_source')</th>
                       <th width="10%">@lang('order.goods_price')</th>
                       <th width="15%">@lang('order.goods_coupon')</th>
                       <th width="10%">@lang('order.sub_total')</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td class="flex">
                           <div class="left">
                               <img src="{{$tplData['course']['course_img']}}" alt="">
                           </div>
                           <div class="right">
                                {{$tplData['course']['course_name']}}
                           </div>
                       </td>
                       <td>{{$tplData['course']['institute_name']}}</td>
                       <td>{{$price}}</td>
                       <td>
                           <div class="coupon_area @if(count($tplData['coupon'])) js_select @endif">
                              <input type="text" readonly class="data_name" value="@if(count($tplData['coupon'])) {{$tplData['coupon']['0']['coupon_name']}}  @else @lang('order.no_coupon') @endif">
                              <span class="ion-android-arrow-dropup"></span>
                              <ul class="select_coupon js_coupon">
                                 @foreach($tplData['coupon'] as $i => $item)
                                    @if($i)
                                        <li data-value="{{$item['id']}}" title="{{$item['coupon_name']}}">{{$item['coupon_name']}}</li>
                                    @else
                                        <li data-value="{{$item['id']}}" class="selected_active" title="{{$item['coupon_name']}}">{{$item['coupon_name']}}</li>
                                    @endif
                                    
                                 @endforeach
                                    <li data-value="0">@lang('order.nouse_coupon')</li>
                              </ul>
                           </div>
                       </td>
                       <td class="data_price">{{$price}}</td>
                   </tr>
               </tbody>
               <tfoot>
                   <tr>
                        <td colspan="5">
                            <div class="total">
                                  <div class="butn">
                                      <button href="javscript:void(0);" class="js_submit">@lang('order.submit')</button>
                                  </div>
                                  <div class="right">
                                      <div class="now_price">@lang('order.now_price')：<span>{{$price}}</span></div>
                                      <div class="reduce_price data_discountprice">@lang('order.discountprice')：<span>{{$save_price}}</span></div>
                                      <!-- <span class="now_price">@lang('order.now_price')：￥{{$tplData['course']['cur_price']}}</span>
                                      <span class="reduce_price data_discountprice">@lang('order.discountprice')：￥0.00</span> -->
                                  </div>
                                  <div class="left">
                                     @lang('order.total_price'):<span class="price data_price"> {{$price}}</span>
                                  </div>
                            </div>
                        </td>
                   </tr>
               </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="mask">
     <div class="dialog">
          <div class="dialog_bd">@lang('order.have_order_tips')</div>
          <div class="dialog_ft">
              <button type="button" class="js_cancel">@lang('order.cancel_order')</button>
              <button type="button" class="js_payit">@lang('order.pay_button')</button>
          </div>
     </div>
</div>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/order/buyertrade.css">
@endsection
@section('script')
    <script>
       var name = '{!!isset($tplData['coupon']['0'])? $tplData['coupon']['0']['coupon_name'] :$no_coupon!!}';
       var couponId = {!!json_encode(isset($tplData['coupon']['0'])? $tplData['coupon']['0']['id'] :0)!!};
       var courseId = {!!json_encode($tplData['course']['course_id'])!!};
       var price = "{{(isset($locale) && $locale=='zh_CN')?$tplData['course']['cur_price']:$tplData['course']['en_cur_price']}}"; 
    </script>
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/order/buyertrade.js"></script>
@stop
