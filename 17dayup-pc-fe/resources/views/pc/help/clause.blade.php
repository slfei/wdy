@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-clause">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">法律条款</div>
            <div class="content">
                <div class="institute div-block-max">
                    <div class="institute-title">1. 认证机构的课程保障</div>
                    <div class="institute-content div-block-normal">
                        认证机构的课程将提供更标准和优质的服务，如试学、课件可下载、配套习题练习、作业批改等，学生可在该机构获得完整学习计划和优秀老师指导。
                    </div>
                </div>
                <div class="buy div-block-max">
                    <div class="buy-title">2. 支付保障</div>
                    <div class="buy-content div-block-normal">
                        支付保障是唯通网为保障学员付费安全的官方服务，学员通过平台所支付的款项由唯通网平台保管，只有在课程结束后，款项才会划至机构账户，因此，学员可以通过唯通网放心购买课程
                    </div>
                </div>
                <div class="refund div-block-max">
                    <div class="refund-title">3. 课程退款服务保障说明</div>
                    <div class="refund-content div-block-normal">
                        依据课程对应的退款方式进行退款，每种退款方式说明如下：
                    </div>
                </div>
                <div class="refund-flow div-block-max">
                    <div class="refund-title">3. 课程退款服务保障说明</div>
                    <div class="refund-content">
                        <div class="div-block-max">
                            <div class="div-block-normal">3.1.1. 资源类：</div>
                            <div class="div-block-normal">(1)未点击观看—买家申请退款并写明原因，卖家后台同意退款</div>
                            <div class="div-block-normal">(2)点击观看后—原则上不予退款，特殊情况下与商家协商，后台申请退款，如无法确认，第三方介入\。</div>
                        </div>
                        <div class="div-block-max">
                            <div class="div-block-normal">3.1.2. 硬件类</div>
                            <div class="div-block-normal">(1) 未发货—买家申请退款并写明原因，买家后台同意退款</div>
                            <div class="div-block-normal">(2) 已发货—买家原因导致的退货，需买家承担退回的运费退回，商家原因导致的退货，需商家承担全部运费</div>
                            <div class="div-block-normal">(3) 已收货—买家原因导致的退货，需承担退回的运费。货物破损或有任何质量问题、与描述不符，申请退货，商家承担运费退回。所有的退款，如双方有任何异议，均可申请第三方介入判定。</div>
                            <div class="div-block-normal">(4) 所有的退款，如双方有任何异议，均可申请第三方介入判定。</div>
                        </div>

                    </div>
                </div>
                <div class="refund-way div-block-max">
                    3.2. 退款方式：退款方式采用后台支付宝划扣，原则上采用原路退还的原则
                </div>
                <div class="indate div-block-normal">
                    <div class="refund-title">3.3. 退款时效：</div>
                    <div class="refund-content">
                        <div class="div-block-normal">3.3.1 .资源类：商家后台48小时内同意或拒绝退款，逾期未操作视为自动同意退款。</div>
                        <div>
                            <div class="div-block-normal">3.3.2. 硬件类：</div>
                            <div class="div-block-normal">(1) 未发货：商家后台48小时内同意或拒绝退款，逾期未操作视为自动同意退款。</div>
                            <div class="div-block-normal">(2) 已发货：商家后台48小时内同意或拒绝退货，买家在后台填写退货快递/物流单号，14天内商家收到后同意/拒绝退款，若买家12天内未填写快递/物流单号，视为自动放弃退货，退货入口关闭;若商家12天未统一退款，视为自动同意买家退货，自动退款至买家账户上。</div>
                            <div class="div-block-normal">(3) 已确认收货：商家后台48小时内同意或拒绝退货，买家在后台填写退货快递/物流单号，14天内商家收到后同意/拒绝退款，若买家12天内未填写快递/物流单号，视为自动放弃退货，退货入口关闭;若商家12天未统一退款，视为自动同意买家退货，自动退款至买家账户上。</div>
                        </div>
                    </div>
                </div>
                <div class="div-block-normal">PS: 买家有两次申请退款的机会，商家拒绝两次，第三方自动介入。</div>
            </div>
        </div>
    </div>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/clause.css">
@endsection
