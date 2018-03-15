/**
 * Created by huangzhongjian on 17/10/17.
 */
import lang from '../../lang/lang.js'
import live from "./live";
import normal from "./normal";
import "./postMsg";
import "./passport";
import "./categoryToggle";

//setUpPlayer($player, videoInfo);
bindNoSign();

function bindNoSign() {
    $('.no-sign-tip .close-btn').on('click', function() {
        $('.no-sign-tip').remove();
    });
}

if(window.isLive){
    live.init(window.COURSE_INFO.course_id, window.COURSE_INFO.section_id || window.CUR_SECTION.id)
}else{
    normal.init()
}


window.utils = window.utils || {};
window.utils.toast = function(text, type) {
    var config = {
        position: 'top-center',
        showHideTransition: 'fade',
        icon: false, // 'success',
        allowToastClose: false,
        bgColor: 'rgba(38,143,255, .9)',
        loader: false,
        textAlign: "center",
        beforeShow: (e) => e.stopPropagation(),
        afterShown: (e) => e.stopPropagation()
    };
    if (typeof text == 'object') {
        $.extend(config, text);
    } else if(typeof text == 'string'){
        config.text = text;
        if (type == 'error') {
            config.bgColor = 'rgba(255, 61, 72, .9)';
            config.textColor = 'white';
        }
        //type && (config.icon = type);
    }
    return $.toast(config);
};
