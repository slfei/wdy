/**
 * Created by Administrator on 2017/10/24.
 */
$('.action .ok').click(function(){
    var json = {
        order_id: orderId,
        refund_reason: $('.reason select').val(),
        refund_detail: $('.instruction textarea').val()
    };

    var url = '/api/center/applyrefund';
    $.post(url, json).then(function(resp){
        if(resp.status==200){
            location.href = '/order/refundprocess?order_id=' + orderId;
        }else{
            utils.toast(resp.msg || $i18n('public.error'));
        }
        
    });
});
