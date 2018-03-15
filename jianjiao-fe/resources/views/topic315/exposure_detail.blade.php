<?php
    $tplData['page_title'] = '曝光详情';
    $tplData['exposure']= true;
?>
@extends('base.app')

@section('style')
    <link rel="stylesheet" href="/build/css/exposure_detail.css">
    <!-- xxxx -->
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/exposure_detail.js"></script>
@stop
