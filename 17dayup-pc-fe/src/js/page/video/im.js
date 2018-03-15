import interactLive from './_interactLive';
import {i18n} from "../../lang/i18n";

// ===== listeners 
function onConnNotify() {

}

var CONFIG = {
};

var selSess;
var handledMsgID;

function onBigGroupMsgNotify(msgList) {
    console.log("===>")
    for (var i = msgList.length - 1; i >= 0; i--) { //遍历消息，按照时间从后往前
        var msg = msgList[i];
        if(!selSess){
            selSess = msg.getSession();
        }
        console.log(msg);
        if(handledMsgID == msg.random){ return; }
        showMsg(msg);
        handledMsgID = msg.random;        
        // webim.Log.error('receive a new group msg: ' + msg.getFromAccountNick());
        //显示收到的消息
    }
}

function onMsgNotify(data) {
    console.log("--->")
    onBigGroupMsgNotify(data);
}

function onGroupSystemNotifys(data) {
    console.log("group system notification ...")
    console.log(data);
}

function onGroupInfoChangeNotify(data) {
    // console.log(data);
}


// =====


function init(data) {
    login(data);
}

var CID = '';
var SID = '';

function getOnlineUserList(cid, sid) {
    CID = cid;
    SID = sid;

    return $.ajax({
        url: '/api/live/roomuserlist',
        data: {
            course_id: cid,
            section_id: sid,
            page_num: 0,
            page_size: 100
        }
    }).then(function (resp) {
        if (resp.status == 200) {
            return resp.data;
        }
    })
}

var loginInfo = {};
var selToID=null;

function login(data) {
    loginInfo = {
        sdkAppID: data.sdkappid,
        appIDAt3rd: data.sdkappid,
        accountType: data.account_type,
        identifier: data.identifier,
        // identifierNick,
        userSig: data.im_token
    }

    webim.login(loginInfo, {
        onBigGroupMsgNotify,
        onMsgNotify,
        onGroupSystemNotifys,
        onGroupInfoChangeNotify
    }, {
        isLogOn: false
    }, function (user) {
        console.log("----->")
        console.log(user);
        // 
        joinBigGroup(data);
    })
}



function joinBigGroup(data) {
    CONFIG.data = data;
    var options = {
        'GroupId': '' + data.im_group_id
    }
    selToID = options.GroupId;
    webim.applyJoinBigGroup(
        options,
        function (resp) {
            //JoinedSuccess:加入成功; WaitAdminApproval:等待管理员审批
            if (resp.JoinedStatus && resp.JoinedStatus == 'JoinedSuccess') {
                console.log('加入房间成功');
                sendOnlineNotify()
            } else {
                console.log('加入房间失败');
                return utils.toast($i18n('video.joinRoomError'));
            }
        },
        function (err) {
            console.log(err);
        }
    )
}

function renderUserList(cid, sid) {
    getOnlineUserList(cid, sid).then(function (data) {
        $(".user-num").html(`（${data.user_num}）`);

        var userListHtml = '';
        data.user_list.forEach(function (item) {
            var isOwner = item.user_id == ownerId;

            userListHtml += `<div class="user-item clearfix ${isOwner? 'is-owner':''}">
                <img class="thumbnail" src="${item.avatar_url}">
                <span class="user-type">（${ isOwner ? i18n('video.teacher') : i18n('video.student')}）</span>
                <span class="user-name">${item.nick_name.slice(0, 11)}</span>
            </div>`;
        })

        $(".content-user-list").html(userListHtml);
    })

    setTimeout(function () {
        renderUserList(cid, sid)
    }, 3000);
}

function sendTextMsg(){
    var self = $(".sent-btn");
    var content = $(".chat-input").val().trim()
    if (!content) {
        return utils.toast($i18n('video.sendText1'), 'error');
    } else if(content.length > 200){
        return utils.toast($i18n('video.sendText2'), "error");
    }else{
        $(".chat-input").val("");
    }

    sendMessage(content)
}

$(".sent-btn").on("click", sendTextMsg);
$(".chat-input").on("focus", function(){
    $(document).on("keyup presend", function(e){ 
        if(e.keyCode == 13){
            return sendTextMsg()
        }
    })
});

$(".chat-input").on("blur", function(){
    $(document).off("keyup presend");
});



