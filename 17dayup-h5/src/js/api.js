import { Promise } from './utils'
import common from './common';



function get(url, data){
    return new Promise(function(resolve, reject){
        return $.ajax({
            url: url,
            method: 'GET',
            data: data,
            xhrFields: {
                withCredentials: true
            }
        }).done(function(data){
            console.log(data)
            if(data.status == 200){
                resolve(data.data)         
            }else if(data.status==605){
                common.login()
            }else if(data.status==907){
                // 微信未授权，需要授权
                common.wechatLogin()
            }else if(data.status== 710){
                common.ui.loading.hide()
                common.toast(data.msg);
            }else{
                reject(data)                
            }
        })
        .fail(function(err){
            reject(err)
        })
    })
}


function post(url, data){
    return new Promise(function(resolve, reject){
        return $.ajax({
            url: url,
            method: 'POST',
            data: data,
            xhrFields: {
                withCredentials: true
            }
        }).done(function(data){
            if(data.status == 200){
                resolve(data.data)         
            }else if(data.status==605){
                common.login()
            }else if(data.status==907){
                // 微信未授权，需要授权
                common.wechatLogin()
            }else if(data.status == 909){
                resolve(data)
            }else{
                reject(data.msg)                
            }
        })
        .fail(function(err){
            reject(err)
        })
    })
}



function successCb(d){return d}
function failCb(err){ 
    common.ui.topTips(err);
    throw err;
}




const order = {
    // 取消订单
    cancel(oid){
        return post('/api/center/cancelorder', {
            order_id: oid
        }).then(successCb, failCb)
    },
    // 删除订单
    del(oid){
        return post("/api/center/deleteorder", {
            order_id: oid
        })
    },
    refund(data){
        return post("/api/center/applyrefund", data)
            .then(successCb, failCb)
    },
    cancelRefund(data){
        return post("/api/center/cancelrefund", data)
            .then(successCb, failCb)
    }
}

const user = {
    feedback(type, content){
        return post("/api/help/feedback", {

        })
    }
}
const payment = {
    payResult(data){
        return post("/api/order/checkorderstatus", data)
    }
}
const live={
    enterquit(data){
        return get("/api/live/enterquit", data)
    },
    heartbreak(data){
        return get("/api/live/heartbeat", data)
    }
    
}

export default {
    get,
    post,

    order,
    user,
    payment,

    live
}
