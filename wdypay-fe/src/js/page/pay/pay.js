/**
 * Created by Administrator on 2017/10/13.
 */
import { en,cn } from '../lang/lang';
if(lang == 'en'){
    window.Lang = en;
}else{
    window.Lang = cn;
}
import { countDown, toast, fnAjax } from '../public/public';
var payMent = 'alipay';
var timer = null;
var pollingTime = null;
/**
 * 支付倒计时
 */
if(time){
    timer = setInterval(function() {
        if(time == 0){
            clearInterval(timer)
        }else{
            time--;
            var text = countDown(time,'H')
            $('.pageTimer').text(text)
        }
    }, 1000);
};
/**
 * 支付方式切换
 */
$('.js_payTab').on('click',function(){
   var payType = $(this).data('type');
   clearInterval(pollingTime);
   if (payType == 'wechat') {
        payMent = 'wechat';
        $('.section-order .alipay').removeClass('alipayActive');
        $('.section-order .paypal').removeClass('paypalActive');
        $('.section-order .wx').addClass('wxActive');
        $('.js_buy').attr('href','javascript:void(0)');
        $('.js_buy').attr('target','_self');
    }else if(payType == 'paypal'){
        payMent = 'paypal';
        $('.section-order .paypal').addClass('paypalActive');
        $('.section-order .alipay').removeClass('alipayActive');
        $('.section-order .wx').removeClass('wxActive');
        $('.js_buy').attr('href',payUrl + '&payway=' + payMent);
        $('.js_buy').attr('target','_blanck');
    } else {
        payMent = 'alipay';
        $('.section-order .alipay').addClass('alipayActive');
        $('.section-order .wx').removeClass('wxActive');
        $('.section-order .paypal').removeClass('paypalActive');
        $('.js_buy').attr('href',payUrl + '&payway=' + payMent);
        $('.js_buy').attr('target','_blanck');
    }
});
/**
 * 支付
 */
$('.js_buy').click(function (e) {
   
    if(payMent == 'wechat'){
        e.preventDefault();
        clearInterval(pollingTime);
        fnAjax({
            url:'/api/cashier/pay',
            type:'POSt',
            data: {source:'web',payway:payMent,trade_no:orderId},
            done: function(res){
                if(res.status == 200){
                    $('#modal-code .code>img').attr('src', res.data.code_url);
                    $('a[href="#modal-code"]').click();
                }else{
                    toast(res.msg)
                }
            },
            fail: function(res){
                toast(res.msg)
            }
        });
        pollingTime = setInterval(polling, 1000);
    }else{
        $('a[href="#modal-pay-fail"]').click();
    }
});
/**
 * 订单状态查询
 */
$('.js_result').on('click',function(){
    polling();
});
/**
 * 订单状态查询方法
 */
function polling(){
    fnAjax({
        url: status,
        type:'POST',
        done: function(res){
            if(res.status == 200){
                if(payMent == 'alipay' || payMent == 'paypal'){
                    if(res.data.status == 0){
                        $('#modal-pay-fail .fail').removeClass('hide');
                    }else if(res.data.status == 2){
                        location.href = returnUrl
                    }else{
                        $('.js_back').click()
                    }
                }else{
                    if(res.data.status == 2){
                        clearInterval(pollingTime);
                        location.href = returnUrl
                    }else if(res.data.status == 0){
                       
                    }else{
                        clearInterval(pollingTime);
                        toast(Lang.fail||Lang.msg);
                    }
                }
           }else{
            clearInterval(pollingTime);
            toast(res.msg||Lang.msg);
           }
        },
        fail: function(res){
            clearInterval(pollingTime);
            toast(res.msg||Lang.msg)
        }
    });
};
