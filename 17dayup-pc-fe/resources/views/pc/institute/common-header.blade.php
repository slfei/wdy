<?php

   $title = $tplData['institute_info']['name']."_".__('common.appName');

   $keywords = "产品，运营，学习平台，互联网，互联网营销，产品总监，运营总监，品牌营销，事件营销，新媒体";

   $description = $tplData['institute_info']['id']==200109?'“累加学院”是互联网求职者和从业者的在线直播学习社群，为学员提供职业技能培训，并且打造就业服务支撑。开设互联网思维、互联网产品、互联网运营、互联网营销实战课程。':$tplData['institute_info']['name']."入驻伟东云学堂啦，并为学员提供了超多的精品课程，一起来学习把！";

	if (isset($locale) && $locale != 'zh_CN') {
		unset($description);
		unset($keywords);
	}
?>

@extends('pc.common')
@section('main')
<div class="institute-main-center">
	<div class="institute-center clearfix">
		<div class="institute-header white-bg clearfix">
		    <div class="institute-left pull-left">
				<div class="insti-logo pull-left">
					@if($tplData['institute_info']['id'] == 200080)
					  <a href="http://info.tangce.cn/" target="_blank"><img src="{{$tplData['institute_info']['img']}}"></a>
					@else
					  <img src="{{$tplData['institute_info']['img']}}">
					@endif
				</div>
				<div class="insti-desc pull-left">
					<h3>{{$tplData['institute_info']['name']}}</h3>
					<div class="desc-content">
                        <div class="inner">{{$tplData['institute_info']['desc']}}</div>
                    </div>
					<div class="insti-label">
						<span>@lang('institute.comment.praise')  {{$tplData['institute_info']['good']}}</span>
						<span>@lang('institute.institute.course_num')  {{$tplData['institute_info']['course']}}</span>
						<span>@lang('institute.institute.student_num')  {{$tplData['institute_info']['student']}}</span>
					</div>
				</div>
			</div>
			<div class="online-ask pull-right">
				@if($tplData['institute_info']['consult'])
                <a href="{{$tplData['institute_info']['consult']}}" class="consult" target="_blank">@lang('institute.institute.online')</a>
                @else
                <a href="javascript:void(0)" class="consult-disabled">@lang('institute.institute.online')</a>
                @endif
			</div>
		</div>
		<div class="main-institute">
		    <div class="institute-navbar white-bg">
		       	<div class="nav-a">
			    	<a href="/institute/homepage/{{$tplData['institute_info']['id']}}" class="@if($insti==1) institute-active @endif">@lang('institute.institute.page')</a>
			    	<a href="/institute/courselist/{{$tplData['institute_info']['id']}}" class="@if($insti==2) institute-active @endif">@lang('institute.institute.course') ({{$tplData['institute_info']['course']}})</a>
			    	<a href="/institute/teacherlist/{{$tplData['institute_info']['id']}}" class="@if($insti==3) institute-active @endif">@lang('institute.institute.teacher') ({{$tplData['institute_info']['teacher']}})</a>
			    	<a href="/institute/aboutus/{{$tplData['institute_info']['id']}}" class="about-us @if($insti==4) institute-active @endif" >@lang('institute.institute.about')</a>
		    	</div>
		    </div>
		    <div class="institute-content">
		    	@yield('institute-main')
		    </div>
		</div>
	</div>
</div>
@stop
