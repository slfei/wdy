
@extends('pc.components.center.center_sidebar')
<?php
   $birth_date= explode('-', $tplData['modify_info']['birthday']);
   $side_active = 5;
?>
@section('center-main')
@component('pc.components.modal.avator-modal', ['custom_avator'=>$tplData['user_info']['avatar_url']])
@endcomponent

@component('pc.components.tab.tab-switch',['data'=> [
				    'tab-one' => __('center.edit.baseinfo'),
				    'tab-two' => __('center.edit.bind'),
				    'tab-three' => $tplData['modify_info']['isSetPwd']
				] ])
@endcomponent
<div>
	<ul id="tab-main">
		<li class="tab-content clearfix @if(isset($_GET['type'])&&$_GET['type']!='tab3'||!isset($_GET['type'])) show-tab  @else hide-tab @endif">
			<div class="edit-userinfo text-center tab1-content clearfix">
			  	<div class="user-avator clearfix">
			  		<img class="avator-img" src="{{$tplData['user_info']['avatar_url']}}">
			  	</div>
			  	<div class="update-avator clearfix">
			  		<a class="w-btn-primary">@lang('center.edit.update')</a>
			  	</div>
			  	<div class="user-input clearfix">
				  	<div class="form-group clearfix">
					  	<label class="text-right">@lang('center.edit.nickname')</label>
						  	<input class="nick_name" type="text" name="" placeholder="@lang('center.edit.nickarea')" maxlength="15" value="{{$tplData['modify_info']['name']}}">
					</div>
					<div class="form-group clearfix">
					  		<label class="text-right">@lang('center.edit.introduct')</label>
					  		<input class="signature" type="text" name=""  placeholder="@lang('center.edit.signarea')" maxlength="100" value="{{$tplData['modify_info']['short_desc']}}">
					</div>
					 <div class="form-group clearfix">
					  		<label  class="text-right">@lang('center.edit.gender')</label>
					  		<div class="gender-cat">
						  		<span class="select_gendar"><input class="sex" type="radio" @if($tplData['user_info']['sex']==1) checked @endif name="gender" value="1"><i class="select_radio"><b></b></i>@lang('center.edit.man')</span>
						  		<span class="select_gendar"><input class="sex" type="radio" @if($tplData['user_info']['sex']==2) checked @endif name="gender" value="2"><i class="select_radio"><b></b></i>@lang('center.edit.woman')</span>
					  		</div>
					</div>
					<div class="form-group clearfix">
						<label  class="text-right">@lang('center.edit.birth')</label>
						<div class="select-left">
							<span class="input_select pull-left">
								  <select class="year">
									     @for ($i = Date("Y"); $i >= 1921; $i--)
									     <option value="{{ $i }}" @if($birth_date[0]==$i) selected @endif>{{ $i }} @lang('center.edit.year')</option>
									     @endfor
								  </select>
								  <i class="ion-ios-arrow-down"></i>
							</span>
							<span class="input_select pull-left">
								<select class="month">
									    @for ($j = 1; $j <= 12; $j++)
									    <option value="{{ $j }}" @if($birth_date[1]==$j) selected @endif>{{ $j }} @lang('center.edit.month')</option>
									    @endfor
								</select>
								<i class="ion-ios-arrow-down"></i>
							</span>
							<span class="input_select pull-left">
								<select class="day">
									    @for ($k = 1; $k <= 31; $k++)
									    <option value="{{ $k }}" @if($birth_date[2]==$k) selected @endif>{{ $k }} @lang('center.edit.day')</option>
									    @endfor
								</select>
								<i class="ion-ios-arrow-down"></i>
							</span>
						</div>
					</div>
					<div class="form-group clearfix en-hide">
						<label class="text-right">@lang('center.edit.address')</label>
						<div class="select-left" data-toggle="distpicker">
						    <span class="input_select pull-left">
						        <select class="province" data-province="{{$tplData['modify_info']['province']}}"></select>
						        @if($tplData['modify_info']['province']!=null)<i class="ion-ios-arrow-down"></i>@endif
						    </span>
						    <span class="input_select pull-left">
						        <select class="city" data-city= "{{$tplData['modify_info']['city']}}"></select>
						        @if($tplData['modify_info']['city']!=null)<i class="ion-ios-arrow-down"></i>@endif
						    </span>
						    <span class="input_select pull-left">
						        <select class="country" data-district= "{{$tplData['modify_info']['county']}}"></select>
						        @if($tplData['modify_info']['county']!=null)
						        <i class="ion-ios-arrow-down"></i>
						        @endif
						    </span>
						</div>
					</div>
					<div class="form-group clearfix en-hide">
						<label  class="text-right">@lang('center.edit.job')</label>
						<div class="select-left">
							<span class="input_select pull-left">
								  <select class="industry">
									    @foreach ($tplData['industry'] as $industry_li)
									     <option value="{{ $industry_li['id'] }}" @if($industry_li['id']==$tplData['modify_info']['industry']) selected @endif>{{ $industry_li['name'] }}</option>
									     @endforeach
								  </select>
								  <i class="ion-ios-arrow-down"></i>
							</span>
						</div>
					</div>
					
					@if(!empty($tplData['modify_info']['email']))
					<div class="form-group clearfix">
					  		<label class="text-right">@lang('center.edit.email')</label>
					  		<input class="mobile-disable" type="text" name=""  value="{{$tplData['modify_info']['email']}}" disabled="disabled" >
					</div>
					@else
					<div class="form-group clearfix">
					  		<label class="text-right">@lang('center.edit.phone')</label>
					  		<input class="mobile-disable" type="text" name=""  value="{{$tplData['modify_info']['phone']}}" disabled="disabled" >
					</div>
					@endif
					<div class="form-group text-center action clearfix">
						<a class="w-btn-primary save_info">@lang('center.edit.save')</a>
					</div>
				</div>
			</div>
		</li>

		<li class="tab-content hide-tab">
			<div class="bind_account">
				<div class="bind_weichat border_bottom">
				  	<div class="other_social clearfix">
				      	<div class="pull-left">
				          	<a class="wei_login base_login"></a>
				          	<p>@lang('center.bind.wechat')</p>
				      	</div>
				      	<div class="bind_arrow pull-left">⇋</div>
				      	<div class="bind_account_name">
					        @if($tplData['modify_info']['wechat_nickname'])
					          <a class="margin_top nickname">{{$tplData['modify_info']['wechat_nickname']}}@lang('center.bind.bind')</a>
					        @else
					          <a class="margin_top">@lang('center.bind.unbind')</a>
					        @endif
				      	</div>
				  	</div>
				</div>
				<div class="bind_qq border_bottom">
				  	<div class="other_social clearfix">
				      	<div class="pull-left">
				          <a class="qq_login base_login"></a>
				          <p>@lang('center.bind.qq')</p>
				      	</div>
				      	<div class="bind_arrow pull-left">⇋</div>
				      	<div class="bind_account_name">
				        @if($tplData['modify_info']['qq_nickname'])
				          <a class="margin_top nickname">{{$tplData['modify_info']['qq_nickname']}}@lang('center.bind.bind')</a>
				        @else
				          <a class="margin_top">@lang('center.bind.unbind')</a>
				        @endif
				      	</div>
				  	</div>
				</div>
			</div>
		</li>
		@if($tplData['modify_info']['isSetPwd'])
			<li class="tab-content @if(isset($_GET['type'])&&$_GET['type']=='tab3') show-tab @else hide-tab @endif">
				<div class="setpassword">
				  	<div class="form-group clearfix">
                        <input class="oldpwd" type="password" name="" placeholder="@lang('center.password.old')" >
					</div>
					<div class="form-group clearfix">
                        <input class="newpwd" type="password" name="" placeholder="@lang('center.password.new')" >
					</div>
					<div class="form-group clearfix">
                        <input class="second_pwd" type="password" name="" placeholder="@lang('center.password.oncemore')" >
					</div>
					<div class="form-group sure-pwd clearfix">
						<a  class="w-pwd-primary" id="update-pwd">@lang('center.password.sure')</a>
					</div>
				</div>
			</li>
		@else
		<li class="tab-content @if(isset($_GET['type'])&&$_GET['type']=='tab3') show-tab @else hide-tab @endif">
			<div class="setpassword">
					<div class="pwdrule">
						@lang('center.password.unset')
					</div>
				  	<div class="form-group clearfix">
						  	<input class="setpwd" type="password" name="" placeholder="@lang('center.password.input')" maxlength="15">
					</div>
					<div class="form-group sure-pwd clearfix">
						<a class="w-pwd-primary" id="set-pwd">@lang('center.password.sure')</a>
					</div>
			</div>
		</li>
		@endif
			<script>
	      		var userphone = '{{ $tplData["modify_info"]["phone"] }}'
	      	</script>
	</ul>
</div>
@stop

@section('style')
	<link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/edit.css">
@endsection

@section('script')
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/lib/distpicker/distpicker.js"></script>
    <script src="/build/js/page/center/edit.js"></script>
@stop
