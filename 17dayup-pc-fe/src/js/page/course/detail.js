/**
 * Created by Administrator on 2017/9/27.
 */
import './comment'



$("#tab>li").click(function () {
    $("#container>div").hide();
    $("#tab>li").removeClass('active');
    //$(this).addClass('active');
    $('#tab li[value="' + $(this).attr('value') + '"]').addClass('active');
    var num = $(this).val();
    $("#content" + num).show();
});
window.goto = function (id, type, fromType) {
    var path;
    if (type == "relevant") {
        path = '/course/' + id;
    } else if (type == 'institute') {
        path = (fromType == 2 ? '/institute/homepage/' : '/personal/homepage/');
        path += id;
    } else if (type == 'teacher') {
        path = '/teacher/courselist/' + id;
    }

    window.open(path)
};

$('.action .apply').click(function () {
    var url = '/api/course/signup?courseid=' + courseId;
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

window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 560) {
        $('.section-fix').css({display: 'flex'})
    } else {
        $('.section-fix').css({display: 'none'})
    }
};

/*收藏功能*/


$('.js_collection').on('click', function () {
    var type = $(this).toggleClass('collectionActive').hasClass('collectionActive');
    var id = $(this).data('id');
    var _this = this;
    var obj = {typeid: 1, objectid: id}
    if (type) {
        var url = "/api/favorite/addfavorite";
    } else {
        var url = "/api/favorite/delfavorite";
    }
    $.post(url, obj).then(function (res) {
        if (res.status == 200) {
            //utils.toast(res.msg);
            type ? utils.toast({text: $i18n('course.detail.favorSuccess'), position: 'mid-center', textAlign: "center"}) : utils.toast({
                text: $i18n('course.detail.cancelFavor'),
                position: 'mid-center',
                textAlign: "center"
            });
        } else {
            $(_this).toggleClass('collectionActive');
            utils.toast(res.msg);
        }
    }).catch(function (err) {
        $(_this).toggleClass('collectionActive')
    });

});

/**
 * 下载资料
 */
$('.js_download').on('click', function () {
    var courseid = $(this).data('courseid');
    var materialid = $(this).data('materialid');
    $.get('/api/course/material?course_id='+ courseid + '&material_id=' + materialid , function(res) {
        if(res.status == 200){
            location.href = res.data.url
        } else if (res.status == 100011) {
            utils.toast($i18n('course.detail.dowlondNot'));
        } else {
            utils.toast(res.msg);
        }
    });
});

/*获取初始状态*/
$.ajax({
    url:`/api/center/sign`,
    data: { course_id: courseId },
    method: 'POST',
    dataFilter: function(res) {
        return res;
    }
}).then(function (res) {
        if (res.status == 200) {
            $('.js_action .apply').addClass('hide');
            let data = res.data;
            if (data.is_sign == 1) {
                $('.js_action .apply').removeClass('hide');
            } else if (data.is_sign == 2) {
                $('.js_action .success').removeClass('hide')
            } else {
                $('.js_action .finish').removeClass('hide')
            }
        }
    });

$.ajax({
    method: 'POST',
    url: `/api/center/favorite`,
    data: {object_id: courseId},
    dataFilter: function(res){ return res;}
}).then(function (res) {
        if (res.status == 200) {
            let data = res.data;
            if (data == 1) {
                //收藏
                $('.js_collection').addClass('collectionActive');
            }
        }
    });

