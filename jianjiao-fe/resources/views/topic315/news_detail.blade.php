<?php
    $tplData['page_title'] = '资讯详情';
    $tplData['activity'] = true;
?>
@extends('base.app')

@section('style')
    <link rel="stylesheet" href="/build/css/315news_detail.css">
    <!-- xxxx -->
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/315news_detail.js"></script>
@stop
