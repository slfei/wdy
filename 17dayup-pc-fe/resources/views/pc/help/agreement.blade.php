@extends('pc.common')
@section('main')
<div class="main-container clearfix help-agreement">
    <div class="pull-left left">
        @include('pc.components.help.sidebar')
    </div>

    <div class="pull-left right">
        <div class="title">@lang('help.help_agreement.title')</div>
        <div class="content">
            <div class="institute div-block-max">
                <div class="institute-content">
                    @lang('help.help_agreement.desc')
                </div>
            </div>
            <div class="buy div-block-max">
                <div class="buy-title">@lang('help.help_agreement.text.buy.title')</div>
                <div class="buy-content div-block-normal">
                    @lang('help.help_agreement.text.buy.desc')
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.buy.1')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.buy.2')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.buy.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.buy.4')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.buy.5')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.buy.6')
                    </div>
                </div>
            </div>
            <div class="refund div-block-max">
                <div class="refund-title">@lang('help.help_agreement.text.refund.title')</div>
                <div class="refund-content">
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.title')</div>
                    <div class="div-block-normal">
                    @lang('help.help_agreement.text.refund.1.desc')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.1')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.2')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.4')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.5')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.6')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.1.7')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.title')</div>
                    <div class="div-block-normal">
                    @lang('help.help_agreement.text.refund.2.desc1')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.desc2')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.1')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.2')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.4')</div>
                    <div class="div-block-normal">
                    @lang('help.help_agreement.text.refund.2.5')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.refund.2.6')</div>
                    <div class="div-block-normal">
                    @lang('help.help_agreement.text.refund.2.7')
                    </div>

                </div>
            </div>
            <div class="refund-flow div-block-max">
                <div class="refund-title">
                    @lang('help.help_agreement.text.flow.title')
                </div>
                <div class="refund-content">
                    <div class="">
                        <div class="div-block-normal">
                            @lang('help.help_agreement.text.flow.1')
                        </div>
                        <div class="div-block-normal">
                            @lang('help.help_agreement.text.flow.2.title')
                        </div>
                        <div class="div-block-normal">
                            @lang('help.help_agreement.text.flow.2.1')
                        </div>
                        <div class="div-block-normal">
                            @lang('help.help_agreement.text.flow.2.2')
                        </div>
                        <div class="div-block-normal">
                            @lang('help.help_agreement.text.flow.3')
                        </div>

                    </div>
                </div>
            </div>
            <div class="indate div-block-max">
                <div class="refund-title">@lang('help.help_agreement.text.indate.title')</div>
                <div class="refund-content">
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.desc')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.1.title')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.1.1')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.1.2')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.1.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.1.4.title')</div>
                    <div class="div-block-normal div-padding-left">@lang('help.help_agreement.text.indate.1.4.1')</div>
                    <div class="div-block-normal div-padding-left">@lang('help.help_agreement.text.indate.1.4.2')
                    </div>
                    <div class="div-block-normal div-padding-left">@lang('help.help_agreement.text.indate.1.4.3')。</div>
                    <div class="div-block-normal ">@lang('help.help_agreement.text.indate.2.title')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.2.1')
                    </div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.2.2')
                    </div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.2.3')
                    </div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.2.4')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.title')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.desc')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.1')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.2')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.4')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.5')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.3.6')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.3.7')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.4.title')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.4.desc')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.5.title')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.5.1')
                    </div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.5.2')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.5.3')</div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.6.title')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.6.1')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.6.2')
                    </div>
                    <div class="div-block-normal">@lang('help.help_agreement.text.indate.7.title')</div>
                    <div class="div-block-normal">
                        @lang('help.help_agreement.text.indate.7.desc')
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
<link rel="stylesheet" type="text/css" href="/build/css/page/help/agreement.css">
@endsection
