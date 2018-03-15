/* 
 * @Author: chenzhaoyang
 * @Date:   2017-11-28 14:38:27
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-11-29 13:13:14
 */

'use strict';

$(function() {
    var count;
    $.post('/api/message/count', function(res) { // 获取未读信息 count
        if (res.status === 200) {
            count = res.data.unread_count;
            messageCount(count);
        }
    });

    $('.my-comment-reply').on('click', ".msg-noreaded", function(e) { // 点击标记已读
        var $this = $(this);
        var msgId = $this.attr("data-msg-id");
        $.post('/api/message/markread', {
            msg_id: msgId
        }, function(res) {
            if (res.status === 200) {
                $this.removeClass('msg-noreaded');
                messageCount(--count);
            }
        })
    });
    $("#btn-sign").click(function() { // 全部标记已读
        if (count != 0) {
            $.post('/api/message/markallread', function(res) {
                if (res.status === 200) {
                    window.location.reload();
                }
            })
        } else {
            utils.toast($i18n('center.notice.noNotice'));
        }
    });

    function messageCount(count) {
        if (count > 0) {
            $("#number-message").show().text(count);
            $('.g-header .js_msgNum').show().text(count);
        } else {
            $("#number-message").hide();
            $('.g-header .js_msgNum').hide();
        }
    }
});
