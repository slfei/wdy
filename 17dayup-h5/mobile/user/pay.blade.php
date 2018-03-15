<?php 
$nav_index = 3; 
?>
@extends('mobile.base') 


@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '支付订单',
			'backward' => true
		] ]) 
	@endcomponent 
@stop 



@section('content')
<div class="my-pay gray_bg has-header update-wrap">

	<div class="pay-main clearfix">
		<div class="order_detail white_bg clearfix">
			<div class="cell clearfix">
				<div class="label pull-left">
					订单商品:
				</div>
				<div class="detail">
					&nbsp;{{$tplData['data']['crouse_name']}}
				</div>
			</div>
			<div class="cell clearfix">
				<div class="label pull-left">
					应付金额:
				</div>
				<div class="detail">
					&nbsp;¥ {{$tplData['data']['money']}}
				</div>
			</div>
		</div>
		<!-- <div class=" coupon white_bg clearfix">
			<div class="label pull-left">
				优惠券
			</div>
			<div class="select pull-right">
				无可用  <i class="ion-ios-arrow-right"></i>
			</div>
		</div> -->
		<div class="pay_money white_bg clearfix sp">
			<div class="clearfix border sp-hd">
				<div class="label pull-left">
					实付金额: 
				</div>
				<div class="money">
				 &nbsp;¥ {{$tplData['data']['money']}}
				</div>
			</div>
			<div class="pay_method clearfix sp-bd">
				<div class="weui-cells no-border weui-cells_checkbox">
				    <label class="weui-cell weui-check__label payment" for="s11">
					    <div class="weui-cell__bd">
					        <div class="icon icon-weixin pull-left">
					        </div>
					        <div class="pay_desc pull-left">
					        	<p>
					        		微信支付
					        	</p>
					        	<div class="intro">
					        		推荐已安装微信的用户使用
					        	</div>
					        </div>
					    </div>
				        <div class="weui-cell__hd">
				            <input type="radio" class="weui-check wechat-pay" name="radio1" id="s11" checked="checked"/>
				            <i class="weui-icon-checked"></i>
				        </div>
				    </label>
					@if(!$tplData['data']['is_weixin'])
				    <label class="weui-cell weui-check__label payment" for="s12">
					    <div class="weui-cell__bd">
					    	<div class="icon icon-alipay pull-left">
					    	</div>
					    	<div class="pay_desc pull-left">
					    		<p>支付宝支付</p>
					    		<div class="intro">
					    			推荐已安装支付宝的用户使用
					    		</div>
					    	</div>
					    </div>
				        <div class="weui-cell__hd">
				            <input type="radio" name="radio1" class="weui-check" id="s12"/>
				            <i class="weui-icon-checked"></i>
				        </div>
				    </label>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="pay_btn btn-footer color_red btn-footer-big">
		去支付
	</div>
</div>

@stop 
@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/static/css/page/user/pay.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop

@section('script')
<script src="/static/js/page/user/pay.js"></script>
@stop
