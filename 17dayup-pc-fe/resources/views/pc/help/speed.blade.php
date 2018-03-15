@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-study">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_speed.title')</div>
            <div class="content">
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_speed.text.one')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/speed1.png">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_speed.text.two')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/speed2.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/speed.css">
@endsection
