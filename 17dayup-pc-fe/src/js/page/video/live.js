import im from "./im"


function getEnterRoomConf(courseId, sectionId) {
    return $.ajax({
        url: '/api/live/enterquit',
        data: {
            course_id: courseId,
            section_id: sectionId,
            op_type: 1
        }
    }).then(function (res) {
        if (res.status === 200) {
            return res.data;
        } else if (res.status === 605 || res.status === 709) {
            showTip('pay-tip');
            throw res.msg;
        } else {
            throw res.msg;
        }
    })
}

function getLiveStatus() {
    return $.ajax({
        url: '/api/course/livestatus',
        data: {
            section_id: __sid__
        }
    }).then(function (res) {
        if (res.status === 200) {
            return res.data;
        }
    })
}


var streamUrl;
window.ownerId = '';
var lastType = '';

function initPlayer(type) {
    if (type) {
        lastType = type;
    } else {
        type = lastType;
    }
    hideTip("main-tip");
    // var url = streamUrl[type];
    var url = streamUrl[type];
    // 
    // streamUrl['main']
    if (!url) {
        return console.log('can not find stream type', type)
    }
    if (!flashChecker()) {
        return console.log('flash未开启')
    }
    try {
        window.player && window.player.destroy();
    } catch (e) {

    }

    var container = $('.live-player-wrapper');
    window.player = new TcPlayer('live-player', {
        live: true,
        "m3u8": url['m3u8'],
        "flv": url['flv'], //增加了一个flv的播放地址，用于PC平台的播放 请替换成实际可用的播放地址
        rtmp: url['rtmp'],
        flash: true,
        flashUrl: '/build/lib/txCloud/QCPlayer.swf',
        "autoplay": true, //iOS下safari浏览器，以及大部分移动端浏览器是不开放视频自动播放这个能力的
        // "coverpic" : "http://www.test.com/myimage.jpg",
        "width": container.width(), //视频的显示宽度，请尽量使用视频分辨率宽度
        "height": container.height(), //视频的显示高度，请尽量使用视频分辨率高度,
        "listener": function (msg) {
            switch (msg.type) {
                case 'timeupdate':
                    // console.log(msg.timeStamp / 1000);
                    // TODO add played time
                    break;
                case 'ended':
                    initPlayer();
                    // stopPlayer("老师正在调试，请稍后！")
                    // showTip("main-tip");
                    break;
            }
        }
    });

    if (/firefox\/(\d+[\d.]*)/i.test(navigator.userAgent)) {
        fixFirefox();
    }
}


function stopPlayer(text) {
    text = text || $i18n('video.text1');
    // window.player && window.player.pause();
    $(".main-tip").find(".title").html(text);
    showTip("main-tip");
    try {
        window.player && window.player.destroy();
    } catch (e) {

    }
}

function continuePlayer() {
    hideTip("main-tip");
    // window.player && window.player.play();
    initPlayer();
}

window.initPlayer = initPlayer;

$(window).on('resize.player', function () {
    var $container = $('.live-player-wrapper');
    var cW = $container.width();
    var cH = $container.height();
    console.log(cW, cH);
    // fix player request fullscreen $container.height is 0
    if (!cW || !cH) return;

    $('.vcp-player').height(cH);
    $('.vcp-player').find('video').height(cH);
});


