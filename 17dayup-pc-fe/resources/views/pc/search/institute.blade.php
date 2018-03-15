<?php
   $title = "机构_搜索_伟东云学堂";


   $keywords = "机构搜素,机构名称,机构信息";

   $description = "机构搜索让您可以通过机构名称搜索到您想要找的机构";

   $searchType = 'institute';
    if (isset($locale) && $locale != 'zh_CN') {
        unset($title);
        unset($description);
        unset($keywords);
    }
?>

@extends('pc.common')
@section('main')
<div class="main-container institute">
    <div class="section-nav">
        @lang("course.search.discovery.section_nav.str_start")@if($tplData['filter']['q'])<span class="keyword">{{$tplData['filter']['q']}}</span>@endif @lang("course.search.discovery.section_nav.str_in")<span class="">{{$tplData['total']}}</span>@lang("course.search.discovery.section_nav.str_end")</a>
    </div>
    @if($tplData['total'])
    <div class="clearfix section-filter">
        <ul class="pull-left list-unstyle list-inline left">
            <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==0) active @endif" sort-type="0">@lang("course.discovery.section_filter.synthesise")</a></li>
            <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==1) active @endif" sort-type="1">@lang("course.discovery.section_filter.score")<span class="ion-arrow-down ion-arrow-downactive"></span></a></li>
            <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==2) active @endif" sort-type="2">@lang("course.discovery.section_filter.course_count")<span class="ion-arrow-down ion-arrow-downactive"></span></a></li>
            <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==3) active @endif" sort-type="3">@lang("course.discovery.section_filter.student_count")<span class="ion-arrow-down ion-arrow-downactive"></span></a></li>
        </ul>
    </div>
    <div class="section-list">
        @forEach($tplData['data'] as $key=>$item)
        <div class="row-list">
            <div class="row">
                <div class="col-xs-9 left">
                    @component('pc.components.search.media', ['data' => $item]) @endcomponent
                </div>
                <div class="col-xs-3 right">
                    @if($item['consult'])
                    <a href="{{$item['consult']}}" class="consult" target="_blank">@lang("course.search.discovery.section_list.consult")</a>
                    @else
                    <a href="javascript:void(0)" class="consult-disabled">@lang("course.search.discovery.section_list.consult")</a>
                    @endif
                </div>
            </div>
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
    <script>
        window.FILTER = {!! json_encode($tplData['filter']) !!}
    </script>
    @else
    <div class="section-undefined">
        <div class="institute-no-data"></div>

        <p>
            @lang("course.search.discovery.section_undefined.none_start")<span class="">{{$tplData['filter']['q']}}</span>@lang("course.search.discovery.section_undefined.none_end")
        </p>
    </div>
    <div class="section-recommend">
        <div class="title">@lang("course.search.discovery.section_recommend.title")</div>
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
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('bodyClass')
@if(count($tplData['data']) == 0)
class="white-bg"
@endif
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="/build/css/pc.css">
<link rel="stylesheet" type="text/css" href="/build/css/page/search/common.css">
<link rel="stylesheet" type="text/css" href="/build/css/page/search/institute.css">
@endsection
@section('script')
<script src="/build/lib/bootstrap/bootstrap.min.js"></script>
<script src="/build/js/page/search/institute.js"></script>
@stop
