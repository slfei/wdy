<?php 
	$side_active = 2;
	function genUrl()
	{
	   return "/center/order" ;
	}
	$statusMap = [];
	foreach($tplData['order_status'] as $item) {
	   $statusMap[$item['status_id']] = $item['status_name'];
	}
	$IS_ZH = !isset($locale) || $locale == 'zh_CN';

	$getPrice = function($data, $key) use ($IS_ZH) {
	    $enKey = 'en_'.$key;
	    return !$IS_ZH && isset($data[$enKey]) ? '$'.$data[$enKey] : '￥'.$data[$key];
	}
?>
@extends('pc.components.center.center_sidebar')
@section('center-main')
@if(empty($tplData['data']))
	<div class="order-table">
		<div class="clearfix">
		 	<table class="table" cellpadding="0">
		 		<thead class="white-bg">
		 			<th>@lang('center.order.details')</th>
		 			<th>@lang('center.order.price')</th>
		 			<th class="all-status">
		 			    @if($tplData['status']==0)
		 			       @lang('center.order.details')
		 			    @else
						    {{ $statusMap[$tplData['status']] }}
		 			    @endif 
		 				<i class="ion-ios-arrow-down toggle-status"></i>
			 			<div class="left-area status-list hide-status">
			 			        <li>
		 						    <a href="/center/order">@lang('center.order.details')</a>
		 					    </li>
			 				@foreach ($tplData['order_status'] as $status_li)
			 					<li>
			 						<a href="/center/order?status={{$status_li['status_id']}}">{{$status_li['status_name']}}</a>
			 					</li>
			 				@endforeach
			 			</div>
		 			</th>
		 			<th>@lang('center.order.operate')</th>
		 		</thead>
		 	</table>
		 </div>
	</div>
    <div class="no-data-type text-center">
    	<div class="no-data-bg no-order">
    	</div>
    	<div>
    		@lang('center.order.nodata')
    	</div>
    </div>
