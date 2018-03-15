@extends('pc.common')

@section('main')
   <div class="error">
       <div class="error_img">
           <img src="/build/img/error/404.png" alt="">
       </div>
       <div class="error_btn">
           <a href="//{{$www_host}}" class="error_l">@lang('public.errorPage.error')</a>
           <a href="//{{$www_host}}/course/discovery" class="error_r">@lang('public.errorPage.goto_discovery')</a>
       </div>
   </div>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/error.css">
@endsection
