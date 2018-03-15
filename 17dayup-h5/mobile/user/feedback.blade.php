<?php 
$nav_index = 3; 
?>
@extends('mobile.base') 


@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '意见反馈',
			'backward' => true,
			'right_html'=>'<span class="feedback_btn">
				            提交
			               </span>'
		] ]) 
	@endcomponent 
@stop


@section('content')
<div class="my-feedback has-header update-wrap">
	<div class="feedback-main">
		<div class="problem_type white_bg clearfix">
			<div class="title">
				问题类型
			</div>
			<div class="select_type clearfix">
				<a> 功能建议</a>
				<a> bug</a>
			</div>
		</div>
		<div class="problem_type white_bg clearfix">
			<div class="title">
				问题内容
			</div>
			<div class="feedback_text clearfix">
				<textarea rows="9"  placeholder="请说一说你对所学课程的学习感受吧！" maxlength="200"></textarea>
			</div>
		</div>
	</div>
	<!-- <div class="feedback_btn btn-footer color_blue btn-footer-big">
		提交
	</div> -->
</div>

@stop 

@section('footer')
@show  

@section('style')
<link rel="stylesheet" href="/static/css/page/user/feedback.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop

@section('script')
<script src="/static/js/page/user/feedback.js"></script>
@stop
