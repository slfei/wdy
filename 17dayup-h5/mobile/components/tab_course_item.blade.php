<li>
    <a href="/course/{{$items['course_id']}}">
        <div class="course_left">
            <img src="{{$items['course_img']}}" alt="">
        </div>
        <div class="course_right">
            <div class="course_name">{{$items['course_name']}}</div>
            <div class="price_area">
                @if($items['type'] == 1)
                <span class="price_free">免费</span>
                @else
                <span class="curprice">￥{{$items['cur_price']}}</span>
                @if($items['cur_price']!=$items['price'])
                    <span class="nowprice">￥{{$items['price']}}</span>
                @endif
                @endif
            </div>
        </div>
    </a>
</li>
