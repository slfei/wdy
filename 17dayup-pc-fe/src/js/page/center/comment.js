/* 
 * @Author: chenzhaoyang
 * @Date:   2017-11-29 13:18:06
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-11-29 13:21:10
 */

'use strict';
$(function() {
    var count;
    $.post('/api/message/count', function(res) { // 获取未读信息 count
        if (res.status === 200) {
            count = res.data.unread_count;
            if (count > 0) {
                $("#number-message").show().text(count);
            }
        }
    });
})
