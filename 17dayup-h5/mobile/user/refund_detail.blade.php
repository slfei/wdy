<?php 
$nav_index = 3; 
$time_line = [['id'=>1,'title'=>'申请已提交，请等待卖家处理。','desc'=>'卖家会在03天00时00秒内处理，如超过时间，则自动默认申请通过！
'],['id'=>2,'title'=>'退款成功
','desc'=>'退款会在2-7个工作日退还到您的购买账户'],['id'=>3,'title'=>'退款完毕
','desc'=>'退款成功时间：2017-06-11 08:21:50'],['id'=>4,'title'=>'退款关闭
','desc'=>'退款会在2-因您撤销退款申请，退款已关闭，关闭时间为：2017-09-20 14:11:21']]
?>
@extends('mobile.base') 


@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '申请退款',
			'backward' => true,
			'backUrl' => '/center/order'
		] ]) 
	@endcomponent 
@stop 


@section('content')
<div class="my-refund gray_bg">
	<div class="refund_detail">
		<div class="cell white_bg">
			<div class="cell_head ">
				申请退款记录
			</div>
			<div class="record">
				<li>退款编号:  {{$tplData['data']['refund_info']['refund_no']}}</li>
				<li>申请时间:  {{$tplData['data']['refund_info']['add_time_str']}}</li>
				<li>退款金额:  ¥ {{$tplData['data']['refund_info']['refund_money']}}</li>
				<li>退款原因:  {{$tplData['data']['refund_info']['reason_str']}}</li>
				<li>退款说明:  @if(isset($tplData['data']['refund_info']['refund_reason']))  {{$tplData['data']['refund_info']['refund_reason']}} @else 无 @endif</li>
			</div>
		</div>
		<div class="cell white_bg refund_process">
			<div class="cell_head">
				退款流程
			</div>
			<div class="time-line">

				<div class="time_item">
					<div class="refund_status">
						<b class="@if($tplData['data']['refund_result']['status']>=1)active @endif">1  </b>
						<span class="@if($tplData['data']['refund_result']['status']>=1) is_active @endif">申请已提交，请等待卖家处理。</span>
					</div>
					<div class="refund_desc">
						@if($tplData['data']['refund_result']['status']==1)
						卖家会在<span id="dd"></span>天<span id="hh"></span>时<span id="mm"></span>分<span id="ss"></span>秒内处理，如超过时间，则自动默认申请通过！
						@else
						卖家会在00天00时00分00秒内处理，如超过时间，则自动默认申请通过！
						@endif

					</div>
				</div>
				@if($tplData['data']['refund_result']['status']!=3)
				<div class="time_item">
					<div class="refund_status">
						<b class="@if($tplData['data']['refund_result']['status']>=2)active @endif">2 </b>
						<span class="@if($tplData['data']['refund_result']['status']>=2) is_active @endif">退款成功</span>
					</div>
					<div class="refund_desc">
						退款会在2-7个工作日退还到您的购买账户
					</div>
				</div>

				
				<div class="time_item">
					<div class="refund_status">
						<b class="@if($tplData['data']['refund_result']['status']==4)active @endif">3  </b>
						<span class="@if($tplData['data']['refund_result']['status']==4) is_active @endif">退款完毕</span>
					</div>
					<div class="refund_desc">
						@if($tplData['data']['refund_result']['status']==4)
						退款成功时间：{{$tplData['data']['refund_info']['last_operation_time']}}
						@endif
					</div>
				</div>
				@endif

				@if($tplData['data']['refund_result']['status']==3)
				<div class="time_item">
					<div class="refund_status">
						<b class="@if($tplData['data']['refund_result']['status']==3)active @endif">2  </b>
						<span class="@if($tplData['data']['refund_result']['status']==3) is_active @endif">退款关闭</span>
					</div>
					<div class="refund_desc">
						因您撤销退款申请，退款已关闭，关闭时间为：{{$tplData['data']['refund_info']['last_operation_time']}}
					</div>
				</div>
				@endif


			</div>
		</div>
	</div>

</div>
@stop 

@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/static/css/page/user/refund_result.css">

@stop
@section('script')
<script>
	window.refundData = {!! json_encode($tplData['data']) !!}
</script>
<script src="/static/js/page/user/refund_detail.js"></script>

@stop
