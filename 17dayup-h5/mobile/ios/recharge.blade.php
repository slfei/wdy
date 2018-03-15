<?php 
$nav_index = 3; 
?>

@section('p-title')充值@stop
@extends('mobile.base') 


@section('header') @stop 



@section('content')
<div class="main">
    <div class="list">
        <ul class="js_select">
            @foreach($tplData['data'] as $item)
              <li data-id="{{$item['product_id']}}"><img src="/static/img/icon/ios_p.png"> {{$item['name']}}</li>
            @endforeach
        </ul>
    </div>
   <div class="btn">
       <div class="btn_s js_pay">充值</div>
   </div>
   <div class="info">
      <div class="title">特别说明：</div>
      <div class="text"><span class="space">1、</span>iOS端充值金额不能在其他非iOS端使用；</div>
      <div class="text"><span class="space">2、</span>充值金额无法退款，不可提现；</div>
      <div class="text"><span class="space">3、</span>充值中如果遇到充值后未到账等意外问题，请直接进行<span class="feedback js_feedback">意见反馈</span>给我们</div>
   </div>
</div>

@stop 
@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/static/css/page/ios/recharge.css">

@stop

@section('script')
<script>
    var data = '';
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

    setupWebViewJavascriptBridge(function(bridge) {
        
        $('.js_pay').on('click',function(){
            bridge.callHandler('recharge', {'key':data}, function responseCallback() {
            });
        });

        $('.js_feedback').on('click',function(){
            bridge.callHandler('feedback');
        })
    });

    $('.js_select').on('click','li',function(){
          data = $(this).data('id');
          $(this).addClass('active').siblings().removeClass('active');
    });
   
</script>
@stop
