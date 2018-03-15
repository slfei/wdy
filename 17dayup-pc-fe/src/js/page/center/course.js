$(function() {

    $('.course_li').mouseover('.hover_course', function(e) {
        e.preventDefault()
        $('.hover_course').eq($(this).index()).find('.hover-mask').show()
    }).mouseout('.hover_course', function(e) {
         e.preventDefault()
        $('.hover_course').eq($(this).index()).find('.hover-mask').hide()
    })
    var delete_type = '';
    var delete_id ='';
    $('.delcourse').click(function(e) {
        $('.cancel-modal').show();
        $('.mcan-title').text($i18n('center.edit.moveFavor'));
        delete_type = e.target.id.slice(0, 6);
        delete_id = e.target.id.slice(7);
    });

    $('.js_removeCourse').on('click',function(e){
        $('.cancel-modal').show();
        $('.mcan-title').text($i18n('center.edit.moveCourse'));
        delete_type = e.target.id.slice(0, 6);
        delete_id = e.target.id.slice(7);
    });

    $(".sure-btn").click(function() {
        $('.cancel-modal').hide();
        if (delete_type == "course") {
            $.post('/api/center/delcourse', {
                id: delete_id
            }, function(data, status) {
                console.log(data, status);
                if (data.status == 200) {
                    utils.toast($i18n('public.success'));
                    location.reload()
                } else {
                    utils.toast($i18n('public.error'));
                }
            })
        } else {
            $.post('/api/center/delcollect', {
                id: delete_id
            }, function(data, status) {
                console.log(data, status);
                if (data.status == 200) {
                    utils.toast($i18n('public.success'));
                    location.reload()
                } else {
                    utils.toast($i18n('public.error'));
                }
            })
        }
    });

    $(".clear-btn").click(function() {
        $('.cancel-modal').hide()
    });
    $('.close-modal').click(function() {
        $('.cancel-modal').hide()
    });
    $('.go-href').click(function() {
        location.href = '/course/' + $(this).attr('course-id');
    })

    
});
