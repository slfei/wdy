@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-refund">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_refund.title')</div>
            <div class="content">
                <div class="introduce">@lang('help.help_refund.text.one')</div>
                <div class="rule">
                    <div class="rule-title">@lang('help.help_refund.text.two')</div>
                    <div class="rule-title">@lang('help.help_refund.text.three')</div>
                    <div class="rule-title">@lang('help.help_refund.text.four')</div>
                </div>
                <div class="introduce">@lang('help.help_refund.text.five')</div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_refund.text.six')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_refund.text.seven')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">@lang('help.help_refund.text.eight')</div>
                        <div class="div-block-normal">@lang('help.help_refund.text.nine')</div>
                    </div>
                </div>
                <div class="rule">
                    <div class="rule-title">@lang('help.help_refund.text.ten')</div>
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/refund.css">
@endsection
