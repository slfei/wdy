@extends('mobile.base')

@section('content')
<div style="padding-top:200px; text-align:center;">
  <img src="/build/img/pay/pay.gif" alt="" width='100'>
</div>

@stop @section('script')
<script>
        window.orderId = {!! json_encode($tplData['data']['order_id']) !!};
        window.status = "{!! urldecode($tplData['data']['get_status_url']) !!}";
        window.returnUrl = "{{$tplData['data']['return_url']}}"
</script>
<script src="/build/js/page/pay/notify.js"></script>
@stop
