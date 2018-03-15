@extends('pc.common')
@section('main')
    <div class="main-container clearfix process">
        <div class="section-header">
            @component('pc.components.refund.header', ['refundState' => 'process'])
            @endcomponent
        </div>
        <div class="section-content clearfix">
            <div class="refunc-type">@lang('refund.process.section_content.refunc_type')</div>
            <div class="prompting">@lang('refund.process.section_content.prompting_start')<span class="countdown">@lang('refund.process.section_content.prompting_in')</span>@lang('refund.process.section_content.prompting_end')</div>
            <div class="cancel">@lang('refund.process.section_content.cancel')&nbsp;:&nbsp;<a href="javascript:void(0)" class="js_cancelrefund">@lang('refund.process.section_content.cancelrefund')</a></div>
            <div class="line"></div>
            <div class="row">
                <div class="col-xs-6">
                    @component('pc.components.refund.application-form', ['data' => $tplData['data']['refund_info']])
                    @endcomponent
                </div>
                <div class="col-xs-5 col-xs-offset-1">
                     @component('pc.components.refund.course-detail', ['data' => $tplData['data']['order_info']])
                     @endcomponent
                </div>
            </div>
        </div>
    </div>
    <script>
        window.orderId = {!! json_encode($tplData['data']['order_info']['order_id']) !!}
        window.countDown = '{{strtotime($tplData['data']['refund_info']['add_time'])+3*24*60*60}}'
    </script>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/refund/process.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/refund/process.js"></script>
@stop
