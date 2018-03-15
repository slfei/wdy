<div class="all-teachers white-bg clearfix">
	@forEach($teacher_data as $teacher_li)
    <a href="/teacher/courselist/{{$teacher_li['teacher_id']}}">
        <div class="each-teacher pull-left">
        	<div class="teacher-img pull-left">
        		<img src="{{$teacher_li['image']}}">
        	</div>
        	<div class="teacher-desc pull-left">
        		<h4>{{$teacher_li['teacher_name']}}</h4>
        		<p>
				  @if($teacher_li['teacher_desc'])
				  {{$teacher_li['teacher_desc']}}
				  @else
				  老师暂时没想到一鸣惊人的签名
				  @endif
				</p>
        	</div>
        </div>
    </a>
    @endforEach
</div>
