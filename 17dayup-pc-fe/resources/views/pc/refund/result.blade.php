@extends('pc.common')
@section('main')
    <div class="main-container clearfix result">
        <div class="section-header">
            @component('pc.components.refund.header', ['refundState' => 'result'])
            @endcomponent
        </div>
        <div class="section-content clearfix">
            <div class="refunc-type">
                @if($tplData['data']['refund_result']['status']==2)
                   @lang('refund.result.section_content.refund_result.two.value')
                @elseif($tplData['data']['refund_result']['status']==3)
                   @lang('refund.result.section_content.refund_result.three.value')
                @elseif($tplData['data']['refund_result']['status']==4)
                    @lang('refund.result.section_content.refund_result.four.value')
                @endif
            </div>
            <div class="prompting">
                @if($tplData['data']['refund_result']['status']==2)
                    @lang('refund.result.section_content.refund_result.two.text')
                @elseif($tplData['data']['refund_result']['status']==3)
                    @lang('refund.result.section_content.refund_result.three.text')：{{$tplData['data']['refund_info']['last_operation_time']}}
                @elseif($tplData['data']['refund_result']['status']==4)
                    @lang('refund.result.section_content.refund_result.four.text')：{{$tplData['data']['refund_info']['last_operation_time']}}
                @endif
            </div>
            <div class="line"></div>
            <div class="row form">
                <div class="col-xs-6 ">
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
        window.countDown = null
    </script>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/refund/result.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/refund/process.js"></script>
@stop
