<?php
    $tplData['page_title'] = '我要曝光';
?>
@extends('base.app')

@section('style')
    <link rel="stylesheet" href="/build/css/exposure_edit.css">
    <!-- xxxx -->
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/exposure_edit.js"></script>
@stop