function sendMessage(content) {
    sendMsg(content);

    return $.ajax({
        url: '/api/live/sendmsg',
        data: {
            course_id: CID,
            section_id: SID,
            text: content || $i18n('video.dataTest')
        }
    }).then(function (res) {
        if (res.status === 200) {
            return res.data;
        } else {
            // utils.toast(res.msg)
        }
    })

}


function sendHeartBeat(CID, SID) {
    $.ajax({
        url: '/api/live/heartbeat',
        data: {
            course_id: CID,
            section_id: SID,
            timestamp: new Date() - 0
        }
    }).then(function (res) {
        if (res.status === 200) {}
    })

    setTimeout(function () {
        sendHeartBeat(CID, SID);
    }, 3000)
}

window.sendMessage = sendMessage;

export default {
    init,
    renderUserList,
    sendHeartBeat,
    sendMsg
}


//显示消息（群普通+点赞+提示+红包）
function  showMsg(msg) {
    var isSelfSend, fromAccount, fromAccountNick, sessType, subType;
    var ul, li, paneDiv, textDiv, nickNameSpan, contentSpan;

    fromAccount = msg.getFromAccount();
    if (!fromAccount) {
        fromAccount = '';
    }
    fromAccountNick = msg.getFromAccountNick();
    if (!fromAccountNick) {
        fromAccountNick = $i18n('video.unknownUser');
    }
    ul = document.getElementById("video_sms_list");
    var maxDisplayMsgCount = 4;
    //var opacityStep=(1.0/4).toFixed(2);
    // var opacityStep = 0.2;
    // var opacity;
    // var childrenLiList = $("#video_sms_list").children();
    // if (childrenLiList.length == maxDisplayMsgCount) {
    //     $("#video_sms_list").children(":first").remove();
    //     for (var i = 0; i < maxDisplayMsgCount; i++) {
    //         opacity = opacityStep * (i + 1) + 0.2;
    //         $('#video_sms_list').children().eq(i).css("opacity", opacity);
    //     }
    // }
    li = document.createElement("li");
    paneDiv = document.createElement("div");

    var panelClass = fromAccount == ownerId ? "video-sms-pane is-owner" : "video-sms-pane";
    paneDiv.setAttribute('class', panelClass);

    textDiv = document.createElement("div");
    textDiv.setAttribute('class', 'video-sms-text message-item');
    nickNameSpan = document.createElement("div");

    var colorList = ['red', 'green', 'blue', 'org'];
    var index = Math.round(fromAccount.length % colorList.length);
    var color = colorList[index];
    nickNameSpan.setAttribute('class', 'chat-user user-name-' + color);
    nickNameSpan.innerHTML = fromAccountNick;
    contentSpan = document.createElement("div");
    contentSpan.setAttribute('class', 'chat-content')
    //解析消息
    //获取会话类型，目前只支持群聊
    //webim.SESSION_TYPE.GROUP-群聊，
    //webim.SESSION_TYPE.C2C-私聊，
    sessType = msg.getSession().type();
    //获取消息子类型
    //会话类型为群聊时，子类型为：webim.GROUP_MSG_SUB_TYPE
    //会话类型为私聊时，子类型为：webim.C2C_MSG_SUB_TYPE
    subType = msg.getSubType();

    isSelfSend = msg.getIsSend(); //消息是否为自己发的


    switch (subType) {

        case webim.GROUP_MSG_SUB_TYPE.COMMON: //群普通消息
            var html = convertMsgtoHtml(msg);
            if (!html) {
                return;
            }
            contentSpan.innerHTML = html;
            break;
        case webim.C2C_MSG_SUB_TYPE.COMMON:
            var html = convertMsgtoHtml(msg);
            break;    
        case webim.GROUP_MSG_SUB_TYPE.REDPACKET: //群红包消息
            contentSpan.innerHTML = $i18n('video.subType.type1') + convertMsgtoHtml(msg);
            break;
        case webim.GROUP_MSG_SUB_TYPE.LOVEMSG: //群点赞消息
            //业务自己可以增加逻辑，比如展示点赞动画效果
            contentSpan.innerHTML =  $i18n('video.subType.type2') + convertMsgtoHtml(msg);
            //展示点赞动画
            showLoveMsgAnimation();
            break;
        case webim.GROUP_MSG_SUB_TYPE.TIP: //群提示消息
            return
            contentSpan.innerHTML =  $i18n('video.subType.type3') + convertMsgtoHtml(msg);
            break;
        default:
            // console.log("custom");
            interactLive.handle(msg);
            return
    }
    textDiv.appendChild(nickNameSpan);
    textDiv.appendChild(contentSpan);

    paneDiv.appendChild(textDiv);
    li.appendChild(paneDiv);
    ul.appendChild(li);
    $('#video_sms_list').scrollTop(20000000);
}


