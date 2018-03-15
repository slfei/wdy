@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-feedback">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_feedback.title')</div>
            <div class="content">
                <div class="row type">
                    <div class="col-xs-1">@lang('help.help_feedback.type')：</div>
                    <div class="col-xs-10">
                        <a href="javascript:void(0)"><span class="ico active" value="0"></span><span class="text">@lang('help.help_feedback.type_one')</span></a>
                        <a href="javascript:void(0)"><span class="ico" value="1"></span><span class="text">@lang('help.help_feedback.type_two')</span></a>
                    </div>
                </div>
                <div class="row div-block">
                    <div class="col-xs-1">@lang('help.help_feedback.phone')：</div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control phone" placeholder="@lang('help.help_feedback.phone_placeholder')"/>
                    </div>
                </div>
                <div class="row div-block">
                    <div class="col-xs-1">@lang('help.help_feedback.suggest')：</div>
                    <div class="col-xs-7">
                        <textarea rows="8" class="form-control suggest"  placeholder="@lang('help.help_feedback.suggest_placeholder')"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-9">
                        <a href="javascript:void(0)" class="submit">@lang('help.help_feedback.sure')</a>
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
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/feedback.css">
@endsection
@section('script')
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/help/feedback.js"></script>
@stop

