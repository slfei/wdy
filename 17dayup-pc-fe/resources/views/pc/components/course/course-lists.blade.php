<?php
     $is_hover_bg_black  =  isset($is_hover_bg_black) ? $is_hover_bg_black : false;
     $common  =  isset($common) ? $common : false;
?>
<div class="course-list clearfix @if($common) common-style @endif">
	@foreach ($datas as $course_list)
	<div class="course_li each-courli goto" course-id="{{$course_list['course_id']}}">
		<div class="hover_course">
			@component('pc.components.course.item',
			[
			'data'=>$course_list,'titleUnvisible'=>true,'show_title'=>true])
			@endcomponent
			@if($is_hover_bg)
				@if($is_hover_bg_black)
				<div class="hover-mask hide hover-collection">
					<div class="clearfix">
					    <i id="collect{{$course_list['course_id']}}" class="close-icon delcourse pull-right"></i>
					    <a class="bg_black" href="/course/{{ isset($course_list['course_id']) ? $course_list['course_id'] : '' }}" target="_biank"></a>
				    </div>
				</div>
				@endif
				@if($common==1)
				<div class="hover-mask hide hover-common">
					<div class="clearfix">
                        <a class="common" href="/center/publishcomment/?course_id={{$course_list['course_id']}}&enter_type=play" target="_biank">@lang('center.collection.comment')</a>
				    </div>
				</div>
				@endif
			@endif
		</div>
	</div>
	@endforeach
</div>

