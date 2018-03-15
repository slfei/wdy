import api from '../../api'
import config from '../../config'

$(function(){

    $('.login_out a').click(function(){
        // delCookie(userkey)
        // location.href('http://passport.ac.enimo.cn/account/login')
        
        api.post(config.host.passport + "/api/account/userlogout").then(function(data){
            location.href = "/";
        }, function(err){
            console.log(err);
        })
    })
    function delCookie(name)  
    {  
        var exp = new Date();  
        exp.setTime(exp.getTime() - 1);  
        var cval=getCookie(name);  
        if(cval!=null)  
            document.cookie= name + "="+cval+";expires="+exp.toGMTString();  
    } 
})
