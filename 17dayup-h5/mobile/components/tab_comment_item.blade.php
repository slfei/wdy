<li>
    <div class="comment_area">
        <div class="comment_left">
            <img src="{{$item['avatar_url']}}" alt="">
            <span class="comment_name">{{$item['nick_name']}}</span>
        </div>
        <div class="comment_right">
            <div class="start">
                @for($i =0; $i<5;$i++)
                    @if($i<=$item['star'])
                       <span class="ion-ios-star  active"></span>
                    @else
                       <span class="ion-ios-star"></span>
                    @endif
                @endfor
            </div>
            <div class="start_desc">{{$item['text_content']}}</div>
            <div class="start_info">
                <span>评价课程 <a href="/course/{{$item['course_id']}}">《{{$item['course_name']}}》</a></span><span class="start_data">{{$item['date']}}</span>
            </div>
        </div>
    </div>
</li>
