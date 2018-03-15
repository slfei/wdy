<li>
        <a href="/teacher/courselist/{{$item['teacher_id']}}">
            <div class="teacher_left">
                    <img src="{{$item['image']}}" alt="">
            </div>
            <div class="teacher_right">
                <div class="teacher_name">{{$item['teacher_name']}}</div>
                <div class="teacher_desc">
                @if($item['teacher_desc'])
                {{$item['teacher_desc']}}
                @else
                老师暂时没想到一鸣惊人的签名
                @endif
                </div>
            </div>
        </a>
</li>
