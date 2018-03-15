<?php 
$nav_index = 3; 
?>
@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '收藏',
			'backward' => true
		] ]) 
	@endcomponent 
@stop


@section('content')
<div class="my-collection white_bg has-header update-wrap">
	<div class="collect-main infinite-scroll" data-url="/api/center/collect?is_html=1">
		@component('mobile.tmpl.collection_list', [
			'data' => $tplData['data']
		])
		@endcomponent
	</div>
</div>

@stop 

@section('style')
<link rel="stylesheet" href="/static/css/page/user/collection.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop

@section('footer')
@stop

@section('script')
<script src="/static/js/page/user/collection.js"></script>
@stop
