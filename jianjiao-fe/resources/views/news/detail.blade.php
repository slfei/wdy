@section('p-title')
{{ $tplData['news_title'] }}
@stop

@extends('base.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/information_detail.css">
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop


@section('footer')
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/information_detail.js?t=3"></script>
@stop
