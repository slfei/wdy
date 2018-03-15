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
    $.post('/api/course/speed', {
        course_id: courseId,
        section_id: sectionId
    });
    map[key] = 1;
}

function reportLatelyPlay(courseId, sectionId) {
    var key = `lately_${courseId}_${sectionId}`;
    if (map[key]) {
        return ;
    }
    $.post('/api/course/lately ', {
        course_id: courseId,
        section_id: sectionId
    });
    map[key] = 1;
}

const _extend = $.extend;
let destroyLastLog;
export default function setUpVideoLog(player, courseInfo) {

    if(destroyLastLog) {
        destroyLastLog();
        destroyLastLog = null;
    }
    var timestamp;
    var logFrequency = 10 * 1000;

    function ex(data) {
        return _extend(data, courseInfo);
    }

    player.on('playing', onPlaying);
    player.on('timeupdate', timeUpdate);
    player.on('ended', timeUpdate);

    player.on('pause', pause);
    player.on('waiting', pause);

    player.on('seeked', seeked);


    function onPlaying () {
        reportLatelyPlay(courseInfo.course_id, courseInfo.section_id);

    }

    function timeUpdate(e) {
        var now = +new Date();
        if (timestamp == 0) {
            timestamp = now;
        }
        if (now - timestamp > logFrequency) {
            log(ex({
                type: e.type,
                video_time: player.currentTime(),
                duration: now - timestamp
            }));
            timestamp = now;
        }
        if (player.currentTime() / player.duration() >= 0.8) {
            reportLearnProgress(courseInfo.course_id, courseInfo.section_id);
        }
    }

    function pause(e) {
        var now = +new Date();
        log(ex({
            type: e.type,
            video_time: player.currentTime(),
            duration: timestamp ? (now - timestamp) : 0
        }));
        timestamp = 0;
    }

    function seeked(e) {
        if (timestamp == 0) return ;// 暂停后拖动进度，依赖
        var now = +new Date();
        log(ex({
            type: e.type,
            video_time: player.currentTime(),
            duration: now - timestamp
        }));
        timestamp = now;
    }

    $(window).off('.beforeunload.player').on('beforeunload.player', function() {
        if (timestamp != 0) {
            var now = +new Date();
            log(ex({
                type: 'pageunload',
                video_time: player.currentTime(),
                duration: now - timestamp
            }));
        }
    });

    return destroyLastLog = function destroy() {
        player.off('playing', onPlaying);
        player.off('timeupdate', timeUpdate);
        player.off('ended', timeUpdate);
        player.off('pause', pause);
        player.off('waiting', pause);
        player.off('seeked', seeked);
    }

}
