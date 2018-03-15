import common from '../../common'
import utils from '../../utils'
import api from '../../api'
import "./_comment"
import "../features/infinite_scroll"
import setUpVideoLog from '../../player/log';
import live from './live.js'

var $tab = $('#tab'),
    $statusBtn=$("#statusBtn");
window.livePlayer=''; //直播播放器
window.liveStatus=0; //用于防止直播开始但未初始化完成时 再次点击录播课程

$tab.on('click', 'li', function () {
    var index = $(this).index();
    setActiveTab(index);
});

function setActiveTab(index) {
    $tab.find('.active').removeClass('active');
    $tab.find('li').eq(index).addClass('active');
    $('#container').find('.tab-content').hide().eq(index).show();
}


function goto(id,type){
    var path;
    if(type=="relevant"){
        path = '/course/' + id;
    }else if(type=='institute'){
        path = '/institute/homepage/' + id;
    }else if(type=='teacher'){
        path = '/personal/homepage/' + id;
    }
    location.href = path;
}

$('#statusBtn').on('click', '.apply',function(){
    var url  = '/api/course/signup?courseid=' + courseId;
    common.ui.loading.show('请稍等...')
    api.get(url).then(function(data){
        common.ui.loading.hide();
        if(data.type==1){
            // location.href = '/course/registration';   
            common.toast("报名成功！")
            setTimeout(function(){
                window.location.reload()     
            },0)                

        }else{
            location.href = '/course/confirm/'+ courseId                           
        }
    }, function(){
        common.ui.loading.hide();
    }) 
})

var $tabCatalog = $('#content2');

$tabCatalog.find('.chapter .title').click(function(){
    $(this).closest('.chapter').toggleClass('expand');
});

$tabCatalog.on('click', '.course-section-item', function(){
    var $this=$(this),
        $parent=$this.parents('.section'),
        $liveType=$parent.data('live-type');
    if($liveType=='video'||$liveType=='lived'){
        $tabCatalog.find(".active").removeClass("active");
        $("#player").css('display','block');
        $("#id_test_video").css('display','none');
        live.liveVideo.liveSectionId='';
        window.liveStatus=1;
        $parent.addClass('active');
        clickToPlay.call(this);
    }else{
        if($liveType=='live'){
            $parent.addClass('active').siblings('.active').removeClass('active');
            $parent.addClass('active').parents('.chapter').siblings('.chapter').find('.active').removeClass('active');
        }else if($liveType=='live-start'){
            common.ui.topTips('直播还未开始')
        }else{
            common.ui.topTips('该直播不支持回放')
        }
    }
});

$('#header-play').on('touchstart', function(){
    var sectionId = $(this).data('section-id');
    window.liveStatus=1;
    highlightSectionById(sectionId);
});

$("#statusBtn").on("click", '.js-start-study',function(){

    setActiveTab(1);
    if (!playingSectionId) {
        autoPlayByHistory(window.courseId);
    }

    //$tabCatalog.show();
    //clickToPlay.call(this);
    //$(".expand .section").eq(0).addClass('active')
});

function clickToPlay() {
    var sectionId = $(this).data('section-id');
    playBySectionId(sectionId);
}

function highlightSectionById(sectionId) {
    // console.log(sectionId)
    $tabCatalog.find(".active").removeClass("active");
    $tabCatalog.find('.chapter').eq(0).removeClass('expand');
    $tabCatalog.find('[data-section-id=' + sectionId + ']')
        .closest('.chapter')
        .addClass('expand');
    $tabCatalog.find("li:not([data-live-type=live-end]),li:not([data-live-type=live-start])").find('[data-section-id=' + sectionId + ']')
        .closest('.section')
        .addClass('active');
    var $item=$('.course-section-item[data-section-id='+sectionId+']');
    var $itemType=$item.parent().data('live-type');
    if($itemType=="video"||$itemType=="lived"){
        playBySectionId(sectionId);
    }else if($itemType=="live"){
        live.liveVideo.bindClick()
    }   
}

var player, playingSectionId;
function playBySectionId(sectionId, autoPlay = true) {
    if(window.livePlayer){
        window.livePlayer.destroy();
        clearInterval(live.liveVideo.heartSetInterval);
        live.liveVideo.leaveRoom(window.courseId,window.live_sectionId);
        clearTimeout(window.timeout);
        window.livePlayer='';
        playingSectionId='';
    }
    window.liveSectionId=sectionId;
    if (sectionId === playingSectionId)
        return false;
    playingSectionId = sectionId;

    //不能放到getVideoInfo里面，否则无法自动播放
    if (!player) {
       initPlayer();
    }
    player.on('play', function(){
        $(".pull-down").addClass('playNone').removeClass('active')
    });
    getVideoInfo(window.courseId, sectionId)
        .then(function(data) {
            if (sectionId !== playingSectionId) return;
            
            player.src({
                src: data['360p'],
                type: 'application/x-mpegURL'
            });
            player.controls(true);

            if (autoPlay) {
                player.load();
                player.play();
            }
            setUpVideoLog(player, {
                course_id: courseId,
                section_id: sectionId
            });
    })
}

function initPlayer () {
    window.player = player = videojs('video');
    // ios 9 ios 10自动播放问题
    player.src({
        src: '//wdyedu-static.bj.bcebos.com/empty.mp3',
        type: 'audio/mp3'
    });
    player.controls(false);
    player.load();
    player.play();
    $('#player').show().find('button, button .vjs-icon-placeholder').addClass('needsclick');
}

