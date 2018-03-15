@extends('base.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/build/css/institute_address.css">
@stop

@section('content')
<div id="app">
    <div id="main"></div>
</div>
@stop


@section('footer')
@stop

@section('script')
<script src="https://webapi.amap.com/maps?v=1.3&key=14a2f6065fe8c4768d9cb921c791b4ef"></script>
<script type="text/javascript" src="/build/js/vendor.js"></script>
<script type="text/javascript" src="/build/js/institute_address.js"></script>
@stop
