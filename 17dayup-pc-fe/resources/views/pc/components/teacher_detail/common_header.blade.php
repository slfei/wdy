@extends('pc.common')
@section('main')
<div class="teacher-main-center">
	<div class="teacher-center clearfix">
		<div class="teacher-header clearfix">
			<div class="teacher_avator">
				<img src="{{$tplData['info']['personal_logo']}}">
			</div>
			<div class="teacher_name">
				{{$tplData['info']['per_show_name']}}
			</div>
			@if(isset($tplData['info']['institute_name']))
			  <div class="scope">
			  	 {{$tplData['info']['institute_name']}}
			  </div>
			@endif
			@if($tplData['info']['ids'])
			   <div class="honor">
					{{$tplData['info']['ids']}}
			   </div>
			@endif
			<div class="teacher-desc">
				{{$tplData['info']['short_des']}}
			</div>
		</div>
		<div class="main-teacher white-bg">
		    <div class="teacher-navbar">
		       	<div class="nav-a">
		       	@if(!isset($tplData['info']['is_teacher']))
			    	<a class="@if($insti==1) border-active @endif" href="/personal/homepage/{{$tplData['info']['teacher_id']}}">@lang('institute.common.index')</a>
			    @endif
			    	<a class="@if($insti==2) border-active @endif" 	@if(!isset($tplData['info']['is_teacher'])) href="/personal/courselist/{{$tplData['info']['teacher_id']}}" @else href="/teacher/courselist/{{$tplData['info']['teacher_id']}}" @endif>@lang('institute.common.course') ({{$tplData['info']['course_num']}})</a>
			    	<a class="about-us @if($insti==3) border-active @endif"  	@if(!isset($tplData['info']['is_teacher'])) href="/personal/commentlist/{{$tplData['info']['teacher_id']}}" @else href="/teacher/commentlist/{{$tplData['info']['teacher_id']}}" @endif>@lang('institute.common.comment') ({{$tplData['info']['comment_num']}})</a>
		    	</div>
		    </div>
		    <div class="teacher-content">
		    	@yield('teacher-main')
		    </div>
		</div>
	</div>
</div>
@stop