//把消息转换成Html
function convertMsgtoHtml(msg) {
    var html = "",
        elems, elem, type, content;
    elems = msg.getElems(); //获取消息包含的元素数组
    for (var i in elems) {
        elem = elems[i];
        type = elem.getType(); //获取元素类型
        content = elem.getContent(); //获取元素对象
        console.log(type);
        switch (type) {
            case webim.MSG_ELEMENT_TYPE.TEXT:
                html += convertTextMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.FACE:
                html += convertFaceMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.IMAGE:
                html += convertImageMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.SOUND:
                html += convertSoundMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.FILE:
                html += convertFileMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.LOCATION: //暂不支持地理位置
                //html += convertLocationMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.CUSTOM:
                console.log("handle content");
                interactLive.handle(content);
                //     // html += convertCustomMsgToHtml(content);
                break;
            case webim.MSG_ELEMENT_TYPE.GROUP_TIP:
                html += convertGroupTipMsgToHtml(content);
                break;
            default:
                webim.Log.error($i18n('video.msgTypeUnknow') + ': elemType=' + type);
                break;
        }
    }
    return html;
}


//解析文本消息元素
function convertTextMsgToHtml(content) {
    return content.getText();
}

//解析表情消息元素
function convertFaceMsgToHtml(content) {
    var index = content.getIndex();
    var data = content.getData();
    var url = null;
    var emotion = webim.Emotions[index];
    if (emotion && emotion[1]) {
        url = emotion[1];
    }
    if (url) {
        return "<img src='" + url + "'/>";
    } else {
        return data;
    }
}

//解析图片消息元素
function convertImageMsgToHtml(content) {
    var smallImage = content.getImage(webim.IMAGE_TYPE.SMALL); //小图
    var bigImage = content.getImage(webim.IMAGE_TYPE.LARGE); //大图
    var oriImage = content.getImage(webim.IMAGE_TYPE.ORIGIN); //原图
    if (!bigImage) {
        bigImage = smallImage;
    }
    if (!oriImage) {
        oriImage = smallImage;
    }
    return "<img src='" + smallImage.getUrl() + "#" + bigImage.getUrl() + "#" + oriImage.getUrl() + "' style='CURSOR: hand' id='" + content.getImageId() + "' bigImgUrl='" + bigImage.getUrl() + "' onclick='imageClick(this)' />";
}

//解析语音消息元素
function convertSoundMsgToHtml(content) {
    var second = content.getSecond(); //获取语音时长
    var downUrl = content.getDownUrl();
    if (webim.BROWSER_INFO.type == 'ie' && parseInt(webim.BROWSER_INFO.ver) <= 8) {
        return $i18n('video.voiceMsgPrompt') + downUrl;
    }
    return '<audio src="' + downUrl + '" controls="controls" onplay="onChangePlayAudio(this)" preload="none"></audio>';
}

//解析文件消息元素
function convertFileMsgToHtml(content) {
    var fileSize = Math.round(content.getSize() / 1024);
    /*return '<a href="' + content.getDownUrl() + '" title="点击下载文件" ><i class="glyphicon glyphicon-file">&nbsp;' + content.getName() + '(' + fileSize + 'KB)</i></a>';*/
    return `<a href="${content.getDownUrl()}" title="${$i18n('video.downloadFile')}">
                <i class="glyphicon glyphicon-file">&nbsp;${content.getName()}(${fileSize}KB)</i>
            </a>`
}


//解析位置消息元素
function convertLocationMsgToHtml(content) {
    /*return '经度=' + content.getLongitude() + ',纬度=' + content.getLatitude() + ',描述=' + content.getDesc();*/
    return `${$i18n('video.location.locationMsg')}=${content.getLongitude()},${$i18n('video.location.dimensionality')}=${content.getLatitude()},${$i18n('video.location.desc')}=${content.getDesc()}`;
}


