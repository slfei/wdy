<?php 
$nav_index = 3; 
$nav_status = [['id'=>0,'name'=>'全部'],['id'=>1,'name'=>'待付款'],['id'=>3,'name'=>'交易成功'],['id'=>2,'name'=>'交易关闭']]
?>
@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '订单',
			'backward' => true
		] ]) 
	@endcomponent 
@stop


@section('content')
<div class="my-order gray_bg has-header">
	<div class="status_nav white_bg clearfix">
	@foreach ($nav_status as $item)
		<a href="javascript:void(0)" data-url="/center/order?status={{$item['id']}}" class="@if($item['id']==$tplData['status']) active @endif">{{$item['name']}}</a>
	@endforeach
	</div>
	<div class="order-table clearfix infinite-scroll" 
		data-url="/api/center/order?is_html=1&status={{$tplData['status']}}">
		@component('mobile.tmpl.order_list', [
			'data' => $tplData['data']
		])
		@endcomponent
	</div>
</div>


@stop 


@section('footer')
@stop

@section('style')
<link rel="stylesheet" href="/static/css/page/user/order.css">

@stop

@section('script')
<script src="/static/js/page/user/order.js"></script>
@stop
