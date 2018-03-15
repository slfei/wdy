import common from '../../common';
$(function(){
    var this_ = this;
    this_.star_rank_num =3;
    $(document).on('input propertychange','textarea',function(e){
        var content_num = $('textarea').val().length
        $('.rest-length').text(content_num);
    })

    // $('textarea').keyup(function(){
    //     var content_num = $('textarea').val().length
    //     $('.rest-length').text(content_num);
    // });

    $('.comment_btn').click(function(){
        var comment_data={
            course_id:course_info.course_id,
            institute_id:course_info.institute_id,
            comment_content:$('textarea').val(),
            star:$('.active').length,
            star_rank:this_.star_rank_num
        }
        if($('textarea').val().length<10){
            return common.ui.topTips('至少十个字才能提交哦！')
        }
        
        $.post('/api/center/applycomment',comment_data,function(res){
            if (res.status==200) {
                location.href='/center/order'
            }
            else{
                common.ui.topTips(res.msg);
            }
        })
    })
    $('.score i').click(function(){
        if(!$(this).parent('span').hasClass('cur')){
            var $this=$(this),
                no = $this.index();
            if($this.hasClass('active')){
                $this.nextAll().removeClass('active').addClass('gray')  
            }else{
                $this.addClass('active').removeClass('gray')
                $this.prevAll().addClass('active').removeClass('gray')
            }
            var star_length = $('.orange-star').length;
            switch (no+1) {
                case 1:
                    evaluate_text('差评');
                    this_.star_rank_num = 1;
                    break;
                case 2:
                    evaluate_text('中评');
                    this_.star_rank_num = 2;
                    break;
                case 3:
                    evaluate_text('中评');
                    this_.star_rank_num = 2;
                    break;
                case 4:
                    evaluate_text('好评');
                    this_.star_rank_num = 3;
                    break;
                case 5:
                    evaluate_text('好评');
                    this_.star_rank_num = 3;
                    break;
            } 
        }                   
    })

    function evaluate_text(texts){
        $('.star_text').text(texts);
    }
    $('textarea')
        .on('focus',function(){
            $(".navbar").removeClass('fixed-header').css({'position':'relative','z-index':'10'});
            $(".my-comment").removeClass('has-header')
        })
        .on('blur',function(){
            $(".navbar").addClass('fixed-header').removeAttr('style');
            $(".my-comment").addClass('has-header')

        })
})
