import api from '../../api';
import common from '../../common';



$(function(){
    var fun_type;

    $('.select_type a').click(function(){
        var index = $(this).index();
        fun_type = index;
        $(this).siblings().removeClass('active')
        $(this).addClass('active')
    })

  
    //提交反馈
    $('.feedback_btn').click(function(){

        if(fun_type === undefined){
            return common.ui.topTips('请选择问题类型')
        }

        var feedback = $('textarea').val();
        if(feedback.length < 10){
            return common.ui.topTips('至少十个字才能提交哦！')
        }
        // var feed_data = {
        //        type: fun_type,
        //        phone:'',
        //     suggest:$('textarea').val()
        // }

        api.user.feedback(fun_type, feedback).then(function(){
            common.toast('提交成功');
            setTimeout(()=>{
                location.href='/center'
            },1000)
        })


        // $.post('/api/help/feedback',feed_data,function(res){
            // if (res.status==200) {
                // alert('success')
            // }
            // else{
                // alert('error')
            // }
        // })

    })
    $('textarea')
        .on('focus',function(){
            $(".navbar").removeClass('fixed-header').css({'position':'relative','z-index':'10'});
            $(".my-feedback").removeClass('has-header')
        })
        .on('blur',function(){
            $(".navbar").addClass('fixed-header').removeAttr('style');
            $(".my-feedback").addClass('has-header')

        })
})
