import common from '../../common'
import api from '../../api'
import im from "./im"
//window.live_sectionId  在直播的sectionid 用于退出房间
var streamUrl;
window.timeout=null;
window.live_sectionId;
window.identifier;
window.liveSectionId='';
var liveVideo={
    heartSetInterval:null,
    init(){
        this.bindEvent();
    },
    bindClick(){
        var $liveCont=$('.live-cont'),
        $parents=$liveCont.parents('.course-section-item');
        $parents.click();
    },
    bindEvent(){
        var $liveCont=$('.live-cont'),
        $parents=$liveCont.parents('.course-section-item'),
        _this=this;
        $parents.on('click',function(){               
            var timestamp=Date.parse(new Date()),
                $this=$(this),
                courseId=window.courseId,
                sectionId=$this.data('section-id');
            window.live_sectionId=sectionId;
            window.liveStatus=0;
            if (sectionId === window.liveSectionId)
            return false;
            window.liveSectionId = sectionId;
            if(window.livePlayer&&sectionId!=_this.liveSectionId){
                clearInterval(_this.heartSetInterval);
                _this.leaveRoom(window.courseId,window.live_sectionId);
            }; 

            _this.initPlayer(courseId,sectionId);
        })
    },
    //初始化播放器 触发心跳
    initPlayer(courseId,sectionId){
        // console.log(courseId,sectionId)
        var _this=this;
        var streamTypeMap = {
                1: 'aux',//屏幕分享
                2: 'main'//摄像头
            };
        _this.getLiveInfo(courseId,sectionId).then(function(data) {
            streamUrl = data.ilvb_stream_url;
            window.identifier=data.identifier;
            im.init(data);
            if(window.livePlayer){
                window.livePlayer.destroy();
            };
            if(_this.heartSetInterval){
                clearInterval(_this.heartSetInterval)
            };
            _this.heartBreak(courseId,sectionId,Date.parse(new Date()));
            _this.heartSetInterval=setInterval(()=>{
                var timestamp=Date.parse(new Date());
                    _this.heartBreak(courseId,sectionId,timestamp);
                },15000);
            if(data.live_status==1){
                _this.liveConfig(streamTypeMap[data.stream_type] || 'main','');
            }else if(data.live_status==2){
                $('.live-tips').show().children().html('休息一下，马上回来！');   
            }else if(data.live_status==4){
                $('.live-tips').show().children().html('直播已结束，学习愉快！');
            }
            
        }, function(data) {
            if(data.status==709){
                common.ui.topTips("报名后才可以观看哦！");
                return false;
            }
            common.ui.topTips(data.msg);
        })
    },
    //播放器配置
    liveConfig(pull_stream_url,destroy){
        var des=destroy||false;
        // console.log(des,window.livePlayer);
        if(des&&window.livePlayer){
            window.livePlayer.destroy();
        }
        var _this=this;
        var url = streamUrl[pull_stream_url];
        if(window.liveStatus==0){
            $("#player").css('display','none');
            $("#id_test_video").css('display','block');
            window.livePlayer = new TcPlayer('id_test_video', {
                "m3u8": url['m3u8'], 
                "live": true,
                "autoplay" : true,      //iOS下safari浏览器，以及大部分移动端浏览器是不开放视频自动播放这个能力的
                "width" :  '375',//视频的显示宽度，请尽量使用视频分辨率宽度
                "height" : '211',//视频的显示高度，请尽量使用视频分辨率高度
                // "controls":"system",
                "listener":function(msg){
                    // console.log(msg)
                    // console.log(msg.type)
                    if(msg.type=="fullscreen"){
                        var $detail=$('.detail');
                       if(msg.detail.isFullscreen){
                            $detail.addClass('cur');
                            $detail.find('.action').hide();
                       }else{
                            $detail.removeClass('cur');
                            $detail.find('.action').show();
                       }
                    };
                    if(msg.type == 'error'){
                        var $vcpPlayer=$('.vcp-player'),
                            errorTips=$vcpPlayer.find('.vcp-error-tips-new').length;
                        _this.tipsMsg(errorTips,'老师正在调试中，请稍后！');
                        window.timeout=setTimeout(function(){
                            window.livePlayer.load();//进行重连
                        },5000);
                    }else{
                        if(msg.type=='playing'){
                            $('.vcp-error-tips-new').remove();
                        }
                    }
                }
            });
            if(typeof window.player=='object'&& window.player.nodeType!=1){
                window.player.src({
                    src: '//wdyedu-static.bj.bcebos.com/empty.mp3',
                    type: 'audio/mp3'
                });
                
            }
        }
    },
    //获取视频地址
    getLiveInfo(courseId,sectionId){
        return api.live.enterquit( {
            course_id: courseId,
            section_id: sectionId,
            op_type:1
        })
    },
    //离开房间
    leaveRoom(courseId,sectionId){
        return api.live.enterquit( {
            course_id: courseId,
            section_id: sectionId,
            op_type:-1
        }).then(function(){
            im.quitBigGroup();
        })
    },
    //心跳接口 判断主播是否在线 
    heartBreak(courseId,section_id,timestamp){
        var _this=this;
        return api.live.heartbreak({
            course_id: courseId,
            section_id: section_id,
            timestamp:timestamp,
        }).then(function(data) {
            var $vcpPlayer=$('.vcp-player'),
                errorTips=$vcpPlayer.find('.vcp-error-tips-new').length;
            // if(data.live_status==1){
            //     if(data.push_stream_status==5){
            //         _this.tipsMsg(errorTips,'讲师暂时离开，请稍后！')
            //     }
            //     return false
            // }else 
            if(data.live_status==4){     
            // if(data.push_stream_status!=0){
                _this.tipsMsg(errorTips,'直播已结束，学习愉快！');
                return false
            // }
            }
            // else{
            //     $('.vcp-error-tips-new').remove()
            // }

        }, function(data) {
            common.ui.topTips(data.msg);
        });
    },
    tipsMsg(errorTips,msg){
        if(errorTips){
            $('.vcp-error-tips-new').remove();
        };
        $('.vcp-player').prepend(`<div class=vcp-error-tips-new><p>${msg}</p></div>`)
    }
}
liveVideo.init();

window.liveVideo = liveVideo;

export default {
    liveVideo
}




