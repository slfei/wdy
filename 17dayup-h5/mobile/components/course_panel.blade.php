<div class="course-panel">
    <div class="cp-hd clearfix">
        <div class="main pull-left">
            {{ $data['name'] }}
        </div>
        <a href="/course/discovery/?type={{ $data['category_id'] }}" class="more pull-right">
            更多 <i class="icon icon-arrow-right"></i>
        </a>
    </div>
    <div class="cp-focus">
        <a class="thumbnail" href="{{ $data['ad_position'][0]['url'] }}">
            <img src="{{ isset($data['ad_position'][0]['h5_image']) ? $data['ad_position'][0]['h5_image'] : $data['ad_position'][0]['image'] }}" alt="">
        </a>
    </div>

    <div class="cp-item-list x-swiper-container">
  

        <div class="x-swiper-wrapper">
            @foreach($data['course_list'] as $item)
            <?php
                $show_coupon = isset($item['is_coupon']) ?$item['is_coupon'] :false;
            ?>
                <a href="/course/{{ $item['course_id'] }}" class="cover">
                @if($show_coupon)
                    <span class="coupon-sign">支持优惠券</span>
                @endif
                <img class="thumbnail lazy" data-original="{{ $item['course_img'] }}"   src="/static/img/icon/default.png" alt="">
                    <div class="title ellipsis">
                        {{ $item['course_name'] }}
                    </div>
                    <div class="price clearfix">
                        @if($item['cur_price'] == 0)
                        <span class="pull-left price-free">
                            免费
                        </span>
                        @else
                        <span class="pull-left">
                            ¥ {{ $item['cur_price'] }}
                        </span>
                        @endif


                        @if($item['cur_price'] != $item['price'])
                        <span class="pull-right origin">
                           <s> ¥ {{ $item['price'] }} </s>
                        </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        
    </div>
</div>
