<?php $nav_index = 2 ?>

@section('p-title')课程_搜索_伟东云学堂@stop
@section('meta-keywords')课程搜索,课程名称,视频课程@stop
@section('meta-description')课程搜索让您可以通过课程名称搜索到您想看到的课程，满足您的学习需求@stop


@extends('mobile.base') 

@section('style')
<link rel="stylesheet" href="/static/lib/unslider/dist/css/unslider.css">
<link rel="stylesheet" href="/static/lib/unslider/dist/css/unslider-dots.css">
<link rel="stylesheet" href="/static/css/page/index/index.css">
<link rel="stylesheet" href="/static/css/page/course/discovery.css">

@stop 

@section('header')
    @component("mobile.components.header", [
        'data' => [
            'type' => 'search',
            'backward' => 'true',
            'tips' => 'false',
            'q' => ($tplData['filter']['q'])
        ]
    ])
    @endcomponent
@stop

@section('content')
<div class="discovery_center">
   <div class="discovery_filter">
       <div class="discovery_filter_area">
         <ul class="discovery_filter_area_list js-active">
           <li class="discovery_filter_area_list_item">
               <span class="text_omit">综合排序</span>
               <i class="ion-ios-arrow-down"></i>
           </li>
           <li class="discovery_filter_area_list_item">
                   <span class="text_omit">全部课程</span>
               <i class="ion-ios-arrow-down"></i>
           </li>
           <li class="discovery_filter_area_list_item">
               <span>筛选</span>
               <i class="ion-ios-arrow-down"></i>
           </li>
         </ul>
     </div>
       <div class="discovery_filter_scort discovery_position">
          <ul class="js-sort">
              <li data-sort="0-0">综合排序</li>
              <li data-sort="0-1">好评度从高到低</li>
              <li data-sort="0-2">人气从高到低</li>
              <li data-sort="0-3">价格从高到低</li>
              <li data-sort="1-3">价格从低到高</li>
          </ul>
       </div>

       <div class="discovery_filter_course discovery_position">
            <div class="discovery_filter_course_area">
                   <ul class="discovery_filter_course_left js-left">
                         <li data-left="null">全部</li>       
                      @foreach($tplData['category'] as $i=>$left)
                         <li data-left="{{$i}}" data-level="{{$left['category_id']}}">{{$left['name']}}</li>
                      @endforeach
                   </ul>
                   <ul class="discovery_filter_course_center js-center">
                   </ul>
                   <ul class="discovery_filter_right js-right">
                   </ul>
            </div>
       </div>
       <div class="discovery_filter_screen discovery_position">
         <div class="discovery_filter_screen_area">
              <div class="area1">
                 <div style="display: none;">
                    <input type="text" name="listen" value="">
                 </div>
                 <ul class="js-select1">
                    <li>可试听</li>
                    <li>录播课程</li>
                    <li>直播课程</li>
                 </ul>
              </div>
              <div class="area2">
                 <span class="area2_title">价格区间</span>
                 <div style="display: none;">
                   <input type="radio" name="range" value="0-0">
                   <input type="radio" name="range" value="0-50">
                   <input type="radio" name="range" value="50-100">
                 </div>
                 <ul class="js-select2">
                   <li>免费</li>
                   <li>0-50</li>
                   <li>50-100</li>
                 </ul>
                 <div style="display: none;">
                    <input type="radio" name="range" value="100-500">
                    <input type="radio" name="range" value="500-1000">
                    <input type="radio" name="range" value="1000-0">
                 </div>
                 <ul class="js-select2">
                   <li>100-500</li>
                   <li>500-1000</li>
                   <li>1000以上</li>
                 </ul>
              </div>
              <div class="area3">
                <span class="js-reset btn1">清空筛选</span>
                <span class="js-sure btn2">确定</span>
              </div>
         </div>
       </div>
   </div>
   <div class="discovery_scroll">
      <ul class="discovery_scroll_area">
       
      </ul>
   </div>
   <div class="mask"></div>
</div>
@stop 
@section('script')
<script src="/static/lib/unslider/dist/js/unslider-min.js"></script>
<script src="/static/js/page/index/index.js"></script>
<script type="text/javascript">
  window.courseData = {!! json_encode($tplData['category']) !!};
  window.filterQ = {!! json_encode($tplData['filter']['q']) !!} || '';
</script>
<script src="/static/js/page/search/search.js"></script>

@stop

@section('footer')
@show
