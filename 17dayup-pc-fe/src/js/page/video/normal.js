import setUpVideoLog from './videoLog.js';

var $player = $('#player');
const courseId = window.COURSE_INFO.course_id;
const catalog = window.COURSE_INFO.course_catalog;

if(LOCALE != 'zh_CN'){
    var map = {
        'SD(360P)': '360p',
        'HD(720P)': '720p',
        '蓝光(1080P)': '1080p'
    };
}else{
    var map = {
        '标清(360P)': '360p',
        '超清(720P)': '720p',
        '蓝光(1080P)': '1080p'
    };
}

function generateSource(videoInfo) {
    var ret = [];
    for (var key in map) {
        var k = map[key];
        if (videoInfo[k] && map.hasOwnProperty(key)) {
            ret.push({
                label: key,
                file: videoInfo[k]
            })
        }
    }
    return ret;
}

function getQuery(name, url) {
    url = url  || location.href;
    if (new RegExp('(\\?|&)' + name + '=' + '([^&]*)').test(url)) {
        return RegExp.$2
    }
    return '';
}

// function getHashQuery(name) {
//     var str = location.hash;
//     var reg = new RegExp('(?:^|#)' + name + '=([^&]*)');
//     if (reg.test(str)) {
//         return RegExp.$1;
//     }
//     return '';
// }


function containsSection(sectionId) {
    if (!sectionId && sectionId !== 0) return false;
    for (var i = 0, len = catalog.length; i < len; i++) {
        if (catalog[i]._child && catalog[i]._child.length) {
            var flag = catalog[i]._child.some(item => item.id == sectionId);
            if (flag) {
                return true;
            }
        }
    }
    return false;
}

function setUpPlayer(container, videoInfo) {
    var $container = $(container);
    var player = cyberplayer(container.find('.player-container')[0]).setup({
        width: $container.width(),
        height: $container.height(),
        autostart: true,
        stretching: 'uniform',
        volume: 80,
        ak: 'ef79696626b64531855acabfd78c1c69',
        controls: {
            barLogo: false
        },
        starttime: 0,
        //primary: 'flash',
        playRateConfig: [
            { label: '×0.5' },
            { label: '×1'},
            //{ label: '×1.25'},
            { label: '×1.5'},
            { label: '×2'}
        ],

        rightclick: [{
            title: '关于伟东云学堂',
            link: '/'
        }],
        playlist: [{
            sources: generateSource(videoInfo)
        }],
        controlbar: {
            barLogo: false
        }
    });

    $(window).on('resize.player', function() {
        console.log($container.width(), $container.height());
        // fix player request fullscreen $container.height is 0
        if (!$container.width() || !$container.height()) return;
        player.resize($container.width(), $container.height());
    });
    //默认选择1倍播放
    player.once('ready', () => {
        player.setPlaybackRate(1);
        //console.log(player.getContainer().classList)
        player.getContainer().classList.remove('jw-flag-user-inactive');
    });

    var events = ['beforePlay','ready', 'buffer',
        /*'bufferChange', 'bufferFull',*/ 'complete', 'meta',
        'play', 'seek', 'seeked', 'error', 'levelsChanged', 'playbackRate'];

    events.forEach(event => {
        player.on(event, function() {
            var args = Array.from(arguments);
            console.log.apply(console, [event].concat(args));
            if(event=='meta'){
                player.setPlaybackRate(player.getPlaybackRate());
            }
        });
    });

    return player;
}


function destroyPlayer(player) {
    $(window).off('resize.player').off('beforeupload.player');
    player.off(); // try to unbind event
    player.remove();
}


function getVideoInfo(section_id) {
    return $.ajax({
        url: '/api/course/getvideobysectionid',
        data: {
            course_id: courseId,
            section_id: section_id
        }
    }).then(function(res) {
        if (res.status === 200) {
            $('.pay-tip').hide();
            return res.data.video_info;
        } else {
            $('.pay-tip').show();
            if (window.videoPlayer) {
                destroyPlayer(videoPlayer);
            }
            throw new Error(res.msg);
        }
    })
}

function init() {
    var sectionId = window.COURSE_INFO.section_id;
    var deferred = $.Deferred();
    deferred.done(callback);
    if (!containsSection(sectionId)) {
        $.get('/api/course/gethistory?course_id=' + courseId).then(function(resp){
            if(resp.status = 200){
                var history = resp.data.history,
                    latelyId = resp.data.lately_id;
                if (latelyId === 0) {
                    sectionId = catalog[0]._child[0].id;
                } else {
                    if(history.indexOf(latelyId) === -1){
                        sectionId = latelyId;
                    }else{
                        var startStatus = false;
                        for (var i=0, len = catalog.length; i < len; i++) {
                            for (var j=0;j < catalog[i]._child.length; j++) {
                                //没有播放过
                                if(catalog[i]._child[j].id === latelyId){
                                    startStatus = true;
                                }
                                if(startStatus && history.indexOf(+catalog[i]._child[j].id) === -1){
                                    sectionId = catalog[i]._child[j].id;
                                }
                            }
                        }
                        //如果下面的都播放了，则播放最后一次播放的
                        !sectionId && (sectionId = latelyId);
                    }
                }
                deferred.resolve();
            }else{
                utils.toast(resp.msg, 'error')
            }
        });
    }else{
        deferred.resolve();
    }
    //jquery promise
    function callback(){
        if (!sectionId) {
            return console.log('此课程无目录', catalog);
        }

        function playBySid(sid){
            getVideoInfo(sid).then(videoInfo => {
                if (window.videoPlayer) {
                    destroyPlayer(videoPlayer);
                }
                window.videoPlayer = setUpPlayer($player, videoInfo);
                setUpVideoLog(videoPlayer, {
                    course_id: courseId,
                    section_id: sid
                });
            });
        }
        renderCatalog(sectionId, playBySid);
    }
}


function renderCatalog(sid, playBySid){
    var $chapters = $('.chapter-item');

    function chooseById(id) {
        $chapters.removeClass('active');
        $chapters.filter('[data-id="' + id + '"]').addClass('active');
        playBySid(id)
    }

    $chapters.on('click', function() {
        if ($(this).hasClass('active')) return ;

        var id = $(this).data('id');
        chooseById(id);
    });

    chooseById(sid);
}


export default {
    init
}
