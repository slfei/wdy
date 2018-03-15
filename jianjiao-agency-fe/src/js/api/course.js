'use strict';

import axios from 'axios';
import * as ErrorHandler from './globalErrorHandle.js'
export default {
  saveCourse(params) { //保存课程信息
    return axios.post('/bizapi/course/save', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getList(params) { //获取列表
    return axios.post('/bizapi/course/list', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getNum() {
    return axios.post('/bizapi/course/listinfo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  checkReason(params) { //查看理由
    return axios.post('/bizapi/course/reason', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  offLine(params) { //下线课程
    return axios.post('/bizapi/course/offline', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  courseInfo(params) { //下线课程
    return axios.post('/bizapi/course/info', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },

}
