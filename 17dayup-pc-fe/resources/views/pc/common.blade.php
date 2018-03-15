

@extends('pc.base')

@section('content')

    @include('layout.header')
    @yield('main')
{{--    @yield('banner')
    <div class="main-container clearfix">
        @yield('main')
    </div>--}}
    @include('layout.returntop')
    @include('layout.footer')

@stop