function getVideoInfo(courseId,section_id) {
    return api.get('/api/course/getvideobysectionid', {
            course_id: courseId,
            section_id: section_id
        }
    ).then(function(data) {
        return data.video_info;
    }, function(data) {
        common.ui.topTips('报名后才可观看哦！');
    });
}

function autoPlayByHistory(courseId) {

    var catalog = [].slice.call($tplData && $tplData['course_catelog'] || []);

    return api.get('/api/course/gethistory', {
        course_id: courseId
    }).then(function(data) {

        if (data.history && data.history.length) {
            catalog.forEach(function(section) {
                section._child.forEach(child => {
                    child.isPlayed = data.history.indexOf(+child.id) > -1;
                })
            });
        }

        var list = Array.prototype.concat.apply([],catalog.map(item => item._child));
        var sectionId;
        if (data.lately_id != 0){
            sectionId = findAutoPlay(list, data.lately_id);
        }else{
            sectionId = list[0].id;
        };
        var sectionIdDom=$('.course-section-item[data-section-id='+sectionId+']'),
            sectionIdDomParent=sectionIdDom.parent();
        var $itemType=sectionIdDomParent.data('live-type');

        if($itemType=='live'){
            live.liveVideo.bindClick()
        }else if($itemType=="video"||$itemType=="lived"){ 
            playBySectionId(sectionId);
            highlightSectionById(sectionId);
        };
    });

    function findAutoPlay(catalog, id) {
        var lastPlayed,
            sectionIdDom,
            sectionIdDomParent;
        for (var i = 0, len = catalog.length; i < len; i++) {

            sectionIdDom=$('.course-section-item[data-section-id='+catalog[i].id+']');
            sectionIdDomParent=sectionIdDom.parent();

            //自动播放跳过未开始的直播
            if(sectionIdDomParent.data('live-type')!='live-start'&&sectionIdDomParent.data('live-type')!='live-end'){ 
                var section = catalog[i];
                if (section.id === id){
                    lastPlayed = section;
                }
                //从当前位置向后找未播放过的章节视频
                if (lastPlayed && !section.isPlayed) {
                    return section.id;
                }
            }
        }
        return id;
    }
}

function initQueryString() {
    var tabIndex = utils.getQueryStringByName('tab');
    setActiveTab(tabIndex);
    if (utils.getQueryStringByName('autoPlay') == 'true') {
        autoPlayByHistory(window.courseId);
    }
}
initQueryString();
var $statusBtn = $('#statusBtn');
//课程状态接口
function getStatus(courseId){
    $.ajax({
        type:'POST',
        url:'/api/center/sign',
        data:{
            course_id: courseId
        }
    }).then(function(res) {
        if (res.status == 200) {
            return res.data;
        } else {
            throw new Error(res.msg);
        }
    }).then(function(data){
        // console.log(data)
        if(data.is_sign==0){
            $statusBtn.html('<div class="finish">报名结束</div>')
        }else if(data.is_sign==1){
            $statusBtn.html('<a href="javascript:void(0)" class="apply">报名学习</a>')
        }else{
            $statusBtn.html(`<a href="javascript:void(0)" 
            data-section-id=${data.section_id}
            class="success js-start-study"
           target="_blank">开始学习</a>`)
            
        }
    },function(data){
        // console.log(data)
    })
}
getStatus(window.courseId)



$(function(){
    $(".nav-icon-right").click(function(e){
        $(".pull-down").toggleClass('active')
         e.stopPropagation();
         return false;
    })

   $(".pull-down").on('click','.Share',function(){
        $(".shareWraper").show()
        $(".pull-down").addClass('playNone').removeClass('active')
    });

   $(".shareWraper").click(function(e){
        if(e.target!=".shareBox"){
            $(".shareWraper").hide()
        }
    })
   $(".shareWraper .shareBox").click(function(e){
        e.stopPropagation();
    })

    $('.cancel').click(function(){
        $(".shareWraper").hide()
    })

    $(document).click(function(e){
        $(".pull-down").addClass('playNone').removeClass('active')
    });

    $(".pull-down").click(function(e){
        e.stopPropagation();
    })

    $(".shareBox .sina").click(function(){
        var src=$(".icon-weibo").attr('href')
         location.href=src
    })

    $(".shareBox .qq").click(function(){
        var qqsrc=$(".icon-qzone").attr('href')
         location.href=qqsrc
       
    });

    /** 
     * 查询收藏  
    */
    $.ajax({
        method: 'POST',
        url: `/api/center/favorite`,
        data: {object_id: courseId},
    }).then(function (res) {
        if (res.status == 200) {
            if(res.data){
                $('.collect span').addClass("active")
            }else{
                $('.collect span').removeClass("active")    
            }
        }
    });
    
    $(".pull-down .home").click(function(e){
       location.href = location.origin;
    });

    $(".pull-down .collect").click(function(e){
        $('.collect span').addClass("active")
        var data= {typeid:1,objectid:window.courseId}
        if(!collection){
            var collectSus='/api/favorite/addfavorite'
            api.post(collectSus,data).then(function(res){
               // console.log(res)
                collection=1
                common.toast("收藏成功")
            })
        }else{
            $('.collect span').removeClass("active")
            var collectDel='/api/favorite/delfavorite'
            api.post(collectDel,data).then(function(res){
                collection=0
                common.toast("取消收藏")
            })
        }
    });

    $('.relevant').on('click','.wt-media', function () {
        var releantId = $(this).data('id');
        goto(releantId, 'relevant');
    });


});



