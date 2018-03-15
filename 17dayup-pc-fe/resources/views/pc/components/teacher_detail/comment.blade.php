<?php 
if(isset($teacher_data['info']['is_teacher'])){
	$comment_type = 1;
}
else{
	$comment_type = 0;
}
 ?>
<div class="teacher-comment">
	<div class="comment-header">
		<span class="good-percent comment-border ">
			<span class="praise">{{$teacher_data['comment']['praise']}}</span>
			<i>@lang('institute.comment.praise')</i>
		</span>
		<span class="all-comment sort_type">
			<input id="sort_0" @if($teacher_data['type']==0) checked @endif type="radio" name="type"><i class="select_radio"><b></b></i>
			@lang('institute.comment.all') ({{$teacher_data['comment']['all_comment_num']}})
		</span>
		<span class="sort_type">
			<input id="sort_1" @if($teacher_data['type']==1) checked @endif type="radio" name="type"><i class="select_radio"><b></b></i>
			@lang('institute.comment.good') ({{$teacher_data['comment']['good_comment_num']}})
		</span>
		<span class="sort_type">
			<input id="sort_2" @if($teacher_data['type']==2) checked @endif type="radio" name="type"><i class="select_radio"><b></b></i>
			@lang('institute.comment.ordinary') ({{$teacher_data['comment']['in_comment_num']}})
		</span>
		<span class="sort_type">
			<input id="sort_3" @if($teacher_data['type']==3) checked @endif type="radio" name="type"><i class="select_radio"><b></b></i>
			@lang('institute.comment.bad') ({{$teacher_data['comment']['low_comment_num']}})
		</span>
		<script>
			window.person_comment = {
				teacher_id: '{{ $teacher_data["info"]["teacher_id"] }}',
				sort_type: '{{ $teacher_data["type"] }}',
				comment_type: '{{ $comment_type }}'
			};
		</script>
	</div>
	@if(empty($teacher_data['comment']['comment_list']))
	    <div class="no-data-type text-center">
	    	<div class="no-data-bg no-data">
	    	</div>
	    	<div>
	    		@lang('institute.comment.no-data')
	    	</div>
	    </div>
	@else
	<div class="comment-list white-bg">
		@forEach($teacher_data['comment']['comment_list'] as $comment_li)
		<div class="each-comment clearfix">
		<div class="each-left pull-left">
			<div class="user-img">
				<img src="{{$comment_li['avatar_url']}}">
			</div>
			<div class="user-name">
				{{$comment_li['nick_name']}}
			</div>
		</div>
		<div class="comment-content pull-left">
		@for ($i =0; $i <$comment_li['star'] ; $i++)
			<i class="ion-android-star"></i>
		@endfor
		<br/>
			<div class="comment-text">{{$comment_li['text_content']}}</div>
			<div class="resource">
				<span class="gray-i">@lang('institute.comment.course')</span>
				<a class="course-name" href="/course/{{$comment_li['course_id']}}">{{$comment_li['course_name']}}</a>
				<span class="date gray-i">{{$comment_li['date']}}</span>
			</div>
		</div>
		</div>
 		@endforEach
	</div>
	<div class="my-pagination">
	@component('pc.components.pagination.index', ['data'=> [
	    'total' => $teacher_data['total'],
	    'page_size' => $teacher_data['page_size'],
	    'current' => $teacher_data['page_num']
	] ])
	@endcomponent
	</div>
	@endif
</div>

