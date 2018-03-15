@foreach ($data as $course_data)
<div class="course_item clearfix">
	<a href="/course/{{$course_data['course_id']}}">
		<div class='cont'>	
			<div class="course_img pull-left">
				<img src="{{$course_data['course_img']}}">
			</div>
			<div class="course_desc pull-left">
				<p>{{$course_data['course_name']}}</p>
				<div class="price @if($course_data['price']==0) free @endif">
				@if($course_data['price']>0)
					¥&nbsp;{{$course_data['price']}}
				@else
					免费
				@endif
				</div>
			</div>
		</div>
	</a>
	<div class="sl-opts" data-id="{{$course_data['course_id']}}"></div>
	
</div>
@endforeach
@if(count($data)==0)
		<div class="no-result pure">
            <i class="icon icon-empty"></i>
            <div class="empty-desc">暂无收藏</div>
        <div>
@endif

