@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '提示',
			'backward' => true
		] ]) 
	@endcomponent 
@stop

@section('content')
<div class="my-order gray_bg has-header has-footer">
	<div class="status_nav white_bg clearfix">
	<div class="order-table clearfix">
		<div class="no-result pure">
            <i class="icon icon-empty"></i>
            <div class="empty-desc">{{$tplData['msg']}}</div>
        <div>
	</div>
</div>


@stop 