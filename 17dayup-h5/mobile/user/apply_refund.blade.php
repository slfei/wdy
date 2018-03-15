<?php 
$nav_index = 3; 
?>
@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '申请退款',
			'backward' => true
		] ])
	@endcomponent 
@stop 

@section('content')
<div class="my-refund gray_bg has-header">
	
	<div class="refund-main">
			<div class="cell clearfix white_bg ui-picker" data-options="{{json_encode($tplData['refund_reason'])}}">
				<span class="pull-left label">退款原因</span>
				<span class="pull-right select"
					><span class="reason">请选择</span> <i class="ion-ios-arrow-right"></i></span>
			</div>
			<div class="cell white_bg clearfix">
				<span class="label pull-left">退款金额: </span>
				<span class="red"> ¥ {{$tplData['data']['cur_price']}}</span>
			</div>
			<div class="cell white_bg refund_intro">
				<span class="label">退款说明</span>
			</div>
			<div class="cell white_bg">
				<div class="refund_textarea">
					<textarea class="refund_text"  maxlength="200"></textarea>
					<div class="com-lenth">
					    <span class="rest-length">0 </span> / 
					    <span class="red-length"> 200</span>
					</div>
				</div>
			</div>
			<script>
			    const orderId = '{{$tplData["data"]["order_id"]}}'			
			</script>
	</div>
	<div class="btn-footer color_red clearfix btn-footer-big">
		<a class="commit-btn">提交申请</a>
	</div>
</div>
@stop 

@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/static/css/page/user/apply_refund.css">

@stop

@section('script')
<script src="/static/js/page/user/apply_refund.js"></script>
@stop
