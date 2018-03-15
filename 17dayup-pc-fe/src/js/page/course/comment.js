
/*分页*/
var page = {
    size: 20,
    at: 1,
    total: 0,
    maxPage: 0,
    nowPage: 1,
    callbackState: true,
    scrollTopSpeed: 500,
    scrollTop: '',
    callbackPost: ''
};
var setPage = function () {
    page.maxPage = Math.ceil(page.total / page.size);
    //控制分页显示隐藏
    if (!page.total) {
        $('.pagination').addClass('hide');
        return;
    } else {
        $('.pagination').removeClass('hide');
    }

    $('.pagination .number').each(function (i, ele) {
        /*初始化内容*/
        $(ele).find('a').html(i + 1);
        $('.pagination .active').removeClass('active');
        /*增加激活class*/
        /*if(i==0){$(ele).addClass('active');}*/
        /*控制正常显示页数*/
        if ($(ele).find('a').html() > page.maxPage) {
            $(ele).addClass('hide');
        } else {
            $(ele).removeClass('hide');
        }
    });
    /*初始化内容*/
    $($('.pagination .number')[0]).addClass('active');
    /*控制上一页隐藏，下一页是否出现*/
    $('.pagination .lt').addClass('hide');
    if (page.maxPage == 1) {
        $('.pagination .gt').addClass('hide');
    } else {
        $('.pagination .gt').removeClass('hide');
    }
};
var init = function (wtPage) {
    if (wtPage) {
        page = $.extend({}, page, wtPage);
    }
    setPage();
};
//数字调用
$('.pagination .number').click(function () {
    var self = this;
    var nowPage = $(this).find('a').html();
    /*如果点击当前页,退出*/
    if (nowPage == page.nowPage) {
        return;
    } else {
        page.nowPage = nowPage
    }
    var callback = function () {
        if (!page.callbackState) {
            page.callbackState = true;
            return;
        }
        $('.pagination').find('.active').removeClass('active');
        $(self).addClass('active');
        /*控制上一页显示隐藏*/
        if (nowPage != 1) {
            $('.pagination .lt').removeClass('hide');
        } else if (nowPage == 1) {
            $('.pagination .lt').addClass('hide');
        }
        /*控制下一页显示隐藏*/
        if (nowPage != page.maxPage) {
            $('.pagination .gt').removeClass('hide');
        } else if (nowPage == page.maxPage) {
            $('.pagination .gt').addClass('hide');
        }
        /*点击页数逻辑*/
        if ($(self).find('[data-i="first"]').length) {
            if (nowPage == 1) {
                return;
            } else if (nowPage == 2) {
                $('.pagination .number a').each(function (i, ele) {
                    $(ele).html(parseInt($(ele).html()) - 1);
                    $('.pagination').find('.active').removeClass('active');
                    $(self).next().addClass('active');
                })
            } else {
                $('.pagination .number a').each(function (i, ele) {
                    $(ele).html(parseInt($(ele).html()) - 2);
                    $('.pagination').find('.active').removeClass('active');
                    $(self).next().next().addClass('active');
                })
            }
        } else if ($(self).find('[data-i="last"]').length) {
            if (nowPage == page.maxPage) {
                return;
            } else if (nowPage == page.maxPage - 1) {
                $('.pagination .number a').each(function (i, ele) {
                    $(ele).html(parseInt($(ele).html()) + 1);
                    $('.pagination').find('.active').removeClass('active');
                    $(self).prev().addClass('active');
                })
            } else {
                $('.pagination .number a').each(function (i, ele) {
                    $(ele).html(parseInt(parseInt($(ele).html())) + 2);
                    $('.pagination').find('.active').removeClass('active');
                    $(self).prev().prev().addClass('active');
                })
            }
        }
    };
    if (page.callbackPost) {
        page.callbackPost().then(callback).then(function () {
            if (page.scrollTop != '') {
                $('html, body').animate({
                    scrollTop: page.scrollTop
                }, page.scrollTopSpeed);
            }
        });
    }
});

//上一页
$('.pagination .lt').click(function () {
    page.nowPage--;
    var callback = function () {
        if (!page.callbackState) {
            page.callbackState = true;
            return;
        }
        $('.pagination .gt').removeClass('hide');
        if ($($('.pagination .number a')[0]).html() == 1) {
            $('.pagination .active').removeClass('active').prev().addClass('active');
        } else {
            $('.pagination .number a').each(function (i, ele) {
                $(ele).html(parseInt($(ele).html()) - 1);
            });
            if ($($('.pagination .number a')[0]).html() == 2) {
                $('.pagination .lt').addClass('hide');
            }
        }
        if ($('.pagination .active').find('a').html() == 1) {
            $('.pagination .lt').addClass('hide');
        }
    };
    //滑动到位置
    page.callbackPost && page.callbackPost().then(callback).then(function () {
        if (page.scrollTop != '') {
            $('html, body').animate({
                scrollTop: page.scrollTop
            }, page.scrollTopSpeed);
        }
    });
});