//解析自定义消息元素
function convertCustomMsgToHtml(content) {
    var data = content.getData();
    var desc = content.getDesc();
    var ext = content.getExt();
    return "data=" + data + ", desc=" + desc + ", ext=" + ext;
}


//解析群提示消息元素
function convertGroupTipMsgToHtml(content) {
    var WEB_IM_GROUP_TIP_MAX_USER_COUNT = 10;
    var text = "";
    var maxIndex = WEB_IM_GROUP_TIP_MAX_USER_COUNT - 1;
    var opType, opUserId, userIdList;
    opType = content.getOpType(); //群提示消息类型（操作类型）
    opUserId = content.getOpUserId(); //操作人id
    switch (opType) {
        case webim.GROUP_TIP_TYPE.JOIN: //加入群
            userIdList = content.getUserIdList();
            //text += opUserId + "邀请了";
            for (var m in userIdList) {
                text += userIdList[m] + ",";
                if (userIdList.length > WEB_IM_GROUP_TIP_MAX_USER_COUNT && m == maxIndex) {
                    text += $i18n('video.msgGroup.await') + userIdList.length + $i18n('video.msgGroup.men');
                    break;
                }
            }
            text += $i18n('video.msgGroup.joinGroup');
            break;
        case webim.GROUP_TIP_TYPE.QUIT: //退出群
            text += opUserId + $i18n('video.msgGroup.quitGroup');
            break;
        case webim.GROUP_TIP_TYPE.KICK: //踢出群
            text += opUserId + $i18n('video.msgGroup.will');
            userIdList = content.getUserIdList();
            for (var m in userIdList) {
                text += userIdList[m] + ",";
                if (userIdList.length > WEB_IM_GROUP_TIP_MAX_USER_COUNT && m == maxIndex) {
                    text += $i18n('video.msgGroup.await') + userIdList.length + $i18n('video.msgGroup.men');
                    break;
                }
            }
            text += $i18n('video.msgGroup.kickOut');
            break;
        case webim.GROUP_TIP_TYPE.SET_ADMIN: //设置管理员
            text += opUserId + $i18n('video.msgGroup.will');
            userIdList = content.getUserIdList();
            for (var m in userIdList) {
                text += userIdList[m] + ",";
                if (userIdList.length > WEB_IM_GROUP_TIP_MAX_USER_COUNT && m == maxIndex) {
                    text += $i18n('video.msgGroup.await') + userIdList.length + $i18n('video.msgGroup.men');
                    break;
                }
            }
            text += $i18n('video.msgGroup.SetAdministrator');
            break;
        case webim.GROUP_TIP_TYPE.CANCEL_ADMIN: //取消管理员
            text += opUserId + $i18n('video.msgGroup.cancel');
            userIdList = content.getUserIdList();
            for (var m in userIdList) {
                text += userIdList[m] + ",";
                if (userIdList.length > WEB_IM_GROUP_TIP_MAX_USER_COUNT && m == maxIndex) {
                    text += $i18n('video.msgGroup.await') + userIdList.length + $i18n('video.msgGroup.men');
                    break;
                }
            }
            text += $i18n('video.msgGroup.AdministratorQualification');
            break;

        case webim.GROUP_TIP_TYPE.MODIFY_GROUP_INFO: //群资料变更
            text += opUserId + $i18n('video.msgGroup.alterGroupData');
            var groupInfoList = content.getGroupInfoList();
            var type, value;
            for (var m in groupInfoList) {
                type = groupInfoList[m].getType();
                value = groupInfoList[m].getValue();
                switch (type) {
                    case webim.GROUP_TIP_MODIFY_GROUP_INFO_TYPE.FACE_URL:
                        text += $i18n('video.msgGroup.img') + value + "; ";
                        break;
                    case webim.GROUP_TIP_MODIFY_GROUP_INFO_TYPE.NAME:
                        text += $i18n('video.msgGroup.name') + value + "; ";
                        break;
                    case webim.GROUP_TIP_MODIFY_GROUP_INFO_TYPE.OWNER:
                        text += $i18n('video.msgGroup.groupOwner') + value + "; ";
                        break;
                    case webim.GROUP_TIP_MODIFY_GROUP_INFO_TYPE.NOTIFICATION:
                        text += $i18n('video.msgGroup.groupNotice') + value + "; ";
                        break;
                    case webim.GROUP_TIP_MODIFY_GROUP_INFO_TYPE.INTRODUCTION:
                        text += $i18n('video.msgGroup.groupDesc') + value + "; ";
                        break;
                    default:
                        text += $i18n('video.msgGroup.unknowMsg') + "type=" + type + ",value=" + value + "; ";
                        break;
                }
            }
            break;

        case webim.GROUP_TIP_TYPE.MODIFY_MEMBER_INFO: //群成员资料变更(禁言时间)
            text += opUserId + $i18n('video.msgGroup.alterUserinfo');
            var memberInfoList = content.getMemberInfoList();
            var userId, shutupTime;
            for (var m in memberInfoList) {
                userId = memberInfoList[m].getUserId();
                shutupTime = memberInfoList[m].getShutupTime();
                text += userId + ": ";
                if (shutupTime != null && shutupTime !== undefined) {
                    if (shutupTime == 0) {
                        text += $i18n('video.msgGroup.cancelShutup');
                    } else {
                        text += $i18n('video.msgGroup.shutup') + shutupTime + $i18n('video.msgGroup.second');
                    }
                } else {
                    text += $i18n('video.msgGroup.shutupTimeRequired');
                }
                if (memberInfoList.length > WEB_IM_GROUP_TIP_MAX_USER_COUNT && m == maxIndex) {
                    text += $i18n('video.msgGroup.await') + memberInfoList.length +  $i18n('video.msgGroup.men');
                    break;
                }
            }
            break;
        default:
            text += $i18n('video.msgGroup.msgTypeUnknown') + "type=" + opType;
            break;
    }
    return text;
}

