@extends('base.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/search.css">
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/search.js"></script>
@stop