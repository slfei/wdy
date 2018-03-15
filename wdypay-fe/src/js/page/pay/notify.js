import { fnAjax } from '../public/public';


setInterval(function(){
    fnAjax({
        url: status,
        type:'POST',
        done: function(res){
           if(res.status == 200){
                if(res.data.status == 2){
                    if(returnUrl){
                        location.href = returnUrl
                     }else{
                        location.href = "/cashier/result?trade_no=" + orderId
                     }
                }else{
                    location.href = "/cashier/result?trade_no=" + orderId
                }
           }else{
            location.href = "/cashier/result?trade_no=" + orderId
           }
        },
        fail: function(res){
            location.href= "/cashier/result?trade_no=" + orderId
        }
    })
},2000)