// var selSess = null;
//发送消息(普通消息)
function sendMsg(text) {
    if (!loginInfo.identifier) { //未登录
        // if (accountMode == 1) { //托管模式
        //     //将account_type保存到cookie中,有效期是1天
        //     webim.Tool.setCookie('accountType', loginInfo.accountType, 3600 * 24);
        //     //调用tls登录服务
        //     tlsLogin();
        // } else { //独立模式
        //     //to do
        // }
        return;
    }

    // if (!selToID) {
    //     alert("您还没有进入房间，暂不能聊天");
    //     $("#send_msg_text").val('');
    //     return;
    // }
    //获取消息内容
    var msgtosend = text;
    var msgLen = webim.Tool.getStrBytes(msgtosend);

    if (msgtosend.length < 1) {
        // alert("发送的消息不能为空!");
        return;
    }

    var maxLen, errInfo;
    var selType = webim.SESSION_TYPE.GROUP;
    if (selType == webim.SESSION_TYPE.GROUP) {
        maxLen = webim.MSG_MAX_LENGTH.GROUP;
        errInfo = $i18n('video.sendMsg.text1') + Math.round(maxLen / 3) + $i18n('video.sendMsg.text2');
    } else {
        maxLen = webim.MSG_MAX_LENGTH.C2C;
        errInfo = $i18n('video.sendMsg.text1') + Math.round(maxLen / 3) + $i18n('video.sendMsg.text2');
    }
    if (msgLen > maxLen) {
        alert(errInfo);
        return;
    }

    // if (!selSess) {
        // selSess = new webim.Session(selType, '150877', '150877', '', Math.round(new Date().getTime() / 1000));
    //     console.log(selType, '' + selToID);
    //     selSess = webim.MsgStore.sessByTypeId(selType, selToID);
    // }
    console.log(selSess);
    var isSend = true; //是否为自己发送
    var seq = -1; //消息序列，-1表示sdk自动生成，用于去重
    var random = Math.round(Math.random() * 4294967296); //消息随机数，用于去重
    var msgTime = Math.round(new Date().getTime() / 1000); //消息时间戳
    var subType; //消息子类型
    if (selType == webim.SESSION_TYPE.GROUP) {
        //群消息子类型如下：
        //webim.GROUP_MSG_SUB_TYPE.COMMON-普通消息,
        //webim.GROUP_MSG_SUB_TYPE.LOVEMSG-点赞消息，优先级最低
        //webim.GROUP_MSG_SUB_TYPE.TIP-提示消息(不支持发送，用于区分群消息子类型)，
        //webim.GROUP_MSG_SUB_TYPE.REDPACKET-红包消息，优先级最高
        subType = webim.GROUP_MSG_SUB_TYPE.COMMON;

    } else {
        //C2C消息子类型如下：
        //webim.C2C_MSG_SUB_TYPE.COMMON-普通消息,
        subType = webim.C2C_MSG_SUB_TYPE.COMMON;
    }
    console.log(selSess, isSend, seq, random, msgTime, loginInfo.identifier, subType, loginInfo.identifierNick);

    var msg = new webim.Msg(selSess, isSend, seq, random, msgTime, loginInfo.identifier, subType, loginInfo.identifierNick);
    //解析文本和表情
    var expr = /\[[^[\]]{1,3}\]/mg;
    var emotions = msgtosend.match(expr);
    var text_obj, face_obj, tmsg, emotionIndex, emotion, restMsgIndex;
    if (!emotions || emotions.length < 1) {
        text_obj = new webim.Msg.Elem.Text(msgtosend);
        msg.addText(text_obj);
    } else { //有表情

        for (var i = 0; i < emotions.length; i++) {
            tmsg = msgtosend.substring(0, msgtosend.indexOf(emotions[i]));
            if (tmsg) {
                text_obj = new webim.Msg.Elem.Text(tmsg);
                msg.addText(text_obj);
            }
            emotionIndex = webim.EmotionDataIndexs[emotions[i]];
            emotion = webim.Emotions[emotionIndex];
            if (emotion) {
                face_obj = new webim.Msg.Elem.Face(emotionIndex, emotions[i]);
                msg.addFace(face_obj);
            } else {
                text_obj = new webim.Msg.Elem.Text(emotions[i]);
                msg.addText(text_obj);
            }
            restMsgIndex = msgtosend.indexOf(emotions[i]) + emotions[i].length;
            msgtosend = msgtosend.substring(restMsgIndex);
        }
        if (msgtosend) {
            text_obj = new webim.Msg.Elem.Text(msgtosend);
            msg.addText(text_obj);
        }
    }
    webim.sendMsg(msg, function (resp) {
        // console.log("===>")
        // if (selType == webim.SESSION_TYPE.C2C) { //私聊时，在聊天窗口手动添加一条发的消息，群聊时，长轮询接口会返回自己发的消息
            // showMsg(msg);
        // }
        // webim.Log.info("发消息成功");
        // $("#send_msg_text").val('');
        // hideDiscussForm(); //隐藏评论表单
        // showDiscussTool(); //显示评论工具栏
        // hideDiscussEmotion(); //隐藏表情
    }, function (err) {
        webim.Log.error($i18n('video.sendMsg.error1') + err.ErrorInfo);
        // alert("发消息失败:" + err.ErrorInfo);
        console.log(err);
        utils.toast($i18n('video.sendMsg.error2'));
    });
}

