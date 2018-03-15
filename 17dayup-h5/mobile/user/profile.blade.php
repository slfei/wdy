<?php $nav_index = 3 ?>
@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '我的',
			'backward' => true,
		] ]) 
	@endcomponent 
@stop


@section('content')
<div class="my-profile gray_bg has-header update-wrap">
	<div class="cell-li white_bg">
		<li class="clearfix first">
			<a class="clearfix">
				<span class="avator_desc pull-left">头像</span>
				<span class="avator_upload pull-right">
					<img src="{{$tplData['modify_info']['cover_pic']}}">
				</span>
				<input type="file" id="upload-avatar-input" accept="image/jpg, image/jpeg, image/png" style="display: none" />
			</a>
		</li>
		<li class="clearfix">
			<a class="clearfix">
				<span class="pull-left">昵称</span>
				<span class="pull-right label_desc">
					<input class="nick_name saveText" type="text" name="" maxlength="8"  placeholder="8字以内" value="{{$tplData['modify_info']['name']}}">
				</span>
			</a>
		</li>
		<li class="clearfix">
			<a class="clearfix">
				<span class="pull-left">介绍</span>
				<span class="pull-right label_desc sign_desc">
					<input class="signature saveText" type="text" name=""  maxlength="20"  placeholder="20字以内介绍" value="{{$tplData['modify_info']['short_desc']}}">
				</span>
			</a>
		</li>
	</div>
	<div class="cell-li white_bg">
		<li class="clearfix"><a class="clearfix">
			<span class="pull-left">性别</span>
			<span class="pull-right sex_select">
				<i id="sex-2" class="ion-female gray @if($tplData['modify_info']['sex']==2) active @endif"></i>女
				<i id="sex-1" class="ion-male gray @if($tplData['modify_info']['sex']==1) active @endif"></i>男
			</span>
		</a></li>
		<li class="clearfix">
			<a class="js-pick-date clearfix">
				<span class="pull-left">生日</span>
				<span class="pull-right label_desc">{{$tplData['modify_info']['birthday']}}</span>
				<!-- <input type="date" class="pull-right label_desc" value="{{$tplData['modify_info']['birthday']}}"> -->
			</a>
		</li>
<!-- 		<li class="clearfix">
			<a >
				<span class="pull-left">所在地</span>
				<span class="pull-right label_desc" id="demo1">
				<input type="text" placeholder="请选择城市" value="{{$tplData['modify_info']['province']}} {{$tplData['modify_info']['city']}} {{$tplData['modify_info']['county']}}" readonly id="location" name="location">
				</span>
			</a>
		</li>
 -->		<li class="industry_li industry_true clearfix">
			<a class="js-pick-item clearfix">
				<span class="pull-left">行业</span>
				<span class="pull-right label_desc indus_text" data-value="{{$tplData['modify_info']['industry']}}">
					{{$tplData['modify_info']['industry_str']}}
				</span>
			
				<div class="hide js-items">
				@foreach ($tplData['industry'] as $no)
				  	<span 
					  class="item @if($tplData['modify_info']['industry']==$no['id']) select @endif" 
					  data-name="{{$no['name']}}"
					  data-value="{{$no['id']}}">
					  {{$no['name']}}
					</span>
				@endforeach
			</div>
			</a>
			

		</li>
		<li class="clearfix"><a class="clearfix">
			<span class="pull-left">手机号</span>
			<span class="pull-right label_desc">{{$tplData['modify_info']['phone']}}</span>
		</a></li>
	</div>
</div>

@stop 
@section('footer')
@show  
@section('style')
<link rel="stylesheet" href="/static/css/page/user/profile.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop

@section('script')
<!-- <script src="/static/lib/laydate/dist/laydate.js"></script> -->
<script src="/static/js/page/user/profile.js"></script>

@stop

