<?php
  $hover = intval(($tplData['data']['time_expire'] % (60*60*24))/(60*60));
  $minutes = intval(($tplData['data']['time_expire'] % (60*60))/(60));
  $seconds = intval($tplData['data']['time_expire'] % 60);
?>

@extends('pc.common')
@section('main')
    <div class="main-container pay">
        <div class="content-block section-order">
        <div class="title div-padding">@lang('pay.order_title')</div>
        <div class="div-padding">@lang('pay.order_number')&nbsp;:&nbsp;{{$tplData['data']['order_id']}}</div>
        <div class="div-padding">@lang('pay.order_goods')&nbsp;:&nbsp;{{$tplData['data']['crouse_name']}}</div>
        <div class="div-padding">@lang('pay.order_price')&nbsp;:&nbsp;<span class="price">{{$locale == 'en' ?'$ '.$tplData['data']['en_real_money']:'￥ '.$tplData['data']['real_money']}}</span></div>
        <div class="pay-way">@lang('pay.pay_ment')&nbsp;:
            <a href="javascript:void(0)"  class="alipay alipayActive js_payTab" data-type="alipay">
            </a>
            <a href="javascript:void(0)"  class="wx js_payTab" data-type="wechat">
            </a>
            <a href="javascript:void(0)"  class="paypal js_payTab @if(isset($tplData['data']['paypal_show']) && !$tplData['data']['paypal_show']) hide @endif" data-type="paypal">
            </a>
        </div>
    </div>
    <div class="content-block clearfix section-warning">
        <div class="pull-left left">
            <span class="ion-information-circled ico"></span>
            <span class="">@lang('pay.dedline.info1') <b class="pageTimer">{{$hover}} @lang('pay.dedline.info2') {{$minutes}} @lang('pay.dedline.info3') {{$seconds}} @lang('pay.dedline.info4')</b>@lang('pay.dedline.info5')</span>
        </div>
        <div class="pull-right right">
            <div>
                <span>@lang('pay.pay_money')&nbsp;:&nbsp;</span>
                <span class="price">{{$locale == 'en' ?'$ '.$tplData['data']['en_real_money']:'￥ '.$tplData['data']['real_money']}}</span>
            </div>
            <a href="/api/cashier/pay?source=web&payway=alipay&trade_no={{$tplData['data']['order_id']}}" class="buy js_buy" target="_blank">@lang('pay.btn_name')</a>
        </div>
    </div>
    <a data-toggle="modal" href="#modal-code" style="display: none" value="保障触发"></a>
    <a data-toggle="modal" href="#modal-pay-fail" style="display: none" value="保障触发"></a>
    <div id="modal-code" class="modal fade">
        <div class="modal-dialog modal-width">
            <div class="modal-content">
                <div class="clearfix form-group">
                    <span data-dismiss="modal" class="close ion-ios-close ico"></span>
                    </div>
                <div class="form-group">@lang('pay.order_price')&nbsp;:&nbsp; <span class="price">{{$locale == 'en' ?'$ '.$tplData['data']['en_real_money']:'￥ '.$tplData['data']['real_money']}}</span></div>
                <div class="warning form-group">@lang('pay.info')</div>
                <div class="code form-group @if($locale == 'en') en @endif">
                    <img src="" />
                    <div class="hint">
                        @lang('pay.wx_info.info1')<span>@lang('pay.wx_info.info2')</span>@lang('pay.wx_info.info3')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-pay-fail" class="modal fade">
        <div class="modal-dialog modal-width">
            <div class="modal-content form-group">
                <div class="clearfix ">
                    <span data-dismiss="modal" class="close ion-ios-close ico"></span>
                </div>
                <div class="description">@lang('pay.des')</div>
                <div class="fail hide">@lang('pay.fail')</div>
                <div class="action">
                    <a href="javascript:void(0)" class="back js_back" data-dismiss="modal">@lang('pay.repeat_info')</a>
                    <a href="javascript:void(0)" class="pay-result js_result">@lang('pay.btn_sure')</a>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc/pay/pay.css">
@endsection
@section('script')
    <script>
        window.payUrl = '/api/cashier/pay?source=web&trade_no={{$tplData['data']['order_id']}}';
        window.orderId = {!! json_encode($tplData['data']['order_id']) !!};
        window.time = {!! json_encode($tplData['data']['time_expire']) !!};
        window.status = "{!! urldecode($tplData['data']['get_status_url']) !!}";
        window.returnUrl = "{{$tplData['data']['return_url']}}";
        window.lang = "{{$locale}}"
    </script>
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    
    <script src="/build/js/page/pay/pay.js"></script>
@stop
