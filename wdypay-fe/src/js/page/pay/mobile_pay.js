import { fnAjax } from '../public/public';

var payMent = 'wechat';

// 支付函数
function payInsideWechat(option, sucCb){
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest', option,
        function(res){     
            //alert(JSON.stringify(res))
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                sucCb && sucCb()
            }     
            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
        }
    ); 
 };


 function wechat(){
    if(isWechat){
        fnAjax({
            url:'/api/cashier/pay',
            type: 'POST',
            data: {source:'wechath5',payway:'wechat',trade_no:orderId},
            done: function(res){
                if(res.status == 200){
                    var data = res.data;
                    payInsideWechat({
                        appId: data.appId,
                        timeStamp: '' + data.timeStamp,
                        nonceStr: data.nonceStr,
                        package: data.package,
                        signType: data.signType,
                        paySign: data.paySign
                    }, function(){
                        location.href = "/notify/payresult?trade_no=" + orderId
                    })
                }else{
                    location.href = "/notify/payresult?trade_no=" + orderId
                }
            },
            fail:function(err){
                console.log(err)
            }
        });
        
    }else{
        location.href = "/api/cashier/pay?source=h5&payway=wechat&trade_no=" + orderId;            
    }
 };

 function alipay(){
        location.href = "/api/cashier/pay?source=h5&payway=alipay&trade_no=" + orderId;
 };

 function paypal(){
    location.href = "/api/cashier/pay?source=h5&payway=paypal&trade_no=" + orderId;
};


/**
 * 支付方式切换
 */
$('.js_checkTab').on('click',function(){
  payMent = $(this).data('type');
  $(this).addClass('ion-checkmark-circled').removeClass('ion-ios-circle-outline');
  $(this).closest('.rows').siblings().find('i').removeClass('ion-checkmark-circled').addClass('ion-ios-circle-outline');
});

/**
 * 支付
 */
$('.js_buy').click(function () {
    if(payMent == 'wechat'){
        wechat();
    }else if(payMent == 'paypal'){
        paypal();
    }else{
        alipay();
    }
});