// window.sendMsg = sendMsg;

function objToString(obj){
    var str = '';

    for(var k in obj){
        str += `${k}:${obj[k]},`;
    }

    return str.slice(0, -1);
}

function sendCustomMsg(str) {
    var selToID = CONFIG.data.im_group_id
    if (!selToID) {
        return;
    }
    var ext = {"id":CONFIG.data.identifier};
    // var msgLen = webim.Tool.getStrBytes(data);

    var selType = webim.SESSION_TYPE.GROUP;
    if (!selSess) {
        selSess = new webim.Session(selType, selToID, selToID, Math.round(new Date().getTime() / 1000));
    }
    var msg = new webim.Msg(selSess, true,-1,-1,-1,loginInfo.identifier,0,loginInfo.identifierNick);
    var custom_obj = new webim.Msg.Elem.Custom(str,'',ext);
    msg.addCustom(custom_obj);
    //调用发送消息接口
    webim.sendMsg(msg, function (resp) {
        // showMsg(msg);
        // console.log(msg,'自定义消息成功')
    }, function (err) {
        // alert(err.ErrorInfo);
    });
}

function sendOnlineNotify(){
    sendCustomMsg(JSON.stringify({
        "userAction":12,
        "actionParam": objToString({
            "id": CONFIG.data.identifier,
            "name": CONFIG.data.nick_name,
            "allowchat":1,
            "role":1
        })
    }))
}

window.sendCustomMsg = sendCustomMsg;
