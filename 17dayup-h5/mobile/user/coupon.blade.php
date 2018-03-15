
@extends('mobile.base') 

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '优惠券',
			'backward' => true
		] ]) 
	@endcomponent 
@stop


@section('content')
  <div class="coupon_area">
      <ul class="infinite-scroll" data-url="/api/center/coupon?is_html=1">
        
      </ul>
      
  </div>


@stop 


@section('footer')
@stop

@section('style')
<link rel="stylesheet" href="/static/css/page/user/coupon.css">

@stop

@section('script')
<script src="/static/js/page/user/coupon.js"></script>
@stop
