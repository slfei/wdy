/**
 * Created by Administrator on 2017/10/24.
 */
// $('.cancel a').click(function(){
//     var json = {
//         order_id: orderId
//     };
//     var url = '/api/center/cancelrefund';
//     $.post(url, json).then(function(resp){
//         if(resp.status==200){
//             location.href = '/order/refundresult?order_id=' + orderId;
//         }else{
//             utils.toast(resp.msg || '操作失败，请重试');
//         }
        
//     });
// });

/* 取消退款 */

$('.js_cancelrefund').on('click',function(e){
     e.preventDefault();
     var json = {
            order_id: orderId
     };
     var url = '/api/center/cancelrefund';
     $.post(url, json).then(function(resp){
        console.log(resp)
            if(resp.status==200){
                location.href = '/order/refundresult?order_id=' + orderId;
            }else{
                utils.toast(resp.msg || $i18n('public.error'));
            }       
     });
});

/* 倒计时 */

function formatDuring(mss) {
    var days = parseInt(mss / (1000 * 60 * 60 * 24));
    var hours = parseInt((mss % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = parseInt((mss % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = (mss % (1000 * 60)) / 1000;
    return '0' + days + $i18n('refund.day') + hours + $i18n('refund.hour') + minutes + $i18n('refund.minute') + seconds + $i18n('refund.second');
}

if(countDown){
    timer = setInterval(function(args) {
        var nowTime = Date.parse(new Date());
        if(nowTime >= countDown*1000){
          clearInterval(timer)
          // location.href='order/refundresult?order_id=' + orderId;
        }else{
            var time = formatDuring(countDown*1000-nowTime)
           $('.countdown').text(time)
        }
    }, 1000)
}
