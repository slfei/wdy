<?php
   $title = __('common.slogan');

   $keywords = __('common.keywords');

   //$description = "伟东云学堂涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域教育产品，为国内外互联网用户提供了专业优质的教育资源搜索、在线学习、教育资讯以及在线交易等全方位的教育互联网服务。";
?>

@extends('pc.common')

@section('main')
    <div class="section-banner">
        <div class="main-container">
            <ul class="banner-nav" id="J-category-list">
                @foreach($tplData['category_list'] as $i => $item)
                    <li data-category-id="{{$item['category_id'] + $i}}" class="clearfix">
                        <a href="/course/discovery/{{$item['category_id']}}">
                            {{ $item['name'] }}
                        </a>
                        <a class="pull-right">
                            <i class="ion-ios-arrow-right"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="banner-nav-child en_banner-nav-child" id="J-child-cat-list">
                @foreach($tplData['category_list'] as $i=>$item)
                    <div class="sub-category-list en_sub-category-list" data-category-id="{{$item['category_id'] + $i}}">
                        <ul>
                            @foreach($item['_child'] as $cate)
                                <li class="sub-category-item en_sub-category-item">
                                    <a class="title en_title" href="/course/discovery/{{$cate['category_id']}}" target="_blank">
                                        {{ $cate['name'] }}
                                    </a>
                                    <div>
                                        @if(isset($cate['_child']))
                                        @foreach($cate['_child'] as $node)
                                        <a class="node en_node" href="/course/discovery/{{ $node['category_id'] }}" target="_blank">
                                            {{ $node['name'] }}
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        @component('pc.components.slider.slider', ['data' => $tplData['index_banner_list']])
        @endcomponent
    </div>

    <?php
        $has_live = count($tplData['free_course_list'])==7 ? true : false;
        $free_course_list = $has_live ? __("index.category") : array_slice(__("index.category"), 1);
    ?>
