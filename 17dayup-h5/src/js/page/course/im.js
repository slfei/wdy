import common from '../../common'
import interactLive from './_interactLive';
// ===== listeners 
window.roomStatus=0;
function onConnNotify(){
}
function onBigGroupMsgNotify(msgList){
    for (var i = msgList.length - 1; i >= 0; i--) {//遍历消息，按照时间从后往前
        var msg = msgList[i];
        // webim.Log.error('receive a new group msg: ' + msg.getFromAccountNick());
        //显示收到的消息
        showMsg(msg);
    }
}
function onMsgNotify(data){
    // console.log("msg notify")
    console.log(data);
}
function onGroupSystemNotifys(data){
    // console.log("group system notification ...")
    console.log(data);
}
function onGroupInfoChangeNotify(data){
    // console.log(data);
}
// =====
function init(data){
    login(data);
}
var loginInfo={};
var selToID=null;
var selSess = null;//当前聊天会话
var selType = webim.SESSION_TYPE.GROUP;

function login(data){
    loginInfo = {
        sdkAppID: data.sdkappid,
        appIDAt3rd: data.sdkappid,
        accountType: data.account_type,
        identifier: data.identifier,//用户id
        nick_name: data.nick_name,
        im_group_id:data.im_group_id,//房间id
        userSig: data.im_token
    }
    webim.login(loginInfo, {
        onBigGroupMsgNotify,
        onMsgNotify,
        onGroupSystemNotifys,
        onGroupInfoChangeNotify,
    }, {
        isLogOn: false
    }, function(user){
        console.log(user)
        joinBigGroup(data,user); 

    })
    window.data=data;
}
//加入房间
function joinBigGroup(data,user){
    var options = {
        'GroupId': '' + loginInfo.im_group_id
    }
    selToID = options.GroupId;
    webim.applyJoinBigGroup(
        options,
        function(resp){
            //JoinedSuccess:加入成功; WaitAdminApproval:等待管理员审批
            if (resp.JoinedStatus && resp.JoinedStatus == 'JoinedSuccess') {
                //id:用户id;name:用户昵称;allowchat：否可以聊天;role:角色;
                sendCustomMsg(JSON.stringify({
                    "userAction":12,
                    "actionParam": objToString({
                        "id": loginInfo.identifier,
                        "name":loginInfo.nick_name,
                        "allowchat":data.allow_chat,
                        "role":data.role
                    })
                }))
               // console.log('加入房间成功');
            } else {
                return common.ui.topTips('加入房间失败');
            }            
        }, function(err){
            console.log(err);
        }
    )
}

//退出房间
function quitBigGroup() {
    // console.log(loginInfo.im_group_id)
    var options = {
        'GroupId': '' + loginInfo.im_group_id
    };
    webim.quitBigGroup(
        options,
        function(resp) {
            sendCustomMsg(JSON.stringify({
                "userAction":13,
                "actionParam": objToString({
                    "id": loginInfo.identifier
                })
            }))
            console.log("退出房间成功");
        },
        function(err) {
            console.log(err.ErrorInfo);
        }
    );
};

export default {
    init,
    quitBigGroup
}
//显示消息（群普通+点赞+提示+红包）
function showMsg(msg){
    var isSelfSend, fromAccount, fromAccountNick, sessType, subType;
    var ul, li, paneDiv, textDiv, nickNameSpan, contentSpan;
    fromAccount = msg.getFromAccount();
    if (!fromAccount) {
        fromAccount = '';
    }
    fromAccountNick = msg.getFromAccountNick();
    // if (!fromAccountNick) {
    //     fromAccountNick = '未知用户';
    // }
    // ul = document.getElementById("video_sms_list");
    var maxDisplayMsgCount = 4;

    //解析消息
    //获取会话类型，目前只支持群聊
    //webim.SESSION_TYPE.GROUP-群聊，
    //webim.SESSION_TYPE.C2C-私聊，
    sessType = msg.getSession().type();
    //获取消息子类型
    //会话类型为群聊时，子类型为：webim.GROUP_MSG_SUB_TYPE
    //会话类型为私聊时，子类型为：webim.C2C_MSG_SUB_TYPE
    subType = msg.getSubType();
    isSelfSend = msg.getIsSend();//消息是否为自己发的
    switch (subType) {
        case webim.GROUP_MSG_SUB_TYPE.COMMON://群普通消息
            convertMsgtoHtml(msg);
            break;
    }
}
//把消息转换成Html
function convertMsgtoHtml(msg) {
    var html = "", elems,elem, type, content;
    elems=msg.getElems();//获取消息包含的元素数组
    for (var i in elems) {
        elem = elems[i];
        type = elem.getType();//获取元素类型
        content = elem.getContent();//获取元素对象
        switch (type) {
            case webim.MSG_ELEMENT_TYPE.CUSTOM:
                interactLive.handle(content);
                convertCustomMsgToHtml(content);
                break;
        }
    }
}

// 解析自定义消息元素
function convertCustomMsgToHtml(content) {
    var data = content.getData();
    var desc = content.getDesc();
    var ext = content.getExt();
    var $vcpPlayer=$('.vcp-player'),
        errorTips=$vcpPlayer.find('.vcp-error-tips-new').length;
    if(data==6){//下课
        tipsMsg(errorTips,'直播已结束，学习愉快！');
        clearTimeout(window.timeout)
    }else if(data==7){
        tipsMsg(errorTips,'老师正在调试中，请稍后！')
    }else if(data==5){
        $('.vcp-error-tips-new').remove()
    }
}

function objToString(obj){
    var str = '';
    for(var k in obj){
        str += `${k}:${obj[k]},`;
    }
    return str.slice(0, -1);
}
//发送自定义消息
function sendCustomMsg(customData) {
    // console.log(customData);
    selToID = loginInfo.im_group_id;
    if (!selToID) {
        return;
    }
    var msgLen = webim.Tool.getStrBytes(data);
    if (!selSess) {
        selSess = new webim.Session(selType, selToID, selToID,'', Math.round(new Date().getTime() / 1000));
    }
    var msg = new webim.Msg(selSess, true,-1,-1,-1,loginInfo.identifier,0,loginInfo.identifierNick);
    var custom_obj = new webim.Msg.Elem.Custom(customData,'','');
    msg.addCustom(custom_obj);
    //调用发送消息接口
    webim.sendMsg(msg, function (resp) {
        showMsg(msg);
    }, function (err) {
        console.log(err.ErrorInfo);
    });
}

function tipsMsg(errorTips,msg){
    if(errorTips){
        $('.vcp-error-tips-new').remove()
    }
    $('.vcp-player').prepend(`<div class=vcp-error-tips-new><p>${msg}</p></div>`)
}
