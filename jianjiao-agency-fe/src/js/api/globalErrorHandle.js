import {
  Message
} from 'element-ui';

//const passport = window.wdy.passport;

const CODE_MAP = {
  SUCCESS: 200,
  LOGIN: 605,
};


export function checkLogin(res) {
  if (res.data.status === CODE_MAP.LOGIN) {
    //未登录处理
    //passport.showView('login');
    throw new Error(res.data.msg);
  } else {
    return res.data;
  }
}


export function apiError(res) {
  if (res.data.status !== CODE_MAP.SUCCESS) {
    Message.error(res.data.msg);
  } else {
    return res.data.data;
  }
}

export function checkLoginAndApiError(res) {
  if (res.data.status === CODE_MAP.LOGIN) {
    //未登录处理
    //passport.showView('login');
    throw new Error(res.data.msg);
  }
  if (res.data.status == 705) {
    location.href = "//" + window.WWW_HOST
    return
  }
  if (res.data.status !== CODE_MAP.SUCCESS) {
    Message.error(res.data.msg);
    throw new Error(res.data.msg);
  } else {
    return res.data.data;
  }
}

export function networkStateError(error) {
  Message.error(error.toString() || '请求出错');
  throw new Error('网络错误');
}