<div class="main-container @if($has_live) has-live @endif">
        <div class="main-category-list clearfix">
            @foreach($free_course_list as $i=>$name)
            <div class="category-item @if($i==0) active @endif" data-i="{{$i}}">
                <a href="javascript:void(0)">
                    <i class="icon @if($has_live) icon-category-{{$i}} @else icon-category-{{($i+1)}} @endif"></i>
                    <div class="name">{{$name}}</div>
                </a>
            </div>
            @endforeach
        </div>

       @foreach($tplData['free_course_list'] as $i=>$freeList)
        <div class="row main-category-content @if(!$i==0) hide @else show @endif" value="{{$i}}">
            @foreach($freeList['free_course'] as $course)
                @if($has_live && $freeList['category_id']==0)
                <div class="col-xs-4 clearfix col-xs-padding">
                    <img class="img-bg" src="{{$course['course_img']}}" alt=""/>
                    <div class="shade-container">
                        <div class="shade">
                            <a href="/course/{{$course['course_id']}}" target="_blank"></a></div>
                        <div class="live-time hide">@lang('index.live.live_time')&nbsp;:&nbsp;{{$course['live_time']}}</div>
                        <a class="goto @if($course['live_status']==0) live-will-icon @else liveing-icon @endif" href="/course/{{$course['course_id']}}" target="_blank" ></a>
                        <div class="live-state hide">@if($course['live_status']==0) @lang('index.live.will_live') @else @lang('index.live.living') @endif:&nbsp;{{$course['course_name']}}</div>
                        <div class="description clearfix">
                            <div>
                                <span class="pull-left omit_area1"><a href="/course/{{$course['course_id']}}" target="_blank">{{$course['course_name']}}</a></span>
                                <span class="pull-right single-row omit_area2"><a href="@if($course['from_type']=='institute'||$course['from_type']==2) /institute/homepage/{{$course['from_id']}} @else /personal/homepage/{{$course['from_id']}}@endif" target="_blank">{{$course['from_name']}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-xs-4 clearfix col-xs-padding">
                    <img class="img-bg" src="{{$course['course_img']}}" alt=""/>
                    <div class="shade-container">
                        <div class="shade"><a href="/course/{{$course['course_id']}}" target="_blank"></a></div>
                        <a class="goto" href="/course/player/{{$course['course_id']}}" target="_blank" ></a>
                        <div class="description clearfix">
                            <div>
                                <span class="pull-left omit_area1"><a href="/course/{{$course['course_id']}}" target="_blank">{{$course['course_name']}}</a></span>
                                <span class="pull-right single-row omit_area2"><a href="@if($course['from_type']=='institute'||$course['from_type']==2) /institute/homepage/{{$course['from_id']}} @else /personal/homepage/{{$course['from_id']}}@endif" target="_blank">{{$course['from_name']}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endforeach
    </div>

    @foreach($tplData['course_list'] as $key=>$item)
    @component('pc.components.course.index_course_block', ['data' => $item, 'key' => $key])@endcomponent
    @endforeach

   <div class="content-block en-hide">
       <div class="main-container">
           <div class="section-news">
               <div class="clearfix">
                   <div class="pull-left title">
                       <i class="icon icon-news-block"></i>
                       最新教育资讯
                   </div>
                   <ul class="pull-right list-unstyled list-inline right">
                       @foreach($tplData['hot_news_cat'] as $hotNews)
                       <li><a href="{{$hotNews['url']}}" target ="_blank">{{$hotNews['name']}}</a></li>
                       @endforeach
                       <li><a href="/news/discovery" target ="_blank">更多<span class="ion-ios-arrow-right ico"></span></a></li>
                   </ul>
               </div>
               <?php
                    $news_in_block = array_slice($tplData['news_list'], 0, 3);
                    $news_in_line = array_slice($tplData['news_list'], 3);
               ?>
               <div class="row-news-block clearfix">
                   @foreach($news_in_block as $item)
                       <div class="col-xs-4">
                               @component('pc.components.news.news', ['data' => $item])@endcomponent
                       </div>
                   @endforeach
               </div>
               <div class="row-news-inline clearfix">
                   @foreach($news_in_line as $item)
                       <div class="col-xs-4 news-inline">
                           <a href="/news/{{$item['news_id']}}" target="_blank" class="clearfix" title="{{ $item['news_title'] }}">
                               <div class="pull-left content-title nowrap">{{ $item['news_title'] }}</div>
                           </a>
                           <span class="pull-right update-at">{{ explode(' ', $item['created_at'])[0] }}</span>
                       </div>
                   @endforeach
               </div>
           </div>

           <div class="section-topics">
               <div class="clearfix">
                    <div class="pull-left title">
                        <i class="icon icon-topic-block"></i>
                        精彩话题不停歇
                    </div>
                    <ul class="pull-right list-unstyled list-inline right">
                      @foreach($tplData['circle_hot_topic'] as $circleHot)
                      <li><a href="{{$circleHot['url']}}" target ="_blank">{{$circleHot['name']}}</a></li>
                      @endforeach
                      <li><a href="https://www.51jianjiao.com/circle/topic/list" target="_blank">更多<span class="ion-ios-arrow-right ico"></span></a></li>
                    </ul>
               </div>
               <div class="content clearfix">
                   @foreach($tplData['circle_hot_question'] as $item)
                       @component('pc.components.topic.index_topic_item', ['data' => $item])@endcomponent
                   @endforeach
               </div>
           </div>

           <div class="section-relative-products main-container">
               <div class="title">
                   <div class="line"></div>
                   <div class="text">产品中心</div>
               </div>
               <div class="product-list">
                   @if(count($tplData['product_list'])>8)
                   <a class="prev"></a>
                   <a class="next"></a>
                   @endif
                   <div class="scroller clearfix">
                        <div class="wrapper" style="width:{{count($tplData['product_list']) * 150}}px;">
                            @foreach($tplData['product_list'] as $i => $item)
                                <div class="product-item">
                                    <a href="{{ $item['url'] }}" target="_blank" class="@if($item['url']=='javascript:;')productHover @endif">
                                        <img src="{{ $item['image'] }}" width="126" height="126" alt="">
                                        <p class="name">
                                            {{ $item['name'] }}
                                        </p>
                                    </a>

                                </div>
                            @endforeach
                        </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
<script>
    window.productsCount = {!! json_encode(count($tplData['product_list'])) !!}
</script>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/index.css">
@endsection
@section('script')
    <script src="/build/js/page/index.js"></script>
@stop

