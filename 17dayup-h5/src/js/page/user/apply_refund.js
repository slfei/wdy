import common from '../../common';
import utils from '../../utils';
import api from '../../api';

$(function(){
    var select_reson;
    // $('textarea').keyup(function(){
    //     var content_num = $('.refund_text').val().length
    //     $('.rest-length').text(content_num);
    // });
    $(document).on('input propertychange','textarea',function(e){
        var content_num = $('textarea').val().length
        $('.rest-length').text(content_num);
    });

    $('.btn-footer').click(function(){
        var json = {
            order_id: utils.getQueryStringByName('order_id'),
            refund_reason: data.reasonId,
            refund_detail: $('.refund_text').val()
        };
        if($('.reason').hasClass('cur')){
            api.order.refund(json).then(function(){
                location.href = '/order/refundresult?order_id=' + orderId;
            })
        }else{
            common.ui.topTips("请选择退款原因");
        }
    })
    
    var data = {
        reasonId: 1
    }



    // @see https://github.com/Tencent/weui.js/blob/master/example/example.js
    $('.ui-picker').on("click", function(){
        var root = $(this);
        var options = root.data('options');
        common.ui.picker(options, data.reasonId).then(function(o){
            console.log(o);
            data.reasonId = o.value;
            root.find('.reason').html(o.label).addClass('cur');
        });
    })
})
