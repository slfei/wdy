<?php $price = $locale == 'en' ?'$ '.$tplData['data']['en_real_money']:'￥ '.$tplData['data']['real_money'] ?>

@extends('mobile.base')

@section('content')

@component("layout.header_mobile", [ 
    'data' => [ 
        'backType' => '1', 
        'title'=> __('pay.title')
    ]])
@endcomponent 

<div class="pay">
    <div class="pay_info">
		<div class="pay_order_info">
			<div class="rows">
				<div class="pull_left">
				@lang('pay.order_goods'):
				</div>
				<div class="detail">
					&nbsp;{{$tplData['data']['crouse_name']}}
				</div>
			</div>
			<div class="rows">
				<div class="pull_left">
				@lang('pay.pay_money'):
				</div>
				<div class="detail">
					&nbsp;{{$price}}
				</div>
			</div>
		</div>
		<div class="pay_money_info">
			<div class="rows">
			    <div class="pull_left">
					@lang('pay.order_price'): 
				</div>
				<div class="money">
				 &nbsp;{{$price}}
				</div>
			</div>
		</div>
		<div class="pay_tab_info">
		    @if(isset($tplData['wxconfig']) && $tplData['data']['wx_openid'] =='')
				@if(isset($tplData['data']['paypal_show']) && !$tplData['data']['paypal_show'])
				<div class="rows pay_tab_weixin">
					<div class="pay_tab_left">
						<div class="icon icon_weixin_no pull_left">
						</div>
						<div class="pay_desc pull_left">
							<p>
								@lang('pay.pay_mode.wx.text1')
							</p>
							<div class="intro">
								@lang('pay.pay_mode.wx.text3')
							</div>
						</div>
					</div>
				</div>
				@endif
			@else
			<div class="rows pay_tab_weixin">
				<div class="pay_tab_left">
					<div class="icon icon_weixin pull_left">
					</div>
					<div class="pay_desc pull_left">
						<p>
							@lang('pay.pay_mode.wx.text1')
						</p>
						<div class="intro">
						    @lang('pay.pay_mode.wx.text2')
						</div>
					</div>
				</div>
				<div class="pay_tab_right">
					<i ng-repeat="icon in item.icons" class="ion-checkmark-circled check js_checkTab" data-type="wechat"></i>
				</div>
			</div>
			@endif
			@if(!isset($tplData['wxconfig']))
			<div class="rows pay_tab_alipay">
				<div class="pay_tab_left">
					<div class="icon icon_alipay pull_left">
					</div>
					<div class="pay_desc pull_left">
						<p>@lang('pay.pay_mode.al.text1')</p>
						<div class="intro">
						   @lang('pay.pay_mode.al.text2')
						</div>
					</div>
				</div>
				<div class="pay_tab_right">
					<i ng-repeat="icon in item.icons" class="ion-ios-circle-outline js_checkTab" data-type="alipay"></i>
				</div>
			</div>
			@endif
			<div class="rows pay_tab_paypal @if(isset($tplData['data']['paypal_show']) && !$tplData['data']['paypal_show']) hide @endif">
				<div class="pay_tab_left">
					<div class="icon icon_paypal pull_left">
					</div>
					<div class="pay_desc pull_left">
						<p>@lang('pay.pay_mode.pp.text1')</p>
						<div class="intro">
						   @lang('pay.pay_mode.pp.text2')
						</div>
					</div>
				</div>
				<div class="pay_tab_right">
					<i ng-repeat="icon in item.icons" class="ion-ios-circle-outline js_checkTab" data-type="paypal"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="pay_btn @if(isset($tplData['wxconfig']) && $tplData['data']['wx_openid'] =='' && isset($tplData['data']['paypal_show']) && !$tplData['data']['paypal_show']) prohibit @else js_buy @endif">
	    @lang('pay.btn_name')
	</div>
</div>

@stop 
@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/build/css/mobile/pay/pay.css">
@stop

@section('script')
<script>
    window.orderId = {!! json_encode($tplData['data']['order_id']) !!};
</script>
<script src="/build/js/page/pay/mobile_pay.js"></script>
@stop
