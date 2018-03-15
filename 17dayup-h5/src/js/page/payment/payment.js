import api from '../../api'
import common from '../../common'
$(function () {
	let i=0,
		T=null,
		time=5000;

	api.payment.payResult({order_id:order_id}).then((res)=>{
		if(res.order_status==1){
			$('.pay-type-0,.fall-wrap').hide()
			$('.pay-type-1,.success-wrap').show()
			clearInterval(T);
		}else{
			a();
		}
	})
	function a(){
		T =setInterval(()=>{
			i++;	
			api.payment.payResult({order_id:order_id}).then((res)=>{
				if(res.order_status==1){
					$('.pay-type-0,.fall-wrap').hide()
					$('.pay-type-1,.success-wrap').show()
					clearInterval(T);
				}else{
					if(i==2){
						$('.pay-type-0,.success-wrap').hide()
						$('.pay-type-1,.fall-wrap').show()
						clearInterval(T);
					}
				}
			})
		},time)
    }

    $('.js_pay').on('click',function () {
        var url = '/api/order/repayment?order_id=' + $(this).data('id');
        $.get(url).then(function (res) {
            if (res.status == 200) {
                    location.href = res.data.pay_url;
            } else {
                common.ui.topTips(res.msg);
            }
        });
    });
	
})
