@extends('pc.common')
@section('main')
<div class="w-user-center clearfix">
	<div class="center-sidebar clearfix">
		<div class="user-info white-bg clearfix">
			<div class="pull-left">
				<div class="user-avator pull-left">
					<a class="center-avator" href="/center/edit">
						<img class="avator-img" src="{{$tplData['user_info']['avatar_url']}}">
						<span>@lang('center.sidebar.edit')</span>
					</a>
				</div>
				<div class="user-desc pull-left">
					<div class="nickname">
					@if($tplData['user_info']['nick_name']!=null)
					{{$tplData['user_info']['nick_name']}}
					@else
					@lang('center.sidebar.no_nick')
					@endif
					</div>
					<p>
						{{$tplData['user_info']['short_desc']}}
					</p>
				</div>
			</div>
			<div class="teach-manage pull-right text-right">
			  @if(isset($tplData['user_info']['is_enter']) && $tplData['user_info']['is_enter'])
				<a href="//{{$biz_host}}/institute/index" class="w-btn-primary">@lang('center.sidebar.manager')</a>
			  @endif
			</div>
		</div>
		<div class="side-list white-bg pull-left">
			<div class="text-center">
				<li>
					<a class="@if($side_active==1) center-active @endif" href="/center/course"><i class="ion-book-outline"></i>  @lang('center.sidebar.my_course')</a>
				</li>
				<li>
					<a class="@if($side_active==2) center-active @endif" href="/center/order"><i class="ion-paper-outline"></i>  @lang('center.sidebar.my_order')</a>
				</li>
				<li>
					<a class="@if($side_active==6) center-active @endif en-hide" href="/center/coupon"><i class="ion-pricetags-outline"></i>   @lang('center.sidebar.my_coupon')</a>
				</li>
				<li>
					<a class="@if($side_active==3) center-active @endif" href="/center/collection"><i class="ion-star-outline"></i>  @lang('center.sidebar.my_collection')</a>
				</li>
				<li>
					<a class="@if($side_active==4) center-active @endif" href="/center/notice"><i class="ion-bell-outline"></i>  @lang('center.sidebar.notice')</a>
				</li>
				<li>
					<a class="@if($side_active==5) center-active @endif" href="/center/edit"> <i class="ion-gear-outline"></i>  @lang('center.sidebar.setting')</a>
				</li>
			</div>
		</div>
		<div class="center-right-content white-bg pull-left">
			@yield('center-main')
		</div>
	</div>
</div>
@stop
