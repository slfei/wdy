<?php $nav_index = 3 ?> 

@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '我的'
		] ]) 
	@endcomponent 
@stop 

@section('content')
<div class="center_area">
	<div class="my-center gray_bg has-header">

	<a href="/center/edit" class="user-profile white_bg clearfix">
		<div class="user-img pull-left">
			<img src="{{$tplData['user_info']['avatar_url']}}">
		</div>
		<div class="user-desc pull-left">
			<p>{{$tplData['user_info']['nick_name']}}</p>
			<div class="user-label">
				@if($tplData['user_info']['short_desc'])
				{{$tplData['user_info']['short_desc']}}
				@else
				这个人很懒，什么都没留下
				@endif
			</div>
		</div>
	</a>

	<div class="my-cell white_bg clearfix">
		<a class="clearfix item" href="/center/order">
			<span class="pull-left main">
				<i class="icon icon-order"></i> &nbsp;
				<span>我的订单</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
		
		<a class="clearfix item" href="/center/coupon">
			<span class="pull-left main">
				<i class="icon icon-discount"></i> &nbsp;
				<span>优惠券</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
		
	</div>
	<div class="my-cell white_bg clearfix">
		<a class="clearfix item" href="/center/collection">
			<span class="pull-left">
				<i class="icon icon-collection"></i> &nbsp;
				<span>我的收藏</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
	</div>
	<div class="my-cell white_bg clearfix">
		<a class="clearfix item" href="/center/aboutus">
			<span class="pull-left">
				<i class="icon icon-about"></i> &nbsp;
				<span>关于我们</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
		<a class="clearfix item" href="/app">
			<span class="pull-left">
				<i class="icon icon-download"></i> &nbsp;
				<span>APP下载</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
		
		<a class="clearfix item" href="/center/feedback">
			<span class="pull-left">
				<i class="icon icon-feedback"></i> &nbsp;
				<span>意见反馈</span>
			</span>
			<span class="ion-ios-arrow-right pull-right"></span>
		</a>
	</div>

	@if(!$tplData['is_weixin'])
	<div class="login_out clearfix login_out_new">
		<a href="javascript:void(0)">退出登录</a>
	</div>
	@endif
	</div>
</div>

@stop @section('style')
<link rel="stylesheet" href="/static/css/page/user/index.css"> @stop @section('script')
<script src="/static/js/page/user/index.js"></script>
@stop
