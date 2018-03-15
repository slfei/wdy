@extends('base.app')

@section('style')
    <link rel="stylesheet" href="/build/css/my_test_list.css">
    <!-- xxxx -->
@stop

@section('content')
    <div id="app">
        <div id="main"></div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="/build/js/vendor.js"></script>
    <script type="text/javascript" src="/build/js/my_test_list.js"></script>
@stop
