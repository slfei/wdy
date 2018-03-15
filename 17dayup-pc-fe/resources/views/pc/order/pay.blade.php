@extends('pc.common')
@section('main')
    <div class="main-container pay">
         <div class="content-block section-order">
            <div class="title div-padding">订单支付</div>
            <div class="div-padding">订单号&nbsp;:&nbsp;{{$tplData['data']['order_id']}}</div>
            <div class="div-padding">订单商品&nbsp;:&nbsp;{{$tplData['data']['crouse_name']}}</div>
            <div class="div-padding">实付金额&nbsp;:&nbsp;<span class="price">￥{{$tplData['data']['money']}}</span></div>
            <div class="pay-way">支付方式&nbsp;:
                <a href="javascript:void(0)" onclick="payWay('alipay')" class="alipay alipayActive">
                </a>
                <a href="javascript:void(0)" onclick="payWay('wx')" class="wx">
                </a>
            </div>
        </div>
        <div class="content-block clearfix section-warning">
            <div class="pull-left left">
                <span class="ion-information-circled ico"></span>
                <span class="">请在<b class="pageTimer">0</b>内支付完成，如未完成订单将自动关闭，重新购买</span>
            </div>
            <div class="pull-right right">
                <div>
                    <span>应付金额&nbsp;:&nbsp;</span>
                    <span class="price">￥{{$tplData['data']['money']}}</span>
                </div>
                <a href="/api/order/createalipay?order_id={{$tplData['data']['order_id']}}" class="buy" target="_blank">立即支付</a>
            </div>
        </div>
        <a data-toggle="modal" href="#modal-code" style="display: none" value="保障触发"></a>
        <a data-toggle="modal" href="#modal-pay-fail" style="display: none" value="保障触发"></a>
        <div id="modal-code" class="modal fade">
            <div class="modal-dialog modal-width">
                <div class="modal-content">
                    <div class="clearfix form-group">
                        <span data-dismiss="modal" class="close ion-ios-close ico"></span>
                     </div>
                    <div class="form-group">实付金额&nbsp;:&nbsp; <span class="price">￥{{$tplData['data']['money']}}</span></div>
                    <div class="warning form-group">请在24小时内完成支付，否则可能导致购买失败</div>
                    <div class="code form-group">
                        <img src="" />
                        <div class="hint">
                            请使用<span>微信</span>扫描二维码完成支付
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-pay-fail" class="modal fade">
            <div class="modal-dialog modal-width">
                <div class="modal-content form-group">
                    <div class="clearfix ">
                        <span data-dismiss="modal" class="close ion-ios-close ico"></span>
                    </div>
                    <div class="description">请在新打开的页面完成支付</div>
                    <div class="fail hide">未支付成功，请在支付页面继续完成支付!</div>
                    <div class="action">
                        <a href="javascript:void(0)" class="back" data-dismiss="modal">重新选择支付方式</a>
                        <a href="javascript:void(0)" class="pay-result">支付完成</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.orderId = {!! json_encode($tplData['data']['order_id']) !!}
        window.Data = {!! json_encode($tplData['data']) !!};
    </script>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/order/pay.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/order/pay.js"></script>
@stop
