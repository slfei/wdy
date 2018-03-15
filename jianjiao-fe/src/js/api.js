import 'whatwg-fetch';
import rnMixIn from './rn_login';

function _genFormData(obj, form, namespace) {
    var fd = form || new FormData();
    var formKey;

    for (var property in obj) {
        if (obj.hasOwnProperty(property)) {

            if (namespace) {
                formKey = namespace + '[' + property + ']';
            } else {
                formKey = property;
            }
            //console.log(formKey);
            // if the property is an object, but not a File,
            // use recursivity.
            if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {

                _genFormData(obj[property], fd, formKey);
            } else {

                // if it's a string or a File object
                if (obj[property] === '' || obj[property] === undefined) {
                } else {
                    fd.append(formKey, obj[property]);
                }

            }

        }
    }

    return fd;
}

function _typeStrToId(type) {
    var id;
    switch (type) {
        case 'institute':
            id = 1;
            break;
        case 'news':
            id = 2;
            break;
        case 'comment':
            id = 3;
            break;
    }

    return id
}

function param(obj) {
    var ret = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key) && obj[key] != null) {
            ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
        }
    }
    return ret.join('&');
}


function _apiCallback(data) {
    if (data.status === 200) {
        return data.data;
    } else if (data.status == 605) {
        // 用户未登录, 跳转到登陆页
        location.href = "/account/login?redirect_url=" + encodeURIComponent(location.pathname + location.search);
        throw '用户未登录';
    } else {
        throw data.msg;
    }
}


function sendVerifyCode(mobile, action) {
    var type;
    switch (action) {
        case 'register':
            type = 1;
            break;
        case 'login':
            type = 2;
            break;
    }


    if (!type) {
        return Promise.reject('action not implemented');
    }

    return fetch('/api/account/sendcaptcha', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            'phone': mobile,
            'type': type
        })
    }).then(resp => resp.json()).then(_apiCallback)
}


function login(mobile, verify_code,rgs_origin, weixin_openid, activity) {
    var params = {
        'phone': mobile,
        'captcha': verify_code,
        'source':rgs_origin
    };

    activity && (params.activity = activity);

    if (weixin_openid) {
        params['weixin_openid'] = weixin_openid;
    }

    return fetch('/api/account/userlogin', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData(params)
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback)
}


function saveLabels(arrLabId) {
    return fetch('/api/account/updatemytag', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            label: arrLabId
        })
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback)
}


function getCommentList(type, id, is_img, start, limit) {
    var tid;
    switch (type) {
        case 'news':
            tid = 2;
            break;
        case 'institute':
            tid = 1;
            break;
    }
    is_img = is_img ? 1 : 0;
    start = start ? start : 0;
    limit = limit ? limit : 20;

    return fetch('/api/comment/list', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            object_id: id,
            type: tid,
            is_img: is_img,
            start: start,
            limit: limit
        })
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback);
}


function postNewComment(type, id, data) {

    return fetch('/api/comment/post', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData(data)
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback);
}

function getMycollect(type) {
    return fetch('/api/center/favorite/'+type, {
        method: 'POST',
        credentials: 'same-origin'
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback);
}

function addCollection(type, id) {
    console.log(type,id)
    return fetch('/api/favorite/addcollection', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            typeid: type,
            objectid: id
        })
    }).then(function (resp) {
        return resp.json();
    }).then(_apiCallback);
}


function removeCollection(type, id) {
    console.log(type,id);
    return fetch('/api/favorite/delcollection', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            typeid: type,
            objectid: id
        })
    }).then(function (resp) {
        return resp.json()
    }).then(_apiCallback);
}

function getSuggest(query) {
    return fetch('/api/search/sug?query=' + query)
        .then(res => res.json())
        .then(_apiCallback)
}


function getHotWords() {
    return fetch('/api/search/gethotkeywords')
        .then(res => res.json())
        .then(_apiCallback)
}

function like(type, id, userKey) {

    var options = {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            object_id: id,
            object_type: _typeStrToId(type),
        })
    }

    if (userKey) {
        options.headers = {
            "UserKey": userKey
        }
    }

    return fetch('/api/comment/like', options).then(res => res.json()).then(_apiCallback);
}

function focusquestion(id) {
    return fetch('/api/circle/focusquestion', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            question_id: id,
        })
    }).then(function (resp) {
        return resp.json()
    }).then(_apiCallback);
}

