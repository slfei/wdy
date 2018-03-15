import { Promise } from  'es6-promise-polyfill';

function ajax(type, url, data, headers) {
    return new Promise(function(resolve, reject){
        var xhr = new XMLHttpRequest();
        xhr.open(type.toUpperCase(), url, true);
        xhr.withCredentials = true;
        xhr.setRequestHeader('appid', 'cc0103edr1aw134r');
        if (headers) {
            for (var key in headers) {
                if (headers.hasOwnProperty(key)){
                    xhr.setRequestHeader(key, headers[key]);
                }
            }
        }
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var json = JSON.parse(xhr.responseText);
                        resolve(json);
                    } catch(e) {
                        reject(e);
                    }
                } else {
                    reject('NetWork Status ' + xhr.status);
                }
            }
        };

        xhr.send(data || null);
    });
}

function params (obj) {
    var ret = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key) && obj[key] !== null && obj[key] !== '') {
            ret.push(key + '=' + encodeURIComponent(obj[key]));
        }
    }
    return ret.join('&');
}

function post (url, data) {
    if (typeof data == 'object') {
        data = params(data);
    }
    return ajax('post', url, data, {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
    });
}

function get(url, data) {
    if (typeof data == 'object') {
        data = params(data);
    }
    if (data) {
        if (url.indexOf('?') > 0) {
            url = url + '&' + data;
        } else {
            url = url + '?' + data
        }
    }

    return ajax('get', url);
}

export var $host = '';

export default {

    setHost (host) {
        $host = host;
    },

    getCaptcha (data) {
        return get($host + '/api/v1.2/account/sendcaptcha', data);
    },

    accountLogin (data) {
        return post($host + '/api/v1.2/account/userlogin', data);
    },

    mobileLogin (data) {
        return post($host + '/api/v1.2/account/userlogin', data);
    },

    getPicCode () {
        return get($host + '/api/v1.2/account/picvcode?type=get');
    },

    verifyPicCode (id, code) {
        return get($host + `/api/v1.2/account/picvcode?type=verify&code=${code}&phrase_id=${id}`);
    },

    register (data) {
        return post($host + '/api/v1.2/account/userregister', data);
    },

    bindPhone(data) {
        return post($host + '/api/v1.2/account/bindphone', data);
    },

    resetPassword(data) {
        return post($host + '/api/v1.2/account/resetpassword', data);
    },

    logout () {
        return post($host + '/api/v1.2/account/userlogout');
    }
}
