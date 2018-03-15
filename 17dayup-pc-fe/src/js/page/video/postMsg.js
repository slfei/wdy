function postMsg(){

    var xhr = new XMLHttpRequest();
    var host = window.WWW_HOST ? ('//' + window.WWW_HOST) : '';
    xhr.open('POST', `${ host}/api/message/count`);
    xhr.withCredentials = true;
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status < 300 && xhr.status >=200) {
            try {
                var json = JSON.parse(xhr.responseText);
                if (json.status === 200){
                    if(json.data.unread_count){
                        document.querySelector('.js_msgNum').style.display ="block";
                        document.querySelector('.js_msgNum').innerText = json.data.unread_count;
                    }else{
                        document.querySelector('.js_msgNum').style.display ="none";          
                    }
                }else{
                    document.querySelector('.js_msgNum').style.display ="none";
                    clearInterval(msgTimer)
                }
            } catch(e) {
                clearInterval(msgTimer)
            }
        }
    };
    xhr.send(null);
}


var msgTimer = setInterval(function(){
    postMsg()
},60000)

postMsg();