function unLike(type, id, userKey) {
    var options = {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            object_id: id,
            object_type: _typeStrToId(type)
        })
    }

    if (userKey) {
        options.headers = {
            "UserKey": userKey
        }
    }

    return fetch('/api/comment/unlike', options).then(res => res.json()).then(_apiCallback);
}

function isCollect(param) {
    return post('/api/center/isfavorite', param)
}
function switchRecommend(id){
    return post('/api/index/recommend',id)
}

function getAnswerIsAgrees(id_arrays){
    console.log(id_arrays)
    return post('/api/center/answerlistvote',id_arrays)
}


function sendFeedback(type, text, img_list) {
    return fetch('/api/feedback/receivefeedback', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            type: type,
            text: text,
            img_list: img_list
        })
    }).then(res => res.json()).then(_apiCallback);
}


function searchInstitute(data) {
    return fetch('/api/search/searchinstitute?' + param(data), {
        method: 'GET',
        credentials: 'same-origin'
    }).then(res => res.json())
        .then(_apiCallback)
}

function searchNews(data) {
    return fetch('/api/search/searchnews?' + param(data))
        .then(res => res.json())
        .then(_apiCallback)
}
function searchQuestion(data) {
    return fetch('/api/search/question?' + param(data))
        .then(res => res.json())
        .then(_apiCallback)
}

function getInterestInstitute() {
    return fetch('/api/interestinstitute', {
        credentials: 'same-origin'
    }).then(res => res.json())
    .then(_apiCallback);
}

function saveUserInfo(key, value) {
    var tid;
    switch (key) {
        case 'avatar':
            tid = 1;
            break;
        case 'nick_name':
            tid = 2;
            break;
        case 'sex':
            tid = 3;
            break;
        case 'birth_date':
            tid = 4;
            break
    }
    return fetch('/api/account/updatemyedit', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData({
            type: tid,
            value: value
        })
    }).then(res => res.json()).then(_apiCallback)
}

function getAnswerList(param) {
    return post('/api/circle/question/detail', param)
}

function voteAnswer(id, value) {
    return post('/api/circle/answervote', {
        answer_id: id,
        value: value
    });
}

function submit_test_data(id, obj) {
    return fetch('/api/quiz/submit', {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData(
            {
                title_id: id,
                subject_obj: obj
            })
    }).then(res => res.json()).then(_apiCallback)
}


function loadMore(url, params) {
    return fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData(params)
    }).then(res => res.json()).then(_apiCallback)
}

function post(url, data) {
    return fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        body: _genFormData(data)
    }).then(res => res.json()).then(_apiCallback)
}
function isLogin(){
    return post('/api/center/getuserinfo')
}

function thumbsUp(params){
    return post('/api/comment/like',params)
}
function thumbsDown(params){
    return post('/api/comment/unlike',params)
}
// todo:兑奖接口

function redeem(params){
    return post('/api/activity/exchangeprize',params)
}
function redeemScore(params){
    return post('/api/activity/isexchangeprize',params)
}

function exposure(params){
    console.log(params)
    return post('/api/activity/saveexposure',params)
}

function shareScore(params){
    return post('/api/activity/relaysuccess',params)
}

function weiboInfo(params){
    console.log(params)
    return post('/api/universal/weibojsconfig',params)
}


var api = {
    post,

    sendVerifyCode,
    login,
    saveLabels,
    getCommentList,
    postNewComment,
    addCollection,
    removeCollection,
    getSuggest,
    getHotWords,
    searchInstitute,
    getInterestInstitute,
    searchNews,
    searchQuestion,
    getMycollect,
    focusquestion,
    getAnswerList,
    voteAnswer,
    like,
    unLike,
    sendFeedback,
    isCollect,
    switchRecommend,
    getAnswerIsAgrees,

    saveUserInfo,
    submit_test_data,
    loadMore,
    isLogin,
    thumbsUp,
    thumbsDown,
    exposure,
    redeem,
    redeemScore,
    shareScore,
    weiboInfo
};

function checkLoginOnReactNative(keys) {
    keys.forEach(key => {
        var fn = api[key];
        api[key] = function (...args) {
            if (!rnMixIn.methods.checkRNLogin()) {
                return Promise.reject('未登录');
            } else {
                return fn.apply(this, args);
            }
        }
    });
}

checkLoginOnReactNative(['saveLabels', 'postNewComment', 'addCollection', 'removeCollection', 'like', 'unlike', 'saveUserInfo', 'submit_test_data', 'voteAnswer', 'focusquestion']);

export default api;
