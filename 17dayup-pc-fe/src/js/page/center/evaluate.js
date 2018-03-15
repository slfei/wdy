$(function(){
    var star_rank_num = $('.orange-star').length;
    const starText = {
        1: $i18n('public.common.low'),
        2: $i18n('public.common.in'),
        3: $i18n('public.common.in'),
        4: $i18n('public.common.good'),
        5: $i18n('public.common.good')
    };

    // 已经评论过的
    if (window.MY_COMMENT) {
        star_rank_num =  window.MY_COMMENT.star;
        var content_num = $('.comment_text').val().length;
        $('.rest-length').text(content_num);
    } else {
        $('.good-star').hover(function(){
            let star_i = $(this).index();
            setScore(star_i);
        }).click(function(e){
            let star_i = $(this).index();
            setScore(star_i);
            star_rank_num = star_i + 1;
        }).parent().on('mouseleave', function(){
            setScore(star_rank_num - 1);
        });
    }
    setScore(star_rank_num - 1);

    function setScore(i) {
        $('.good-star').each(function(index, item) {
            if (index <= i) {
                $(item).addClass('orange-star');
            } else {
                $(item).removeClass('orange-star');
            }
        });
        evaluate_text(starText[i + 1]);
    }

    $('textarea').on('input', function updateLength(){
        // console.log($('.comment_text').val().length)
        var content_num = $('.comment_text').val().length;
        $('.rest-length').text(content_num);
    });

    $('.release-btn a').click(function(){
        var commentText = $('.comment_text').val();
        var comment_data={
            //order_id:course_info.order_id,
            course_id:course_info.course_id,
            institute_id:course_info.institute_id,
            comment_content: commentText,
            star:$('.orange-star').length,
            star_rank:star_rank_num
        };
        if (commentText.length<10) {
            utils.toast($i18n('center.evaluate.commonMin'));
        }
        else{
        $.post('/api/center/applycomment',comment_data,function(res){
            if (res.status==200) {
                $('.myevaluate').hide();
                $('.evaluate_success').show();
                $('.suc-msg').show();
            }
            else{
                $('.fail_msg').show();
            }
        })
    }
    });
    function evaluate_text(texts){
        $('.color-blue').text(texts);
    }
    if(location.search.match(/[\?&]enter_type=([^&]*)/)[1]=='order'){
        $('.return a').attr('href', '/center/order').html($i18n('center.evaluate.toOrder'));
    }else{
        $('.return a').attr('href', `/course/${course_info.course_id}`).html($i18n('center.evaluate.toCourseDetail'));
    }
});
