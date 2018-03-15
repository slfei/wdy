
<div class="section-course-block content-block">
    <div class="main-container">
        <div class="hd clearfix">
            <div class="pull-left left">
                <i class="icon icon-course-block-{{$key}}"></i>
                @foreach($data as $item)
                    <span class="cate-name @if($loop->first) active @endif" data-category-id="{{$item['category_id']}}">
                        {{ $item['name'] }}
                    </span>
                    @if(!$loop->last)<span class="vertical-line">|</span>@endif
                @endforeach
            </div>
            @foreach($data as $d)
                <div class="pull-right right  @if(!$loop->first) hide @endif"  data-category-id="{{$d['category_id']}}">
                    @foreach($d['hot_cate'] as $hotCate)
                        <a class="hot-cate" href="{{$hotCate['url']}}" target="_blank">{{ $hotCate['name'] }}</a>
                    @endforeach
                    <a class="more" href="/course/discovery/{{$d['category_id']}}">
                        @lang('public.more') <i class="ion-ios-arrow-right"></i>
                    </a>
                </div>
            @endforeach
        </div>
        @foreach($data as $d)
            <div class="bd clearfix @if($loop->last) hide @endif" data-category-id="{{ $d['category_id'] }}">
                <div class="gg-item @if($key%2 == 0) gg-item-horizontal @endif">
                    <a href="{{ $d['ad_position']['url'] }}" target="_blank">
                        <img src="{{ $d['ad_position']['image'] }}"/>
                    </a>
                </div>

                @foreach($d['course_list'] as $course)
                    <div class="col-xs-3">
                        @component('pc.components.course.item', ['data' => $course])@endcomponent
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
