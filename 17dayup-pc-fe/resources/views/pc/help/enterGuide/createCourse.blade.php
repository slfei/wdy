@extends('pc.common')
@section('main')
    <div class="main-container clearfix enterGuide">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_enter_guide.title')</div>
            <div class="content">
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_guide.text.text1')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_guide.text.text2')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_guide.text.text3')</div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_guide.text.text4')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/scsp.gif">
                        </div>
                    </div>
                </div>
                <div class="rule div-block-max">
                    <div class="rule-title">@lang('help.help_enter_guide.text.text5')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/sczl.gif">
                        </div>
                    </div>
                    <div class="rule-title">@lang('help.help_enter_guide.text.text6')</div>
                    <div class="rule-title">@lang('help.help_enter_guide.text.text7')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/create1.gif">
                        </div>
                    </div>
                    <div class="rule-title">@lang('help.help_enter_guide.text.text8')</div>
                    <div class="rule-title">@lang('help.help_enter_guide.text.text9')</div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/create23.gif">
                        </div>
                    </div>
                    <div class="rule-title">
                        @lang('help.help_enter_guide.text.text10')<br> <br>
                        @lang('help.help_enter_guide.text.text11')<br><br>
                        @lang('help.help_enter_guide.text.text12')
                    </div>
                    <div class="rule-content">
                        <div class="div-block-normal">
                            <img src="/build/img/help/enteryGuide/create4.gif">
                        </div>
                    </div>
                    <div class="rule-title div-block-max">
                        @lang('help.help_enter_guide.text.text13')
                    </div>
                    <div class="rule-content div-block-max">
                        <div class="">
                            @lang('help.help_enter_guide.text.text14') <br><br>
                            @lang('help.help_enter_guide.text.text15') <br><br>
                            @lang('help.help_enter_guide.text.text16') <br><br>
                        </div>
                        <div class="div-block-normal">
                            <img src="/build/img/help/create-live.gif">
                        </div>
                        <div>
                            @lang('help.help_enter_guide.text.text17') <br><br>
                            @lang('help.help_enter_guide.text.text18') <br><br>
                            @lang('help.help_enter_guide.text.text19') <br><br>
                            @lang('help.help_enter_guide.text.text20') <br><br>
                            @lang('help.help_enter_guide.text.text21') <br><br>
                            @lang('help.help_enter_guide.text.text22') <br><br>
                            @lang('help.help_enter_guide.text.text23') <br><br>
                            @lang('help.help_enter_guide.text.text24') <br><br>
                            @lang('help.help_enter_guide.text.text25') <br><br>
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/enteryGuide/createCourse.css">
@endsection
