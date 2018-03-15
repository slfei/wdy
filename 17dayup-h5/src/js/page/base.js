import weui from 'weui.js'
import common from "../common"
import "./components/header_search"

// weui.searchBar('#searchBar');

$(function() {
    // if(location.pathname !== '/course/classify'){
        // FastClick.attach(document.body);        
    // }

    $(".js-backward").on("click", function(){
        common.goBack()
    });
    _init();
});

function _init() {
    if($tplData.course_name){
        common.initWechatShare({
            title: $tplData.course_name + '_伟东云学堂',
            desc:'我正在伟东云学堂学习'+$tplData.course_name+'，非常好的学习体验，你要来试试吧',
            url:location.href,
            thumbnail:$tplData.course_img
        }
    )

    }else if (!window.blockDefaultShare){
        common.initWechatShare({
            title: '伟东云学堂-带梦想起航',
            desc: '互联网、早教、外语、国学、生活等各类精品课，总有一款你值得拥有!',
            url: location.protocol + '//' + location.host,
            thumbnail:'http://www.wdyedu.com/build/img/fav-2711d55b2c.ico'
        })
    }else{
        // common.initWechatShare({
        //     title: '伟东云学堂-带梦想起航',
        //     desc: '互联网、早教、外语、国学、生活等各类精品课，总有一款你值得拥有!',
        //     url: location.protocol + '//' + location.host,
        //     thumbnail:'http://www.wdyedu.com/build/img/fav-2711d55b2c.ico'
        // }) 
    }

}
