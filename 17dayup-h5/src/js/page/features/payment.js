import api from "../../api"
import common from "../../common"

// 支付函数
function payInsideWechat(option, sucCb){
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest', option,
        function(res){     
            // alert(JSON.stringify(res))
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                sucCb && sucCb()
            }     
            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
        }
    ); 
 }


export default {
    wechat(oid){
        if(isWechat){
            common.ui.loading.show()
            api.get("/api/order/wechatmppay?order_id=" + oid).then(function(data){
                common.ui.loading.hide()
                payInsideWechat({
                    appId: data.appId,
                    timeStamp: '' + data.timeStamp,
                    nonceStr: data.nonceStr,
                    package: data.package,
                    signType: data.signType,
                    paySign: data.paySign
                }, function(){
                    location.href = "/order/payresult?order_id=" + oid
                })
            }, function(err){
                common.ui.loading.hide()                
                alert(JSON.stringify(err));
            })
        }else{
            return location.href = "/order/wechatpay?order_id=" + oid            
        }
    },
    
    alipay(oid){
        return location.href = "/order/alipay?order_id=" + oid
    }
}
