<?php 
   $insti = 1;
?>
@extends('pc.components.teacher_detail.common_header')
@section('teacher-main')
<div class="teacher-index">
	<div class="t-base-info teacher-padding">
		 <h3>@lang('institute.teacher.info')</h3>
		 <p>
		 	 <label> @lang('institute.teacher.subject'): </label>
			  <span>
			  @if($tplData['info']['person_type']=='')
			     @lang('public.no')
			  @else
			     {{$tplData['info']['person_type']}}
			  @endif
			  </span>
		 </p> 
		 <p>
		 	<label> @lang('institute.teacher.year'): </label>
			 <span>
			  @if($tplData['info']['school_age']=='')
			     @lang('public.no')
			  @else
			     {{$tplData['info']['school_age']}}
			  @endif
			 </span>
		 </p>
		 <p>
		 	<label> @lang('institute.teacher.skill'): </label>
			 <span>
			  @if($tplData['info']['description']=='')
			      @lang('public.no')
			  @else
			     {{$tplData['info']['description']}}
			  @endif
			 </span>
		 </p>
	</div>
	<div class="t-best-course clearfix">
	@if(empty($tplData['course_list']))
	    <div class="no-data-type text-center">
	    	@lang('institute.course.no-data')
	    </div>
	@else
		@forEach($tplData['course_list'] as $course_cats)
			@if(count($course_cats['courses']))
			   <div class="good-courses white-bg clearfix">
				   	<div class="white-bg clearfix teacher-padding">
						<h3 class="pull-left">{{$course_cats['title']}}</h3>
						<p class="all-course pull-right"><a href="">@lang('institute.teacher.course') <i class="ion-ios-arrow-right"></i></a></p>
					</div>
					<div class="course-recommend clearfix">
						@component('pc.components.course.course-lists',
						[
						'datas'=>$course_cats['courses'],
						'is_hover_bg'=>false
						])
						@endcomponent
					</div>
				</div>
			@endif
		@endforEach
	@endif
	</div>
</div>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/teacher/index.css">
@endsection
