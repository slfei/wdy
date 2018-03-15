import live from "./live";
/*
typedef enum E_LiveCmd
{
 0 LiveCmd_None = 0,

 1 LiveCmd_NoChat,//禁止聊天（针对单人）
 2 LiveCmd_Chat,//允许聊天（针对单人）
 3 LiveCmd_AllNoChat,//全体禁止聊天
 4 LiveCmd_AllChat,//全体解禁聊天
 5 LiveCmd_ClassLiving,//上课
 6 LiveCmd_ClassStop,//下课
 7 LiveCmd_ClassPause,//直播课暂停/休息
 8 LiveCmd_Share,//分享屏幕
 9 LiveCmd_CloseShare,//关闭分享屏幕
 10 LiveCmd_Camera,//打开摄像头
 11 LiveCmd_CloseCamera,//关闭摄像头
 12 LiveCmd // 用户上线

 12 LiveCmd_Invalid,
}E_LiveCmd;
*/
var timer;
// 互动直播消息处理函数
function handle(content){

    if(content.getData){
        var data = JSON.parse(content.getData());
        var params = data.actionParam.split(",");
        data.actionParam = {};
        for(var i = 0, l = params.length; i < l; i++){
            var arr = params[i].split(':')
            data.actionParam[arr[0]] = arr[1];
        }
    }else{
        var data = {
            "userAction": content
        }
    }

    // var data = content.getData && content.getData() || content;
    // var desc = content.getDesc();
    // var ext = content.getExt();
    // console.log(data, desc, typeof(data));
    console.log(data);

    switch (data.userAction){
        case 10:
            // 摄像头直播
            initPlayer('main');
            break;
        case 8:
            // 分享屏幕直播
            initPlayer('aux');
            break;
        case 1:
        case 3:
            // 禁言
            live.disableChat();
            break;
        case 2:
        case 4:
            // 解禁
            live.enableChat();
            break;    
        case 6:
            // 下课
            clearTimer();
            timer = setTimeout(function(){ live.stopPlayer($i18n('video.text3'))}, 10000);
            break;
        case 7:
            live.stopPlayer($i18n('video.text4'));
            // 休息一下，马上回来
            break;
        case 5:
            clearTimer();
            live.continuePlayer();
            break;
        case 9:
        case 11:
            live.stopPlayer($i18n('video.text5'))
        default:
            break;
    }
}


window.handle = handle;

function clearTimer() {
    if (timer != null) {
        clearTimeout(timer);
        timer = null;
    }
}

export default {
    handle
}
