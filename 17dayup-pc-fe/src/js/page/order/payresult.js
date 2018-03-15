/**
 * Created by Administrator on 2017/10/13.
 */

$('.js_pay').on('click',function () {
    var url = '/api/order/repayment?order_id=' + orderId;
    $.get(url).then(function (res) {
        if (res.status == 200) {
                location.href = res.data.pay_url;
        } else {
            utils.toast(res.msg);
        }
    });
});


function polling(){
    $.post('/api/order/checkorderstatus',{order_id:orderId}).then(function(res){
        if(res.data.order_status == 1){
            $('.result_loading').hide();
            $('.result_success').show();
        }else if(res.data.order_status == 0){
            $('.result_loading').hide();
            $('.result_err').show();
        }else{
            utils.toast(res.msg);
        }
        clearInterval(timer)
    }).catch(function(err){
        console.log(err)
    })
};

var timer = setInterval(polling,1000);
