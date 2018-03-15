<?php 
   $insti = 3;
?>
@extends('pc.components.teacher_detail.common_header')
@section('teacher-main')
	@component('pc.components.teacher_detail.comment', ['teacher_data'=> $tplData ])
	@endcomponent
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/teacher/comment.css">
@endsection

@section('script')
    <script src="/build/js/page/teacher/teacher.js"></script>
@stop
