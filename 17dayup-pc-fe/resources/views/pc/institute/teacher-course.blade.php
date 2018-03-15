<?php
   $title = $tplData['info']['per_show_name']."_".__('common.appName');
?>

<?php 
   $insti = 2;
?>
@extends('pc.components.teacher_detail.common_header')
@section('teacher-main')
@component('pc.components.teacher_detail.course', ['teacher_course'=> $tplData ])
@endcomponent
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/teacher/course.css">
@endsection

@section('script')
    <script src="/build/js/page/institute/institute.js"></script>
@stop
