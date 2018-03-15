<?php $nav_index = 0 ?> 

@extends('mobile.base') 

@section('style')
<link rel="stylesheet" href="/static/lib/swiper/dist/css/swiper.css">
<link rel="stylesheet" href="/static/css/page/index/index.css"> 
@stop 

@section('content')

<div class="wdy-scroll-wrapper gray_bg">
    <div class="main-area">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($tplData['index_banner_list'] as $item)
                <a class="swiper-slide" href="{{ $item['url'] }}">
                    <img src="{{ $item['image'] }}" alt="{{$item['text']}}">                
                </a>
                @endforeach
            </div>


            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Arrows -->
            <!-- <div class="swiper-button-next"></div> -->
            <!-- <div class="swiper-button-prev"></div> -->
        </div>

        <div class="hot-free-course">
            <div class="title">
                热门免费体验课程 <span class="title-sep">·</span>
                <span class="title-desc"> {{ $tplData['free_course_list'][0]['name'] }} </span>
            </div>
            <!-- 热门免费体验课程 -->
            <div class="x-swiper-container " id="x-swiper-container">
                <div class="x-swiper-wrapper">
                    @foreach($tplData['free_course_list'] as $key=>$item) 
                    @foreach($item['free_course'] as $_key => $_item)
                    <a class="cover" href="/course/{{ $_item['course_id'] }}?tab=1" 
                        data-cate="{{ $item['name'] }}" data-cate-id="{{$key}}">
                        <img src="{{ $_item['course_img'] }}" alt="">
                        <div class="img_cover"></div>
                        <i class="icon icon-play"></i>
                        <div class="title ellipsis">
                            {{ $_item['course_name'] }}
                        </div>
                    </a>
                    @endforeach 
                    @endforeach
                </div>
            </div>
            <div class="x-swiper-indicator">
                    @foreach($tplData['free_course_list'] as $key=>$item) 
                    <i @if($loop->index == 0) class="active" @endif></i>
                    @endforeach
            </div>
        </div>


    </div>



    @foreach($tplData['course_list'] as $item) @component('mobile.components.course_panel', [ 'data' => $item ]) @endcomponent
    @endforeach
</div>


<script>
 var $tplData;
        try{
            $tplData = {!! isset($tplData) ? json_encode($tplData) : "{}" !!}
        }catch (e){
            $tplData = {};
        }
  
</script>


@stop @section('script')
<script src="/static/lib/iscroll/build/iscroll-probe.js"></script>
<script src="/static/lib/jquery_lazyload/jquery.lazyload.min.js"></script>
<script src="/static/js/page/index/index.js"></script>

@stop
