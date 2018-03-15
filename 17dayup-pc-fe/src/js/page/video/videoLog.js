/**
 * Created by huangzhongjian on 17/11/6.
 */

function log(data, url = '/api/report/videolog') {
    var img = new Image();
    var param = $.param(data);

    img.src = url + '?' + param;
    console.log(img.src);

    img.onload = img.onerror = function() {
        img = null;
    };
}
var map = {};
// 上报学习进度
function reportLearnProgress(courseId, sectionId) {
    var key = `${courseId}_${sectionId}`;
    if (map[key]) {
        return ;
    }
    console.log('progress');
    $.post('/api/course/speed', {
        course_id: courseId,
        section_id: sectionId
    });
    map[key] = 1;
}
function updateLately(courseId, sectionId){
    $.post('/api/course/lately ', {
        course_id: courseId,
        section_id: sectionId
    });
}
const _extend = $.extend;

export default function setUpVideoLog(player, courseInfo) {
    var timestamp;
    var logFrequency = 10 * 1000;

    // t5player 网络卡顿情况下 play事件不准
    player.on('play', function() {
       updateLately(courseInfo.course_id, courseInfo.section_id);
    });

    function ex(data) {
        return _extend(data, courseInfo);
    }

    player.on('time complete', function(e) {
        var now = +new Date();
        if (timestamp == 0) {
            timestamp = now;
        }
        if (now - timestamp > logFrequency) {
            log(ex({
                type: e.type,
                video_time: player.getPosition(),
                duration: now - timestamp
            }));
            timestamp = now;
        }
        if (player.getPosition() / player.getDuration() >= 0.8) {
            reportLearnProgress(courseInfo.course_id, courseInfo.section_id);
        }
    });


    player.on('pause buffer', function(e) {
        var now = +new Date();
        log(ex({
            type: e.type,
            video_time: player.getPosition(),
            duration: timestamp ? (now - timestamp) : 0
        }));
        timestamp = 0;
    });

    player.on('seeked', function(e) {
        if (timestamp == 0) return ;// 暂停后拖动进度，依赖
        var now = +new Date();
        log(ex({
            type: e.type,
            video_time: player.getPosition(),
            duration: now - timestamp
        }));
        timestamp = now;
    });

    $(window).on('beforeunload.player', function() {
        if (timestamp != 0) {
            var now = +new Date();
            log(ex({
                type: 'pageunload',
                video_time: player.getPosition(),
                duration: now - timestamp
            }));
        }
    });
}
