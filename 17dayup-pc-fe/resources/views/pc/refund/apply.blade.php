@extends('pc.common')
@section('main')
    <div class="main-container clearfix apply">
        <div class="section-header">
            @component('pc.components.refund.header', ['refundState' => 'apply'])
            @endcomponent
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-xs-6 reason">
                    <div class="row div-padding" style="line-height: 34px;">
                        <div class="col-xs-3">@lang('refund.apply.section_content.reason')&nbsp;:</div>
                        <div class="col-xs-9">
                            <select class="form-control">
                                <option>@lang('refund.apply.section_content.select.defult')</option>
                                <option value="1">@lang('refund.apply.section_content.select.one')</option>
                                <option value="2">@lang('refund.apply.section_content.select.two')</option>
                                <option value="3">@lang('refund.apply.section_content.select.three')</option>
                                <option value="4">@lang('refund.apply.section_content.select.four')</option>
                            </select>
                        </div>
                    </div>
                    <div class="row div-padding">
                        <div class="col-xs-3">@lang('refund.apply.section_content.refund_amount')&nbsp;:</div>
                        <div class="col-xs-9 price">
                            @lang('refund.common.money_unit'){{$tplData['data']['cur_price']}}
                        </div>
                    </div>
                    <div class="row div-padding instruction">
                        <div class="col-xs-3">@lang('refund.apply.section_content.refund_instructions')&nbsp;:</div>
                        <div class="col-xs-9">
                            <textarea rows="3" class="form-control" placeholder="@lang('refund.apply.section_content.placeholder')" maxlength="200"></textarea>
                        </div>
                    </div>
                    <div class="row div-padding">
                        <!--<div class="col-xs-2"></div>-->
                        <div class="col-xs-offset-3 col-xs-10 action">
                            <a href="javascript:void(0)" class="ok">@lang('refund.common.sure')</a>
                            <a href="/center/order" class="cancel">@lang('refund.common.cancel')</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-xs-offset-1 apply_right">
                     @component('pc.components.refund.course-detail', ['data' => $tplData['data']])
                     @endcomponent
                </div>
            </div>
        </div>
    </div>
    <script>
        window.orderId = {!! json_encode($tplData['data']['order_id']) !!}
    </script>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/refund/apply.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/refund/apply.js"></script>
@stop