@else
<div class="order-table clearfix">
	<div class="clearfix">
	 	<table class="table" cellpadding="0" cellspacing="0">
	 		<thead class="white-bg">
	 			<th>@lang('center.order.details')</th>
	 			<th>@lang('center.order.price')</th>
	 			<th class="all-status">
	 			    @if($tplData['status']==0)
	 			       @lang('center.order.status')
	 			    @else
						{{ $statusMap[$tplData['status']] }}
					@endif
	 				<i class="ion-ios-arrow-down toggle-status"></i>
		 			<div class="status-list hide-status">
		 			        <li>
		 						<a href="/center/order">@lang('center.order.status')</a>
		 					</li>
		 				@foreach ($tplData['order_status'] as $status_li)
		 					<li>
		 						<a href="/center/order?status={{$status_li['status_id']}}">{{$status_li['status_name']}}</a>
		 					</li>
		 				@endforeach
		 			</div>
	 			</th>
	 			<th>@lang('center.order.operate')</th>
	 		</thead>
	 		<tbody cellpadding="0" cellspacing="0">
	 			@foreach ($tplData['data'] as $order_li)
	 			<tr class="order-no">
		 			<td colspan="4">
		 				<span style="padding-right: 20px">{{$order_li['add_time']}} </span>
		 				<span>@lang('center.order.no') : {{$order_li['order_id']}}</span>
		 			</td>
	 			</tr>
	 			<tr class="order-detail white-bg">
	 				<td>
	 					<div class="course-img">
	 						<a href="/course/{{$order_li['course_id']}}" target="_blank">
                                <img src="{{$order_li['course_img']}}">
                            </a>
	 					</div>
	 					<div class="course-desc">
	 						<p><a href="/course/{{$order_li['course_id']}}" target="_blank" class="desHref" title="{{ $order_li['course_name'] }}">{{ $order_li['course_name'] }}</a></p>
	 						<span class="course-label">
	 							@if($order_li['institute_type']==2)
	 							   <a href="/institute/homepage/{{$order_li['institute_id']}}" target="_blank" class="desInstitute">{{ $order_li['institute'] }}</a>
	 							@else
	 							   <a href="/personal/homepage/{{$order_li['institute_id']}}" target="_blank" class="desInstitute">{{ $order_li['institute'] }}</a>
	 							@endif
	 						</span>
	 					</div>
	 				</td>
	 				<td class="center-position">{{ $getPrice($order_li, 'real_price') }}</td>
	 				@if($order_li['balance_status']==1)
	 				<td class="center-position">@lang('center.order.wait_pay')</td>
                    <td class="order_option">
	 				 <a class="w-btn-primary order_btnw js_goPay" href="javascript:void(0);" data-id="{{$order_li['order_id']}}">@lang('center.order.go_pay')</a><br/>
	 				 <a class="no-style-btn cancel-order operate_btn" data-type="cancel" id="ok_{{$order_li['order_id']}}">@lang('center.order.cancel')</a>
	 				 </td>
	 				@elseif($order_li['balance_status']==2)
	 				<td class="center-position">@lang('center.order.close')</td>
                    <td class="order_option">
	 				<a class="w-btn-primary re-buy order_btnw" href="javascript:void(0)" course_id="{{$order_li['course_id']}}">@lang('center.order.buy_once')</a><br/>
	 				<a class="no-style-btn cancel-order delete-order operate_btn" data-type="delete" id="ok_{{$order_li['order_id']}}">@lang('center.order.delete')</a>
                    </td>
	 				@elseif($order_li['balance_status']==3)
	 				<td class="center-position">@lang('center.order.success')</td>
                    <td class="order_option">
		 				@if($order_li['is_learn'])
		 				    <a class="w-btn-primary order_btnw" href="/course/player/{{$order_li['course_id']}}" target="_blank">@lang('center.order.begin_study')</a>
		 				@endif  
		 				@if($order_li['is_refund']==1)
		 				   <br/><a class="no-style-btn cancel-order"  href="/order/refundapply?order_id={{$order_li['order_id']}}">@lang('center.order.apply_refund')</a>
		 				@elseif($order_li['is_learn'])
		 				   <br/>
		 				   <a class="no-style-btn need-comment" href="/center/publishcomment/?course_id={{$order_li['course_id']}}&enter_type=order" target="_blank">
                                @if($order_li['is_comment'])
                                   @lang('center.order.look_comment')
                                @else
                                   @lang('center.order.go_comment')
                                @endif
		 				   </a>
		 				@endif
                    </td>
	 				@elseif($order_li['balance_status']==4)
	 				<td class="center-position">@lang('center.order.refunding')</td>
                    <td class="order_option">
		                <a class="w-btn-danger order_btn" href="/order/refundprocess?order_id={{$order_li['order_id']}}">@lang('center.order.look_refund')</a> <br/>
		                <a class="no-style-btn cancel-order operate_btn" data-type="refund" id="ok_{{$order_li['order_id']}}">@lang('center.order.cancel_refund')</a>
                    </td>
	 				@elseif($order_li['balance_status']==5)
	 				<td class="center-position">@lang('center.order.deal_refund')</td>
                    <td class="order_option">
		                <a class="w-btn-danger finish-money order_btn" href="/order/refundresult?order_id={{$order_li['order_id']}}">@lang('center.order.look_refund')</a>
                    </td>
	 				@elseif($order_li['balance_status']==6)
	 				<td class="center-position">@lang('center.order.finish_refund')</td>
                    <td class="order_option">
	 				    <a class="w-btn-danger finish-money order_btn" href="/order/refundresult?order_id={{$order_li['order_id']}}">@lang('center.order.look_refund')</a>
                    </td>
	 				@endif
	 				
	 			</tr>
	 			@endforeach
	 		</tbody>
	 	</table>
 	</div>
 	@if(!empty($tplData['data']))
	 	<div class="my-pagination">
	 	@component('pc.components.pagination.index', ['data'=> [
	 	    'total' => $tplData['total'],
	 	    'page_size' => $tplData['page_size'],
	 	    'current' => $tplData['page_num']
	 	] ])
	 	@endcomponent
	 	</div>
 	@endif
</div>
@endif
@component('pc.center.cancel-modal')
@endcomponent
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/table.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/order.css">
@endsection

@section('script')
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/center/order.js"></script>
    <script type="text/javascript">
       console.log({{$tplData['status']}})
    </script>
@stop