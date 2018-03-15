@extends('pc.common')
@section('main')
    <div class="main-container clearfix enterGuide">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_enter_home.title')</div>
            <div class="content">
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_home.text.one')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_home.text.two')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/homepage.gif">
                        </div>
                    </div>
                    <div class="rule-title">@lang('help.help_enter_home.text.three')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_home.text.four')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/about.gif">
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/enteryGuide/createHomePage.css">
@endsection
