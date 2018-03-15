exports.fnAjax = function (obj) {
    var obj = {
        type:obj.type||'POST',
        url:obj.url||"",
        done:obj.done||function(){},
        fail:obj.fail||function(){}
    };

    var xhr = new XMLHttpRequest();
    var host = window.WWW_HOST ? ('//' + window.WWW_HOST) : '';
    xhr.open(obj.type, `${ host}` + obj.url);
    xhr.withCredentials = true;
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status < 300 && xhr.status >=200) {
            try {
                var json = JSON.parse(xhr.responseText);
                    obj.done(json);
            } catch(e) {
                obj.fail();
            }
        }
    };
    xhr.send(null);
};

