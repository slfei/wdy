import common from '../../common'
import api from '../../api'
import "../features/infinite_scroll"

console.log("order ...");


$(function(){
    var orderinfo = {
        this_text:'',
        order_id: '',
        api_url: ''
    }

    $('.cancel_order').click(function(e){
        orderinfo.this_text = $(this).text();
        orderinfo.order_id = e.target.id.slice(6);
        console.log(orderinfo.order_id)
        switch (orderinfo.this_text) {
            case '取消订单':
               orderinfo.api_url = updateurl('cancelorder');
                break;
            case '取消退款':
                orderinfo.api_url = updateurl('cancelrefund');
                break;
            case '删除订单':
                orderinfo.api_url = updateurl('deleteorder');
                break;
        }
        orderinfo.cancel_order(orderinfo.this_text);
    })


    $(".js-order-cancel").on("click", function(){
        var orderId = $(this).data('order-id');

        common.confirm('取消订单', '您确定要取消订单吗？').then(function(){
            api.order.cancel(orderId).then(function(){
                console.log('取消订单成功');
                location.href = location.href;
            })
        });
    })

    $(".js-order-del").on("click", function(){
        var orderId = $(this).data('order-id');

        common.confirm('删除订单', '您确定要删除订单吗？').then(function(){
            api.order.del(orderId).then(function(){
                location.href = location.href
            })
        })
    })
    $(".js-order-refund").on("click", function(){
        var orderId = $(this).data('order-id');
        common.confirm('取消退款', '您确定要取消退款吗？').then(function(){
            api.order.cancelRefund({order_id:orderId}).then(function(){
                console.log('取消退款成功');
                location.href = location.href;
            })
        });
    });

    $('.status_nav').on('click','a',function(){
        var $this=$(this),
            $url=$this.data('url');
        history.replaceState({}, '订单', $url)
        location.reload();
    })
    $('.js-backward').on('click',function(){
        location.href='/center'
    });

    /**
     * 去支付
     */
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

    /**
     * 再次购买
     */
    $('.aginBuy').on('click',function () {
        var courseId = $(this).data('id');
        var url = '/api/course/signup?courseid=' + courseId;
        $.get(url).then(function (res) {
            if (res.status == 200) {
                location.href = '/course/confirm/'+ courseId;
            } else {
                common.ui.topTips(res.msg);
            }
        });
    });
})
