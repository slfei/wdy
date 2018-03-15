
@extends('mobile.base') 

@section('style')
<link rel="stylesheet" href="/static/css/page/course/discovery.css">
<link rel="stylesheet" href="/static/css/page/new-style.css">

@stop 

@section('header')
    @component("mobile.components.header", [
        'data' => [
            'type' => 'text',
            'title' => '课程列表',
            'backward' => 'true',
            'right_html'=>'<span class="icon icon-search js-search">
			               </span>'
        ]
    ])
    @endcomponent
@stop

@section('content')
<div class="discovery_center update-wrap">

   <div class="discovery_filter">
       <div class="discovery_filter_area">
	       <ul class="discovery_filter_area_list js-active">
	         <li class="discovery_filter_area_list_item">
	             <span class="text_omit">综合排序</span>
	             <i class="ion-ios-arrow-down"></i>
	         </li>
	         <li class="discovery_filter_area_list_item">
	             @if(count($tplData['category_tree']) >= 2)
                       @foreach($tplData['category'] as $l=>$leval)
                         @if($leval['category_id']==$tplData['category_tree'][0])
                           @foreach($tplData['category'][$l]['_child'] as $j=>$center)
                                @if(count($tplData['category_tree']) >2 && $center['category_id']==$tplData['category_tree'][1])
                                  @foreach($tplData['category'][$l]['_child'][$j]['_child'] as $right)
                                    @if($right['category_id']==$tplData['category_tree'][2])
                                      <span class="text_omit">{{$right['name']}}</span>
                                    @endif
                                  @endforeach
                                @else
                                    @if($center['category_id']==$tplData['category_tree'][1])
                                      <span class="text_omit">{{$center['name']}}</span>
                                    @endif
                                @endif
                           @endforeach
                         @endif
                       @endforeach
                 @else
                   <span class="text_omit">全部课程</span>
                 @endif
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
              <li data-sort="0-0" class="cur">综合排序</li>
              <li data-sort="0-1">好评度从高到低</li>
              <li data-sort="0-2">人气从高到低</li>
              <li data-sort="0-3">价格从高到低</li>
              <li data-sort="1-3">价格从低到高</li>
          </ul>
       </div>

       <div class="discovery_filter_course discovery_position">
            <div class="discovery_filter_course_area">
               @if($tplData['category_tree']!='')
                   <ul class="discovery_filter_course_left js-left">
                         <li data-left="null">全部</li>
                      @foreach($tplData['category'] as $i=>$left)
                         @if($left['category_id']==$tplData['category_tree'][0])
                           <li data-left="{{$i}}" data-level="{{$left['category_id']}}" class="active_left">{{$left['name']}}</li>
                         @else
                           <li data-left="{{$i}}" data-level="{{$left['category_id']}}">{{$left['name']}}</li>
                         @endif
                      @endforeach
                   </ul>
                   <ul class="discovery_filter_course_center js-center">
                         <li class="@if(count($tplData['category_tree'])==1) active_center @endif" data-getcenter="{{$tplData['category_tree'][0]}}" >全部</li>
                         @foreach($tplData['category'] as $l=>$leval)
                             @if(count($tplData['category_tree'])>1 && $leval['category_id']==$tplData['category_tree'][0])
                               @foreach($tplData['category'][$l]['_child'] as $j=>$center)
                                    @if($center['category_id']==$tplData['category_tree'][1])
                                       <li data-center="{{$l}}-{{$j}}" data-getcenter="@if(!isset($center['_child'])){{$center['category_id']}}@endif" class="active_center">{{$center['name']}}</li>
                                    @else
                                       <li data-center="{{$l}}-{{$j}}" data-getcenter="@if(!isset($center['_child'])){{$center['category_id']}}@endif">{{$center['name']}}</li>
                                    @endif
                               @endforeach
                             @else
                              @if($tplData['category'][$l]['category_id']==$tplData['category_tree'][0])
                                  @foreach($tplData['category'][$l]['_child'] as $j=>$center)
                                    @if($center['category_id']==$tplData['category_tree'][0])
                                       <li data-center="{{$l}}-{{$j}}" data-getcenter="@if(!isset($center['_child'])) {{$center['category_id']}} @endif" class="active_center">{{$center['name']}}</li>
                                    @else
                                       <li data-center="{{$l}}-{{$j}}" data-getcenter="@if(!isset($center['_child'])) {{$center['category_id']}} @endif">{{$center['name']}}</li>
                                    @endif
                                 @endforeach
                              @endif
                             @endif
                          @endforeach
                   </ul>
                   <ul class="discovery_filter_right js-right">
                       @if(count($tplData['category_tree']) > 2)
                            <li>全部</li>
                           @foreach($tplData['category'] as $l=>$leval)
                             @if($leval['category_id']==$tplData['category_tree'][0])
                               @foreach($tplData['category'][$l]['_child'] as $j=>$center)
                                    @if($center['category_id']==$tplData['category_tree'][1])
                                        @foreach($tplData['category'][$l]['_child'][$j]['_child'] as $right)
                                            @if($right['category_id']==$tplData['category_tree'][2])
                                            <li data-request="{{$right['category_id']}}" class="active_right">{{$right['name']}}</li>
                                            @else
                                            <li data-request="{{$right['category_id']}}">{{$right['name']}}</li>                                        
                                            @endif
                                        @endforeach
                                    @endif
                               @endforeach
                             @endif
                           @endforeach
                       @endif
                   </ul>
               @else
                   <ul class="discovery_filter_course_left js-left">
                         <li data-left="null" class="@if($tplData['category_tree']=='') active_left @endif">全部</li>       
                      @foreach($tplData['category'] as $i=>$left)
                         <li data-left="{{$i}}" data-level="{{$left['category_id']}}">{{$left['name']}}</li>
                      @endforeach
                   </ul>
                   <ul class="discovery_filter_course_center js-center">
                   </ul>
                   <ul class="discovery_filter_right js-right">
                   </ul>
               @endif
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
                   <li>¥0-50</li>
                   <li>¥50-100</li>
                 </ul>
                 <div style="display: none;">
                    <input type="radio" name="range" value="100-500">
                    <input type="radio" name="range" value="500-1000">
                    <input type="radio" name="range" value="1000-0">
                 </div>
                 <ul class="js-select2">
                   <li>¥100-500</li>
                   <li>¥500-1000</li>
                   <li>¥1000以上</li>
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

@section('footer')@stop

@section('script')
<script type="text/javascript">
   window.courseData = {!! json_encode($tplData['category']) !!}
   window.treeData ={!! json_encode($tplData['category_tree']) !!}
</script>
<script src="/static/js/page/course/discovery.js"></script>

@stop
