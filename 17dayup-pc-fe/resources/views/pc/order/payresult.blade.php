@extends('pc.common')
@section('main')
    <div class="main-container pay-result">
        <div class="result_loading">
               <div class="div-padding textc-center">
                    <div class="loading">
                        <img src="/build/img/course/loading.gif" alt="">
                        <span class="text">@lang('order.load')...</span>
                    </div>
                </div>
        </div>
        <div class="section-order result_success">
            <div class="">
                <div class="div-padding textc-center success">
                    <div class="">
                        <span class="pull-left ion-checkmark-circled ico">
                        </span><span class="pull-left text">@lang('order.success_pay')</span>
                    </div>
                </div>
                <div class="description">@lang('order.order_text.text1') <a href="/center/course">@lang('order.order_text.text2')</a>@lang('order.order_text.text3')<a href="/course/player/{{$tplData['data']['result']['course_id']}}">@lang('order.order_text.text4')</a>@lang('order.order_text.text5')</div>
            </div>
        </div>
        <div class="section-order result_err">
            <div class="">
                <div class="div-padding textc-center error">
                    <div class="">
                        <span class="pull-left ion-close-circled ico">
                        </span><span class="pull-left text">@lang('order.fail_pay')</span>
                    </div>
                </div>
                <div class="text-center back"><a href="/course/confirm/{{$tplData['data']['result']['course_id']}}">@lang('order.back')</a><a href="javascript:void(0);" class="js_pay" data-is="{{$tplData['data']['result']['course_id']}}">@lang('order.again_pay')</a></div>
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
    <link rel="stylesheet" type="text/css" href="/build/css/page/order/payresult.css">
@endsection
@section('script')
    <script>
        var orderId = {!!json_encode($tplData['data']['result']['order_id'])!!};  
    </script>
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/order/payresult.js"></script>
@stop
