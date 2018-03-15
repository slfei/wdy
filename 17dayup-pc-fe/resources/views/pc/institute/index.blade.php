<?php 
   $insti = 1;
?>
@extends('pc.institute.common-header')
@section('institute-main')
<div class="insti-index">

    @if(
    (!isset($tplData['index_banner_list']) || empty($tplData['course_list']))
    && (!isset($tplData['course_list']) || empty($tplData['course_list']))
    && (!isset($tplData['teacher_list']) || empty($tplData['teacher_list']))
    )
        <div class="no-data-type text-center">
            <div class="no-data-bg no-course">
            </div>
            <div>
                @lang('institute.about_us.no-data')
            </div>
        </div>
    @else
    @if(isset($tplData['index_banner_list']) && !empty($tplData['course_list']))
        <div class="course-carousel">
        @component('pc.components.slider.slider', ['data' => $tplData['index_banner_list']])
        @endcomponent
        </div>
    @endif
        @if(isset($tplData['course_list']))
            @forEach($tplData['course_list'] as $course_cats)
            @if($course_cats['courses'])
            <div class="good-courses white-bg clearfix">
                <div class="white-bg clearfix padding">
                    <h3 class="pull-left">{{$course_cats['title']}}</h3>
                    <p class="all-course pull-right"><a href="/institute/courselist/{{$tplData['institute_info']['id']}}">@lang('institute.teacher.course') <i class="ion-ios-arrow-right"></i></a></p>
                </div>
                <div class="course-recommend clearfix">
                    @component('pc.components.course.course-lists',
                    [
                    'datas'=>$course_cats['courses'],
                    'is_hover_bg'=>false
                    ])
                    @endcomponent
                </div>
            </div>
            @endif
            @endforEach
        @endif

        @if(isset($tplData['teacher_list']) && !empty($tplData['teacher_list']))
        <div class="good-courses clearfix">
            <div class="white-bg padding clearfix">
                <h3 class="pull-left">@lang('institute.teacher.best')</h3>
                <p class="all-course pull-right"><a href="/institute/teacherlist/{{$tplData['institute_info']['id']}}">@lang('institute.teacher.all') <i class="ion-ios-arrow-right"></i></a></p>
            </div>
            <div class="clearfix">
                @component('pc.institute.teacher-list',
                [
                'teacher_data'=>$tplData['teacher_list']
                ])
                @endcomponent
            </div>
        @endif
        </div>
    @endif
</div>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/institute/index.css">
@endsection

@section('script')
    <script src="/build/js/page/institute/index.js"></script>
@stop
