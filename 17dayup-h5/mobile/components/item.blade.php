<a href="/course/{{ $item['course_id'] }}" class="cover">
    <img class="lazy"   src="{{$item['course_img']}}" alt="">
    <div class="single-row course-title">
        {{ $item['course_name'] }}
    </div>
    <div class="course-bottom">
        <div class="single-row price">

            @if($item['cur_price'] == 0)
            <span class="price-free">
                免费
            </span>
            @else
                <span class="price">券后价￥{{$item['coupon_price']}}</span>&nbsp;
                <span class="nowprice">￥{{$item['cur_price']}}</span>
            @endif
        </div>
    </div>
</a>
