/**
 * Created by huangzhongjian on 17/11/22.
 */

export { default as  setUpVideoLog } from './log.js';

const map = {
    '标清(360p)': '360p',
    '超清(720p)': '720p',
    '蓝光(1080p)': '1080p'
};

export function generateSource(sourceInfo) {
    var ret = [];
    for (var key in map) {
        var k = map[key];
        if (sourceInfo[k] && map.hasOwnProperty(key)) {
            ret.push({
                label: key,
                file: sourceInfo[k]
            })
        }
    }
    return ret;
}


export function setUpPlayer(container, sourceInfo) {
    var $container = $(container);
    var player = cyberplayer($container.find('.player-container')[0]).setup({
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
        playRateConfig: [
            { label: '×0.5' },
            { label: '×1'},
            { label: '×1.25'},
            { label: '×1.5'},
            { label: '×1.5'},
            { label: '×2'}
        ],
        playlist: [{
            sources: generateSource(sourceInfo)
        }],
        controlbar: {
            barLogo: false
        }
    });

    //默认选择1倍播放
    player.once('ready', () => {
        player.setPlaybackRate(1);
        //console.log(player.getContainer().classList)
        player.getContainer().classList.remove('jw-flag-user-inactive');
    });

    var events = ['beforePlay','ready', 'buffer',
        'bufferChange', 'bufferFull', 'complete', 'meta',
        'play', 'seek', 'seeked', 'error', 'levelsChanged', 'playbackRate'];

    events.forEach(event => {
        player.on(event, function() {
            var args = Array.from(arguments);
            console.log.apply(console, [event].concat(args));
        });
    });
    player.play();
    return player;
}


