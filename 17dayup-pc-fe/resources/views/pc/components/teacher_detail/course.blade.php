<div class="teacher-course clearfix">
	<div class="sort-head">

		<a class="@if($teacher_course['type']==0) course_active @endif" href="?type=0&is_listen={{$teacher_course['is_listen']}}">@lang('institute.course.all')</a>
		<a class="@if($teacher_course['type']==1) course_active @endif" href="?type=1&is_listen={{$teacher_course['is_listen']}}">@lang('institute.course.free')</a>
		<a class="@if($teacher_course['type']==2) course_active @endif" href="?type=2&is_listen={{$teacher_course['is_listen']}}">@lang('institute.course.discount')</a>
		<a class="course_listen"><label style="cursor: pointer" class="listen_checked @if($teacher_course['is_listen']==1) course_listen_active @endif"></label>@lang('institute.course.listen')</a>
		{{--<a class="hide"><input  type="checkbox" name=""> @lang('institute.course.live')</a>--}}
	</div>
	<div>
		<div class="this-padding white-bg clearfix">
			@if(empty($teacher_course['data']))
			    <div class="no-data-type text-center">
			    	<div class="no-data-bg no-course">
			    	</div>
			    	<div>
			    		@lang('institute.course.no-data')
			    	</div>
			    </div>
			@else
				@component('pc.components.course.course-lists',
				[
				'datas'=>$teacher_course['data'],
				'is_hover_bg'=>false
				])
				@endcomponent
			@endif
		</div>
	</div>
</div>
<div class="my-pagination">
@component('pc.components.pagination.index', ['data'=> [
    'total' => $teacher_course['total'],
    'page_size' => $teacher_course['page_size'],
    'current' => $teacher_course['page_num']
] ])
@endcomponent
</div>
