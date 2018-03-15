<?php $nav_index = 1 ?>
@extends('mobile.base') 


@section('p-title')在线课程_在线视频_伟东云学堂@stop
@section('meta-keywords')在线课程,在线教育,在线学习,国学文化,亲子早教,基础教育,留学语言,IT教育,人工智能,VR技术,编程技术,测试运维,平面设计,职业考试,留学考研@stop
@section('meta-description')在线课程里的课程涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域，为国内外互联网用户提供了专业优质的教育视频资源，为用户提供在线学习、在线教育等全方位的教育互联网服务。@stop



@section('style')
<link rel="stylesheet" href="/static/lib/unslider/dist/css/unslider.css">
<link rel="stylesheet" href="/static/lib/unslider/dist/css/unslider-dots.css">
<link rel="stylesheet" href="/static/css/page/index/index.css">
<link rel="stylesheet" href="/static/css/page/course/classify.css">

@stop 

@section('header')
    @component("mobile.components.header", [
        'data' => [
            'type' => 'text',
            'title' => '分类'
        ]
    ])
    @endcomponent
@stop



@section('content')
<div class="clearfix classify">
	<div class="left">
		<ul class="list-unstyled">
            @foreach($tplData['category_list']  as $i=>$category)
            <li data-toggle="{{$category['category_id']}}" class="@if($i==0) active @endif">
                <a href="#top">{{$category['name']}}</a>
            </li>
            @endforeach
        </ul>
	</div>
	<ul class="list-unstyled clearfix right menu-container">
        <div class="menu-content">
        @foreach($tplData['category_list']  as $i=>$category)
        @if($i==0)
        <div value="{{$category['category_id']}}" class="section-item">
            @foreach($category['_child']  as $child)
            <div class="title">
                <a href="/course/discovery/?type={{$category['category_id'].'-'.$child['category_id']}}">
                    <span class="text">{{$child['name']}}</span><span class="ion-ios-arrow-right ico"></span>
                </a>
            </div>
            <div class="content">
                @if(isset($child['_child']))
                @foreach($child['_child']  as $hot)
                <a href="/course/discovery/?type={{$category['category_id'].'-'.$child['category_id'].'-'.$hot['category_id']}}">{{$hot['name']}}</a>
                @endforeach
                @endif
            </div>
            @endforeach
        </div>
        @endif
        @endforeach
        </div>
    </ul>
    <div>
        @foreach($tplData['category_list']  as $i=>$category)
        
        <div value="{{$category['category_id']}}" class="section-item hide">
            @foreach($category['_child']  as $child)
            <div class="title">
                <a href="/course/discovery/?type={{$category['category_id'].'-'.$child['category_id']}}">
                    <span class="text">{{$child['name']}}</span><span class="ion-ios-arrow-right ico"></span>
                </a>
            </div>
            <div class="content">
                @if(isset($child['_child']))
                @foreach($child['_child']  as $hot)
                <a href="/course/discovery/?type={{$category['category_id'].'-'.$child['category_id'].'-'.$hot['category_id']}}">{{$hot['name']}}</a>
                @endforeach
                @endif
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@stop
@section('script')
<script src="/static/lib/unslider/dist/js/unslider-min.js"></script>
<script src="/static/lib/iscroll/build/iscroll-probe.js"></script>
<script src="/static/js/page/course/classify.js"></script>
@stop
