<?php $nav_index = 2 ?>

@extends('mobile.base') 

@section('style')
<link rel="stylesheet" href="/static/css/page/course/discovery.css">
<link rel="stylesheet" href="/static/css/page/course/list.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop 

@section('header')
    @component("mobile.components.header", [
        'data' => [
            'type' => 'text',
            'title' => '课表',
        ]
    ])
    @endcomponent
@stop

@section('content')
<div class="discovery_center has-footer course-list update-wrap">
   <div class="discovery_filter">
       <div class="discovery_filter_area">
	       <ul class="discovery_filter_area_list js-active">
	         <li class="discovery_filter_area_list_item">
	             <span class="text_omit">学习动态</span>
	             <i class="ion-ios-arrow-down"></i>
	         </li>
	         <!-- <li class="discovery_filter_area_list_item">
	             <i class="ion-ios-arrow-down"></i>
	         </li> -->
	         <li class="discovery_filter_area_list_item">
	             <span>筛选</span>
	             <i class="ion-ios-arrow-down"></i>
	         </li>
             <li class="discovery_filter_area_list_item"></li>
	       </ul>
	   </div>
       <div class="discovery_filter_scort discovery_position">
          <ul class="js-sort">
              <li data-sort="1">学习动态</li>
              <li data-sort="2">加入时间</li>
          </ul>
       </div>

       <!-- <div class="discovery_filter_course discovery_position">
            <div class="discovery_filter_course_area">
            <div>
       </div> -->
       <div class="discovery_filter_screen discovery_position">
         <div class="discovery_filter_screen_area">
              <!-- <div class="area1">
                 <div style="display: none;">
                    <input type="radio" name="listen" value="1">
                 </div>
                 <ul class="js-select1">
                    <li>可试听</li>
                 </ul>
              </div> -->
              <div class="area2">
                 <!-- <span class="area2_title">价格区间</span> -->
                 <div style="display: none;">
                   <input type="radio" name="range" value="0">
                   <input type="radio" name="range" value="1">
                   <input type="radio" name="range" value="2">
                 </div>
                 <ul class="js-select2">
                   <li>全部</li>
                   <li>免费</li>
                   <li>付费</li>
                 </ul>
                 <!-- <div style="display: none;">
                    <input type="radio" name="range" value="100-500">
                    <input type="radio" name="range" value="500-1000">
                    <input type="radio" name="range" value="1000-0">
                 </div>
                 <ul class="js-select2">
                   <li>100-500</li>
                   <li>500-1000</li>
                   <li>1000以上</li>
                 </ul> -->
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
</div>
<div class="mask min"></div>

@stop @section('script')
<script src="/static/js/page/course/list.js"></script>

@stop
