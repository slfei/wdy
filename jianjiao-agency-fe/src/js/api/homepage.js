'use strict';

import axios from 'axios';
import * as ErrorHandler from './globalErrorHandle.js'
export default {
  insInfo() { //保存课程信息
    return axios.post('/bizapi/manage/instituteinfo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  announce() { //保存课程信息
    return axios.post('/bizapi/manage/announcement')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  todo() { //保存课程信息
    return axios.post('/bizapi/manage/todo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },

}
