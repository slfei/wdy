
$(function(){
    var orderinfo = {
        this_text:'',
        order_id: '',
        api_url: '',
        cancel_order:cancel_order
    };

    $('.all-status').click(function(){
        $('.status-list').fadeToggle(300);
    });

    $('.close-modal').click(function(){
        hidemodal()
    });
    $('.operate_btn').click(function(e){
        orderinfo.this_text = $(this).data('type');
        orderinfo.order_id = e.target.id.slice(3);

        switch (orderinfo.this_text) {
            case 'cancel':
               orderinfo.api_url = updateurl('cancelorder');
                break;
            case 'refund':
                orderinfo.api_url = updateurl('cancelrefund');
                break;
            case 'delete':
                orderinfo.api_url = updateurl('deleteorder');
                break;
        }
        orderinfo.cancel_order(orderinfo.this_text);
    });
    
    $('.sure-btn').click(function(){
        console.log(orderinfo.api_url)
        $.post(orderinfo.api_url, {order_id:orderinfo.order_id},function(res){
            console.log(res);
            if (res.status==200) {
                hidemodal()
                location.reload()
            }
            else{
                utils.toast(res.msg)
            }
        })
    });
    function cancel_order(text){
        $('.cancel-modal').show()
        if(window.LOCALE == 'zh_CN' && text == 'delete'){
            text = '删除';
        }
        if(window.LOCALE == 'zh_CN' && text == 'cancel'){
            text = '取消';
        }
        if(window.LOCALE == 'zh_CN' && text == 'refund'){
            text = '退款';
        }
        $('.mcan-title').text(text);
    }
    function updateurl(case_url){
        return '/api/center/'+ case_url;
    }
    function hidemodal(){
        $('.cancel-modal').hide()
    }
    //重新购买
    $('.re-buy').click(function(){
        var  courseId = $(this).attr('course_id');
        var url  = '/api/course/signup?courseid=' + courseId;

        $.get(url).then(function (res) {
           if(res.status == 200){
                if(res.data.type==1){  
                    location.href = '/course/registration?courseid=' + courseId;       
                }else{
                    location.href = '/course/confirm/'+ courseId                           
                }
           }else{
                utils.toast(res.msg);
           }
        });
    });

})

/**
 * 去支付
 */

$('.js_goPay').on('click',function () {
    var url = '/api/order/repayment?order_id=' + $(this).data('id');
    $.get(url).then(function (res) {
        if (res.status == 200) {
                location.href = res.data.pay_url;
        } else {
            utils.toast(res.msg);
        }
    });
});
