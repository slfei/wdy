@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-enter">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_enter.title')</div>
            <div class="content">
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.one')</div>
                    <div class="rule-title">@lang('help.help_enter.text.two')</div>
                    <div class="rule-title">@lang('help.help_enter.text.three')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/enter.jpg">
                        </div>
                    </div>
                    <div class="rule-title">@lang('help.help_enter.text.four')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/enter1.png">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.five')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/enter2.png">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title title-weight">@lang('help.help_enter.text.six')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.seven')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/ienter1.gif">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.eight')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/ienter2.gif">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.nine')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/ienter3.gif">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title title-weight">@lang('help.help_enter.text.ten')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.eleven')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/penter1.gif">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter.text.twelve')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enter/penter2.gif">
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/enter.css">
@endsection
