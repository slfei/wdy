@extends('pc.common')
@section('main')
    <div class="main-container registration">
        <div class="status">
            <img src="/build/img/course/registration-success.png" alt=""/>
            <span class="">@lang('order.success_apply')</span>
        </div>
        <div class="description">@lang('order.order_text.text1') <a href="/center/course">@lang('order.order_text.text2')</a>@lang('order.order_text.text3')<a href="/course/player/{{$_GET['courseid']}}">@lang('order.order_text.text4')</a>@lang('order.order_text.text5')</div>
    </div>
@stop
@section('lib')

@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/course/registration.css">
@endsection
@section('script')

@stop
