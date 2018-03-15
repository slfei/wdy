@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-study">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_study.title')</div>
            <div class="content">
                <div class="introduce">@lang('help.help_study.text.one')</div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_study.text.two')</div>
                    <div class="rule-content div-block-normal">
                        <img src="/build/img/help/apply-study.png" />
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_study.text.three')</div>
                    <div class="rule-content div-block-normal">
                         <img src="/build/img/help/apply-success.png" />
                    </div>
                    <div class="rule-content div-block-normal">
                         <img src="/build/img/help/pay-success.png" />
                    </div>
                    <div class="rule-content div-block-normal">
                         <img src="/build/img/help/class.png" />
                    </div>
                </div>
                <div class="rule">
                    <div class="rule-title">@lang('help.help_study.text.four')</div>
                    <div class="rule-content div-block-normal">
                         <img src="/build/img/help/course-list.png" />
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/study.css">
@endsection
