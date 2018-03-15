/**
 * Created by huangzhongjian on 17/9/19.
 */

import lang from '../lang/lang.js'

import header from './header_footer.js';

if (jQuery) {
    $.ajaxSetup({
        dataFilter: function(res) {
            try {
                var data = JSON.parse(res);
                if (data.status == 605) {
                    wdy.passport.showView('login');
                    return '';
                }
            }catch(e){

            }
            return res;
        }
    });
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


/**
 * 返回回顶部
 */

var winHeight = window.innerHeight;

$(window).scroll(function(e){
    var el = document.scrollingElement || document.body;
    if (el.scrollTop > winHeight) {
        $('.js_top').show();
    } else {
        $('.js_top').hide();
    }
});

$('.js_top').on('click',function(){
    $('html, body').animate({
        scrollTop: 0
    });
});