function _renderCountDown(time, cb) {
    var now = new Date() - 0;
    var duration = time - now;

    if (duration > 0) {
        var day = Math.floor(duration / (24 * 60 * 60 * 1000));

        var hours = Math.floor(duration % (24 * 60 * 60 * 1000) / (60 * 60 * 1000));

        var minutes = Math.floor(duration % (60 * 60 * 1000) / (60 * 1000));

        var seconds = Math.floor(duration % (60 * 1000) / 1000);

        $(".remain-time").text($i18n('refund.have') + day + $i18n('refund.day') + hours + $i18n('refund.hour') + minutes + $i18n('refund.minute') + seconds + $i18n('refund.second'));
        if (!$(".pay-tip").is(":visible")) {
            showTip("not-start-tip");
            $(".chat-input-wrapper").addClass("disabled");
        }
    } 
        // if ((endTime - now) < 0) {
        //     // 直播已经结束
        //     stopPlayer("直播课程已结束！");
        // } else {
        //     hideTip("not-start-tip");
        //     $(".chat-input-wrapper").removeClass("disabled");
        //     cb && cb()
        // }
        // console.log(endTime - now)
    // 前半小时轮询直播状态
    // if(duration < 30 * 60 * 1000){

    _renderCountDown._tid = setTimeout(function () {
        _renderCountDown(time, cb)
    }, 1000);


    if(!_renderCountDown._count || _renderCountDown._count >= 5 ){
        _renderCountDown._count = 1        
        getLiveStatus().then(function (data) {
            if (data.live_status == 1) {
                clearTimeout(_renderCountDown._tid);
                hideTip("not-start-tip");
                $(".chat-input-wrapper").removeClass("disabled");
                cb && cb();
            } else if(data.live_status == 4){
                clearTimeout(_renderCountDown._tid);
                hideTip("not-start-tip");
                stopPlayer($i18n('video.text2'))
            }
        })

    }else{
        _renderCountDown._count++;
    }

}


function checkStartTime(cb) {
    var startTimeStamp = $("#live-start-time").data("time") * 1000;
    var endTimeStamp = $("#live-start-time").data("end-time") * 1000;

    _renderCountDown(startTimeStamp, cb)
}


function _init(cid, sid) {
    var streamTypeMap = {
        1: 'aux',
        2: 'main'
    };

    getEnterRoomConf(cid, sid).then(function (data) {
        // console.log(data);
        streamUrl = data.ilvb_stream_url;
        ownerId = data.owner_identifier;
        initPlayer(streamTypeMap[data.stream_type] || 'main');
        im.init(data);
        im.renderUserList(cid, sid);
        im.sendHeartBeat(cid, sid);
    }, function (err) {
        console.log(err);
    })

    initTabSwitcher()
}


function init(cid, sid) {
    window.__cid__ = cid;
    window.__sid__ = sid;


    initChapterSelector(sid)
    

    checkStartTime(function () {
        _init(cid, sid)
    });
}


function initTabSwitcher() {
    var tabs = $('.tab-header');
    var content = $(".chat-room-content").find(".content")
    tabs.on("click", function () {
        var self = $(this);
        var index = tabs.index(self);
        tabs.removeClass("active")
        tabs.eq(index).addClass("active")
        content.hide();
        content.eq(index).show();
    });
}


function initChapterSelector(sid) {
    console.log(sid);
    $('.chapter-item').filter('[data-id="' + sid + '"]').addClass('active');
}

function disableChat() {
    $(".chat-input-wrapper").addClass("disabled");
}

function enableChat() {
    $(".chat-input-wrapper").removeClass("disabled");
}

export default {
    init: init,
    stopPlayer,
    continuePlayer,
    disableChat,
    enableChat
}


function flashChecker() {
    var hasFlash = 0; //是否安装了flash
    var flashVersion = 0; //flash版本
    if (document.all) {
        var swf = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
        if (swf) {
            hasFlash = 1;
            VSwf = swf.GetVariable("$version");
            flashVersion = parseInt(VSwf.split(" ")[1].split(",")[0]);
        }
    } else {
        if (navigator.plugins && navigator.plugins.length > 0) {
            var swf = navigator.plugins["Shockwave Flash"];
            if (swf) {
                hasFlash = 1;
                var words = swf.description.split(" ");
                for (var i = 0; i < words.length; ++i) {
                    if (isNaN(parseInt(words[i]))) continue;
                    flashVersion = parseInt(words[i]);
                }
            }
        }
    }
    return hasFlash
}

function fixFirefox() {
    // 火狐flash已启用，但需要用户手动确认使用flash，需要把flash放在最上层
    console.log('fix firefox flash player');
    var $root = $('.live-player');
    $root.find('.vcp-video').css({
        position: 'relative',
        zIndex: 1000
    });
    $root.find('.vcp-bigplay, .vcp-spinner').css({
        zIndex: 999
    });
}


function showTip(tipId) {
    $('.' + tipId).show();
    $('.flash-container').hide();
}

function hideTip(tipId) {
    $('.' + tipId).hide();
    if (!flashChecker()) {
        $('.flash-container').show();
    }
}
if (!flashChecker()) {
    $('.flash-container').show();
} else {
    $('.flash-container').remove();
}
