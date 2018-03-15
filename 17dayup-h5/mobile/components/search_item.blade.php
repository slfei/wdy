<?php
    $show_coupon = isset($course_data['is_coupon']) ?$course_data['is_coupon'] :false;
?>
                
<li>
    <a href="/course/{{$course_data['course_id']}}">
        <div class="discovery_list_img">
            <img src="{{$course_data['course_img']}}">
            @if($show_coupon)
                <span class="coupon-sign">支持优惠券</span>
            @endif
        </div>
        <div class="discovery_list_info">
            <div class="discovery_list_info_title">{{$course_data['course_name']}}</div>
            <div class="discovery_list_info_name">{{$course_data['from_name']}}</div>
            @if($course_data['type']==1)
               <div class="discovery_list_info_free">免费</div>
            @else
               @if($course_data['cur_price']==$course_data['price'])
                 <div class="discovery_list_info_price">¥ {{$course_data['price']}}</div>
               @else
                 <div class="discovery_list_info_price">¥ {{$course_data['cur_price']}}</div>
               @endif
            @endif
        </div>
    </a>
</li>
