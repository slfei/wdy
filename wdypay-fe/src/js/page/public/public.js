export function countDown(mss,type) {
        var days = parseInt(mss / ( 60 * 60 * 24));
        var hours = parseInt((mss % (60 * 60 * 24)) / (60 * 60));
        var minutes = parseInt((mss % (60 * 60)) / (60));
        var seconds = (mss % (60));
        switch(type){
            case 'D':
            break;
            case 'H':
                return ` ${hours} ${Lang.hover} ${minutes} ${Lang.minutes} ${seconds} ${Lang.seconds}`;
            break;
            case 'M':
            break;
            case 's':
               return  seconds + Lang.seconds; 
            break;
            default:
               return '0' + days + Lang.day + hours + Lang.hover + minutes + Lang.minutes + seconds + Lang.seconds; 
        }
}

export function toast(text, type){
    var config = {
        position: 'top-center',
        showHideTransition: 'fade',
        icon: false, // 'success',
        allowToastClose: false,
        bgColor: 'rgba(38,143,255, .9)',
        loader: false,
        textAlign: "center",
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
}

export function fnAjax(opts){
    var defaults = {
        type: 'POST',
        data: {}
    };
    var obj = $.extend({},defaults,opts)
    $.ajax({
        url: obj.url,
        type: obj.type,
        data: obj.data,
        success:function(res){
            obj.done(res);
        },
        error:function(err){
            obj.fail(err);
        }
    });
}
