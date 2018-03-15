
import payment from '../features/payment'
import utils from '../../utils'



$(".pay_btn").on("click", function(){
    var orderId = utils.getQueryStringByName('order_id');    
    if($(".wechat-pay").prop("checked")){
        // 
        payment.wechat(orderId);
    }else{
        payment.alipay(orderId);
    }
})
$('.payment').on('click',function(){
	var $this=$(this);
	$this.find('input')[0].checked=true;
})
