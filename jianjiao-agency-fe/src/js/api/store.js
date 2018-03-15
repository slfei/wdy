'use strict';

import axios from 'axios';
import * as ErrorHandler from './globalErrorHandle.js'
export default {
  getBaseInfo() { //信息回显 - 基本信息
    return axios.post('/bizapi/institute/insinfo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getDesInfo() { //信息回显 - 招生信息
    return axios.post('/bizapi/institute/desinfo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getCategoryList() { //主营类目
    return axios.post('/bizapi/institute/categorylist')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },


}
