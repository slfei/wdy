<?php
    $side_active = 6;
?>

@extends('pc.components.center.center_sidebar')
@section('center-main')
<div class="user-coupon">
	<div class="coupon-title">
		<h3@lang('center.coupon.coupon')</h3>
	</div>
	<div class="coupon-main">
		@if(empty($tplData['data']))
		    <div class="no-data-type text-center">
		    	<div class="no-data-bg no-coupon">
		    	</div>
		    	<div>
				  @lang('center.coupon.no_coupon')
		    	</div>
		    </div>
		@else
		<div class="clearfix">
		@foreach ($tplData['data'] as $item)
			<div class="item-bg clearfix">
				<div class="coupon_head pull-left">
						 {{$item['coupon_amount']}}
				</div>
				<div class="rule_content pull-left">
					<div class="subtitle">
						@if($item['condition'] == 0)
						   @lang('center.coupon.timerange_text.text1')
						@else
						   @lang('center.coupon.timerange_text.text2') {{$item['limited_amount']}}@lang('center.coupon.timerange_text.text3')
						@endif
					</div>
					<div class="coupon_date">
					    @lang('center.coupon.timerange_text.text4'){{$item['end_time']}}@lang('center.coupon.timerange_text.text5')
					</div>
					<div class="userarea" title="@lang('center.coupon.range'){{$item['flag_name']}}">
					    @lang('center.coupon.range'){{$item['flag_name']}}
					</div>
				</div>
			</div>
		@endforeach
		</div>
		@endif
	</div>
	@if(!empty($tplData['data']))
	 	<div class="my-pagination">
	 	@component('pc.components.pagination.index', ['data'=> [
	 	    'total' => $tplData['pager']['total'],
	 	    'page_size' => $tplData['pager']['page_size'],
	 	    'current' => $tplData['pager']['page_num']
	 	] ])
	 	@endcomponent
	 	</div>
 	@endif
</div>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/coupon.css">
@endsection

@section('script')
	<script src="/build/js/page/center/coupon.js"></script>
@stop
