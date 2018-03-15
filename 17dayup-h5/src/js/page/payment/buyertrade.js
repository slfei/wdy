import weui from 'weui.js'
import common from '../../common'
import api from '../../api'

var json = [];


couponJson.forEach(function(item,index){
        json.push({label:item.coupon_name, value:item.id})
});

json.push({label:'不使用优惠券', value:0});

function selectCoupon(){
    if(couponId){
        var loading = weui.loading('loading');
        api.post('/api/order/useCoupon',{
            course_id:courseId,
            id:couponId
        }).then(function(res){
            loading.hide();
            $('#name').text(name);
            $('#price').text('￥'+res.cur_price);
        }).catch(function(err){
            loading.hide()
            weui.topTips(err, {
                duration: 3000,
                className: "custom-classname",
                callback: function callback() {
                    console.log('close');
                }
            });
        })
    }else{
        $('#name').text(name);
        $('#price').text('￥'+price)
    }
};

/**
 * 选择优惠券
 */
$('.js_coupon').on('click',function(){
    weui.picker(json, {
        defaultValue: [couponId],
        className: 'custom-classname',
        onChange: function onChange(result) {
        },
        onConfirm: function onConfirm(result) {
            name = result[0].label;
            couponId = result[0].value;
            selectCoupon()
        },
        id: 'picker'
    });
});

/**
 * 提交
 */
$('.js_submit').on('click',function(e){
    e.preventDefault()
    var loading = weui.loading('loading');
    api.post('/api/course/payment',{
        course_id:courseId,
        coupon_id:couponId
    }).then(function(res){
      if(res.status == 909){
        var id = res.data.order_id;
        loading.hide()
        weui.dialog({
            title: '',
            content: '已存在该课程订单，生成课程新订单需要取消原有订单？',
            className: 'custom-classname',
            buttons: [{
                label: '取消原订单',
                type: 'default',
                onClick: function () { 
                    api.order.cancel(id).then(function(){
                        common.ui.topTips('成功取消订单');
                    })
                 }
            }, {
                label: '支付原订单',
                type: 'primary',
                onClick: function () {
                    var url = '/api/order/repayment?order_id=' + id;
                    $.get(url).then(function (res) {
                        if (res.status == 200) {
                                location.href = res.data.pay_url;
                        }
                    });
                }
            }]
        });
      }else{
        loading.hide();
        location.href = res.pay_url
      }
        
    }).catch(function(err){
        loading.hide()
        weui.topTips(err, {
            duration: 3000,
            className: "custom-classname",
            callback: function callback() {
                console.log('close');
            }
        });     
    })
});


selectCoupon()
