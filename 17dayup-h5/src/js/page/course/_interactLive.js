// 互动直播消息处理函数
var close_camera=null;
var close_share=null;
var i=0;
var $vcpPlayer=$('.vcp-player');
var $vcpPlayerTips=$vcpPlayer.find('.vcp-error-tips-new');
var errorTips=$vcpPlayerTips.length;
var $liveTips=$('.live-tips');
var pause=0; //暂停  0未点击 1点击
function handle(content){
    // console.log(content.getData())
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
    };
    switch (data.userAction){
        case 8://屏幕分享
            $('.vcp-error-tips-new').remove();
            clearIntervalFn();
            if(pause==1){
                setTimeout(function(){
                    window.liveVideo.liveConfig('aux','true');
                },30000);
                return false;
            }
            window.liveVideo.liveConfig('aux','true');
            
            break;
        case 9://关闭屏幕分享、
            close_camera=teacherOnline();
            break;
        case 10://摄像头
            $('.vcp-error-tips-new').remove();
            clearIntervalFn();
            if(pause==1){
                setTimeout(function(){
                    window.liveVideo.liveConfig('main','true');
                },30000);
                return false;
            }
            window.liveVideo.liveConfig('main','true');
            break;
        case 11://关闭摄像头
            close_camera=teacherOnline();
            break;
        case 7://暂停
            clearInterval(window.timeout);
            shopLive('休息一下，马上回来！');
            break;
        case 6://下课
            $('.vcp-error-tips-new').remove();
            clearInterval(window.timeout);
            shopLive('直播已结束，学习愉快！',45000);
            break;
        case 5://上课
            if(pause==1){
                setTimeout(function(){
                    $liveTips.hide();
                    window.liveVideo.initPlayer(window.courseId,window.live_sectionId);
                },30000);
                return false;
            }
            $liveTips.hide();
            window.liveVideo.initPlayer(window.courseId,window.live_sectionId);
            break;
    }
};
function clearIntervalFn(){
    if(close_camera){
        clearInterval(close_camera);
        i=0;
        $vcpPlayerTips.remove();
    };
    if(close_share){
        clearInterval(close_camera);
        i=0;
        $vcpPlayerTips.remove();
    };
};
function teacherOnline(){
    return setInterval(function(){
        i++;
        if(i==5){//
           window.liveVideo.tipsMsg(errorTips,'老师正在调试中，请稍后！');
        };
    },10000)
};
function shopLive(msg,timeOut){
    var time=timeOut||30000;
    pause=1;
    setTimeout(function(){
        if(window.livePlayer){
            window.livePlayer.destroy();
            window.livePlayer='';
            $liveTips.show().children().html(msg);
        }
    },time)
    
}
window.handle = handle;
export default {
    handle
}
