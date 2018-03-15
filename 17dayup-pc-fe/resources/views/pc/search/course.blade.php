<?php
   $title = "课程_搜索_伟东云学堂";

   $keywords = "课程搜索,课程名称,视频课程";

   $description = "课程搜索让您可以通过课程名称搜索到您想看到的课程，满足您的学习需求";

	if (isset($locale) && $locale != 'zh_CN') {
		unset($title);
		unset($description);
        unset($keywords);
    }
?>

@extends('pc.common')
@section('main')
	<div class="main-container course">
		<ul class="section-nav list-unstyled list-inline">
		   <li class=""><a href="/course/discovery" target="_blank">@lang("course.discovery.section_nav_all")</a><span class="ion-ios-arrow-right ico"></span></li>
		   <li class="">{{$tplData['filter']['q']}} </li>
		   @if($tplData['total'])
		   <li class="pull-right">@lang("course.search.course.section_nav.count", ['name' => $tplData['total']])</li>
		   @endif
		</ul>
		<div class="section-filter clearfix content-block">
		   <ul class="pull-left list-unstyle list-inline left">
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==0) active @endif" value="all">@lang("course.discovery.section_filter.all")</a></li>
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==1) active @endif" value="free">@lang("course.discovery.section_filter.free")</a></li>
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==2) active @endif" value="discount">@lang("course.discovery.section_filter.discount")</a></li>
			   <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['listen']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="listen"></a>@lang("course.discovery.section_filter.listen")</li>
			   <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['record']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="record"></a>@lang("course.discovery.section_filter.record")</li>
			   <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['live']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="live"></a>@lang("course.discovery.section_filter.live")</li>
		   </ul>
		   <ul class="pull-right list-unstyle list-inline right">
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==0) active @endif" value="synthesise">@lang("course.discovery.section_filter.synthesise")</a></li>
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==1) active @endif" value="good">@lang("course.discovery.section_filter.good")&nbsp<span class="@if($tplData['filter']['sort_type']==1)ion-arrow-downactive @else ion-arrow-down @endif"></span></a></li>
		       <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==2) active @endif" value="hot">@lang("course.discovery.section_filter.hot")&nbsp<span class="@if($tplData['filter']['sort_type']==2)ion-arrow-downactive @else ion-arrow-down @endif"></span></a></li>
		       <li class="price">
		           <a href="javascript:void(0)" class="goto">
		               <div class="" style="display: inline-block;">@lang("course.discovery.section_filter.price")</div>
		               <div class="triangle" style="">
		                   <div class="triangle-to-top  @if($tplData['filter']['sort_type']==3 && $tplData['filter']['sort']==1) activeTop @endif" ></div>
		                   <div class="triangle-to-bottom @if($tplData['filter']['sort_type']==3 && $tplData['filter']['sort']==0) activeBottom @endif"></div>
		               </div>
		           </a>
		       </li>
		       <li class="price-range">
		            <input type="text" @if($tplData['filter']['start']) value="{{$tplData['filter']['start']}}" @endif placeholder="￥" class="start"/>
		            <span>-</span>
		            <input type="text" @if($tplData['filter']['hight']) value="{{$tplData['filter']['hight']}}" @endif placeholder="￥" class="end"/>
		            <button type="button" class="btn btn-xs btn-primary sure-goto" >@lang("course.discovery.section_filter.sure")</button>
		       </li>
		   </ul>
		</div>
		@if($tplData['total'])
		   <div class="row content-block section-list">
		       @forEach($tplData['data'] as $key=>$item)
		       <div class="col-xs-3 col-padding">
		       @component('pc.components.course.item', ['data' => $item])@endcomponent
		       </div>
		       @endforEach
		   </div>
		   <div class="section-pagination">
		       @component('pc.components.pagination.index', ['data'=> [
                   'total' => $tplData['total'],
                   'page_size' => $tplData['page_size'],
                   'current' => $tplData['page_num']
               ] ])
               @endcomponent
		   </div>
		@else
			<div class="section-undefined">
				<div class="course-no-data"></div>
                <p>
					@lang("course.search.course.section_undefined.none_start")<span href="" class="">&nbsp;{{$tplData['filter']['q']}}&nbsp;</span>@lang("course.search.course.section_undefined.none_end")
                    @if($tplData['user_info']['is_login'])
                      @if($tplData['user_info']['is_enter'] =='institute')
                         <a href="//{{$biz_host}}/institute/index" class="">@lang("course.search.course.section_undefined.apply_course")</a>
                      @else
                         <a href="//{{ $www_host }}/activity/join" class="">@lang("course.search.course.section_undefined.apply_join")</a>
                      @endif
                    @else
                       <span class="js_login" style="cursor: pointer;">@lang("course.search.course.section_undefined.login")</span>
                    @endif
                </p>
            </div>
            <div class="section-recommend">
                <div class="title">@lang("course.search.course.section_recommend.title")</div>
                <div class="content">
                    @forEach($tplData['relevant'] as $key=>$item)
                    <div class="col-5">
                         @component('pc.components.course.item', ['data' => $item, 'titleUnvisible' => true])@endcomponent
                    </div>
                    @endforEach
                </div>
            </div>
		@endif
	</div>
	<script>
        window.FILTER = {!! json_encode($tplData['filter']) !!}
    </script>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/search/common.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/search/course.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/js/page/search/course.js"></script>
@stop