//下一页
$('.pagination .gt').click(function () {
    page.nowPage++;
    var callback = function () {
        if (!page.callbackState) {
            page.callbackState = true;
            return;
        }
        $('.pagination .lt').removeClass('hide');
        if ($($('.pagination .number a')[$('.pagination .number:visible').length - 1]).html() == page.maxPage) {
            $('.pagination .active').removeClass('active').next().addClass('active');
        } else {
            $('.pagination .number a').each(function (i, ele) {
                $(ele).html(parseInt($(ele).html()) + 1);
            });
            if ($($('.pagination .number a')[0]).html() == page.maxPage - 1) {
                $('.pagination .gt').addClass('hide');
            }
        }
        if ($('.pagination .active').find('a').html() == page.maxPage) {
            $('.pagination .gt').addClass('hide');
        }
    };
    page.callbackPost && page.callbackPost().then(callback).then(function () {
        if (page.scrollTop != '') {
            $('html, body').animate({
                scrollTop: page.scrollTop
            }, page.scrollTopSpeed);
        }
    });
});

$("#content3 .witchComment").click(function () {
    var self = this;
    var val = self.value;
    commentPost("initPage", val).then(function () {
        /*切换状态*/

        $("#content3 .witchComment .active").attr('class', 'ion-circle-outline');
        $(self).find('.ion-circle-outline').attr('class', 'ion-circle-filled active');
        /*重置分页*/
        switch (val) {
            case 0:
                init({total: pageTotal.comment_num, nowPage: 1})
                break;
            case 3:
                init({total: pageTotal.good_comment_num, nowPage: 1})
                break;
            case 2:
                init({total: pageTotal.in_comment_num, nowPage: 1})
                break;
            case 1:
                init({total: pageTotal.low_comment_num, nowPage: 1})
                break;
        }
    });
});

var safety = function (str) {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/&/g, "&amp;");
    s = s.replace(/</g, "&lt;");
    s = s.replace(/>/g, "&gt;");
    s = s.replace(/ /g, "&nbsp;");
    s = s.replace(/\'/g, "&#39;");
    s = s.replace(/\"/g, "&quot;");
    return s;
};
function commentPost(init, val) {
    var json = {
        type: 1,
        rank: val || val==0 ? val :$('.witchComment .active').parent().attr('value'),
        object_id: courseId,
        page_num: init ? 1 : page.nowPage
    };
    var def = $.Deferred();
    $.post('/api/comment/list', json).then(function (resp) {
        if (resp.status == 200) {
            $('.tab-content .list-comment').empty();
            //触发promise
            var commentList = resp.data.comment_list;
            var commentNum = resp.data.num;
            if (commentList.length > 0) {
                $('.nocomment').addClass('hide');
                commentList.forEach(function (ele) {
                    safety(ele.text_content);
                    !Array.isArray(ele.answer) && safety(ele.answer.text);
                });
                var bat = baidu.template;
                var html = bat('t:_1234-abcd-1', resp.data);
                $('.tab-content .list-comment').html(html);
            } else {
                $('.nocomment').removeClass('hide')
            }
            def.resolve(commentNum);
        } else {
            page.callbackState = false;
            utils.toast(resp.msg || $i18n('public.error'));
        }
    });
    return def.promise();
}
var pageTotal = {};
var pageInit = function () {
    commentPost("initPage")
        .then(function (comment) {
            pageTotal = $.extend({}, comment);
            $('.tab .all ').html(`${$i18n('public.common.all')} ${comment.comment_num}`);
            $('.tab .good ').html(`${$i18n('public.common.good')} ${comment.good_comment_num}`);
            $('.tab .in ').html(`${$i18n('public.common.in')} ${comment.in_comment_num}`);
            $('.tab .low ').html(`${$i18n('public.common.low')} ${comment.low_comment_num}`);
            $('#content3').removeClass('hide');
        })
        .then(function () {
            /*初始化分页*/
            init({
                total: pageTotal.comment_num,
                scrollTop: 550,
                scrollTopSpeed: 100,
                callbackPost: commentPost
            })
        });
};
pageInit();

/*
export default {
    init,
    page
}*/
