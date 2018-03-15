<?php

?>
<div class="application">
    <div class="div-padding">@lang('refund.common.application_info.refund_id')&nbsp;:&nbsp;{{$data['refund_id']}}</div>
    <div class="div-padding">@lang('refund.common.application_info.add_time')&nbsp;:&nbsp;{{$data['add_time']}}</div>
    <div class="div-padding price">@lang('refund.common.application_info.refund_money')&nbsp;:&nbsp;<span>￥{{$data['refund_money']}}</span></div>
    <div class="div-padding">
        @lang('refund.common.application_info.reason')&nbsp;:
        @if($data['reason']==1)
        @lang('refund.common.select.one')
        @elseif($data['reason']==2)
        @lang('refund.common.select.two')
        @elseif($data['reason']==3)
        @lang('refund.common.select.three')
        @elseif($data['reason']==4)
        @lang('refund.common.select.four')
        @endif
    </div>
    <div class="div-padding">@lang('refund.common.application_info.refund_instructions')&nbsp;:&nbsp;{{$data['refund_reason']}}</div>
</div>
