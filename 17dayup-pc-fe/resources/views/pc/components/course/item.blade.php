<?php
     $titleUnvisible  =  isset($titleUnvisible) ? $titleUnvisible : false;
     $show_title  =  isset($show_title) ? $show_title : false;
     $show_coupon = isset($data['is_coupon']) ? $data['is_coupon'] : false;
     $institute_visible = isset($institute_visible) ? $institute_visible : true;
?>


<div class="wt-thumbnail">
    <div class="thumbnail" >
        <a href="/course/{{ isset($data['course_id']) ? $data['course_id'] : '' }}" target="_blank"><img src="{{$data['course_img']}}" alt="..."></a>
        @if($show_coupon)
        <span class="coupon-sign">@lang('public.coupon')</span>
        @endif
        <div class="caption @if($show_title) collection-caption @endif">
            @if(!$titleUnvisible || $show_title)
            <div class="title">
                <span class="span1" title="{{$data['course_name']}}"><a href="/course/{{ isset($data['course_id']) ? $data['course_id'] : '' }}" target="_blank">{{$data['course_name']}}</a></span>
                <!-- <span class="span2">{{$data['course_name']}}</span> -->
            </div>
            @endif
             @if(!$show_title)
            <p class="description @if(!$titleUnvisible) grey @endif">@if(isset($data['sentence'])) {{ $data['sentence'] }} @endif</p>
            @endif
            <p class="other">
                @if($data['type']=='1')
                    <span class="free">@lang('public.free_price')</span>
                @else
                    @if(!$institute_visible)
                        <span class="price"  title="{{$data['coupon_price']}}">券后价￥{{$data['coupon_price']}}</span>&nbsp;
                        <span class="original-price"  title="{{$data['cur_price']}}">￥{{$data['cur_price']}}</span>
                    @else
                        @component('pc.components.course.price', ['data' => $data])
                        @endcomponent
                    @endif
                @endif
                @if($institute_visible)
                <span class="pull-right single-row lecturer">
                    <a href="@if($data['from_type']=='institute'||$data['from_type']==2) /institute/homepage/{{$data['from_id']}} @else /personal/homepage/{{$data['from_id']}}@endif" target="_blank" title="{{$data['from_name']}}">{{$data['from_name']}}</a>

                </span>
                @endif
            </p>
        </div>
    </div>
</div>
