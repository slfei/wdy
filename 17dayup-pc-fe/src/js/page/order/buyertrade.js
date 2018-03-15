var order_id = null;


$('.js_select').on('click',function(){
    $('.js_coupon').slideToggle();
    $('.ion-android-arrow-dropup').toggleClass('active')
});

function selectCoupon(){
    if(couponId){
        $('.js_submit').toggleClass('disable').prop('disabled',true);
        $.post('/api/order/useCoupon',{
            course_id:courseId,
            id:couponId
        }).then(function(res){
            if(res.status == 200){
                $('.data_name').val(name);
                $('.data_price').text(' ' + $i18n('public.unit')+ ' ' +res.data.cur_price);
                $('.data_discountprice').text( $i18n('order.save') +'：'+ $i18n('public.unit') +res.data.discount_price);
            }else{
                utils.toast(res.msg);
            }
            $('.js_submit').toggleClass('disable').prop('disabled',false);
        }).catch(function(err){
            $('.js_submit').toggleClass('disable').prop('disabled',false);
        })
    }else{
        $('.js_submit').prop('disabled',false);
        $('.data_name').val(name);
        $('.data_price').text(' '+$i18n('public.unit') + ' ' + price);
        $('.data_discountprice').text( $i18n('order.save') + '：'+ $i18n('public.unit') +' 0.00');
    };
};

$('.js_coupon li').on('click',function(){
    couponId = $(this).data('value');
    name = $(this).text();
    $(this).addClass('selected_active').siblings().removeClass('selected_active');
    selectCoupon();
});


/**
 * 提交
 */
$('.js_submit').on('click',function(){
    $.post('/api/course/payment',{
        course_id:courseId,
        coupon_id:couponId
    }).then(function(res){
        if(res.status == 909){
            order_id = res.data.order_id;
            $('.mask').show();
        }else{
            location.href = res.data.pay_url;
        }
    }).catch(function(err){
        console.log(err)
    })
});

$('.js_cancel').on('click', function(){
    $.post('/api/center/cancelorder',{
        order_id:order_id
    }).then(function(res){
        $('.mask').hide();
        utils.toast($i18n('center.order.cancel_success'));
    }).catch(function(err){
        console.log(err)
    })
});

$('.js_payit').on('click', function(){
    $.post('/api/order/repayment',{
        order_id:order_id
    }).then(function(res){
        if (res.status == 200) {
            location.href = res.data.pay_url;
        }
    }).catch(function(err){
        console.log(err)
    })
})

selectCoupon()
