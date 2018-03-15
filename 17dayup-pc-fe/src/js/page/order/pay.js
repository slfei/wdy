/**
 * Created by Administrator on 2017/10/13.
 */
var payWxOrAlipay = '支付宝';
var orderId = Data.order_id;
var creatAt = Data.created_at*1000;
var nowTime = (new Date()).getTime();
var validTimeHours = 24;
var Milliseconds = creatAt + 24*60*60*1000 - nowTime;
var endHours = parseInt(Milliseconds/(60*60*1000));
var endMinutes = parseInt((Milliseconds%(60*60*1000))/(60*1000));
$('.pageTimer').html(`${endHours}小时${endMinutes}分钟`);

if(Milliseconds>0){
    $('.pageTimer').html(endHours + '小时' + endMinutes + '分钟');
    var pageTimer = setInterval(function(){
        if(endMinutes>0 || endHours>0){
            if(endMinutes==0 && endHours>0){
                endMinutes = 59;
                endHours--;
            }else{
                endMinutes--;
            }
            $('.pageTimer').html(`${endHours}小时${endMinutes}分钟`);
        }else{
            clearInterval(pageTimer);
            pageTimer = null;
            utils.toast('订单已失效')
        }
    },60000)
}
window.payWay = function (way) {
    if (way == 'wx') {
        payWxOrAlipay = '微信';
        $('.section-order .alipay').removeClass('alipayActive');
        $('.section-order .wx').addClass('wxActive');
        $('.buy').attr({'href': 'javascript:void(0)','target':''});
    } else {
        $('.buy').attr('href', '/api/order/createalipay?order_id=' + orderId);
        $('.buy').attr({'href': '/api/order/createalipay?order_id=' + orderId, 'target':'_blank'});
        payWxOrAlipay = '支付宝';
        $('.section-order .alipay').addClass('alipayActive');
        $('.section-order .wx').removeClass('wxActive');
    }
};
$('.section-warning .buy').click(function () {
    var url;
    if (payWxOrAlipay == '支付宝') {
        $('a[href="#modal-pay-fail"]').click();
    } else {
        url = '/api/order/wechatpay?order_id=' + orderId;
        $.get(url).then(function (resp) {
            $('#modal-code .code>img').attr('src', resp.data.code_url);
            $('a[href="#modal-code"]').click();
        }).then(function () {
            window.timer = setInterval(payResult, 1000)
        })
    }
});
var payResult = function () {
    var url = '/api/order/checkorderstatus?order_id=' + orderId;
    $.get(url).then(function (resp) {
        if (resp.status == 200) {
            if (resp.data.order_status == 1) {
                if(window.timer){
                    clearInterval(window.timer);
                    window.timer = null;
                }
                location.href = '/order/payresult?orderid=' + orderId;
            }else if(resp.data.order_status == 0 && payWxOrAlipay =='支付宝'){
                //$('#modal-pay-fail .description').hide()
                $('#modal-pay-fail .fail').removeClass('hide');
            }
        }
    })
};
$('.pay-result').click(payResult);



