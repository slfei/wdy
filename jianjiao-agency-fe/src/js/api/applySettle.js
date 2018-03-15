'use strict';

import axios from 'axios';
import * as ErrorHandler from './globalErrorHandle.js'
export default {
  getInstitutionList(params) { //机构列表
    return axios.post('/bizapi/claim/institutelist', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  submitform(params) { // 提交 入驻  创建机构
    return axios.post('/bizapi/claim/commit', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getCategory() { //主营类目
    return axios.post('/bizapi/claim/categorylist')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getStatus() { // 获取状态  (-1未认领，0提交审核，1审核成功，2审核失败 )
    return axios.post('/bizapi/claim/getstatus')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  checkName(params) { // 机构名是否重复
    return axios.post('/bizapi/claim/checkname', params)
  },
  checkCode(params) { // 统一社会信用代码是否重复
    return axios.post('/bizapi/claim/checkcode', params)
  },
  setDraftData(params) { // 存入草稿箱
    return axios.post('/bizapi/claim/draft', params)
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
  getClaimInfo() { // 数据回显
    return axios.post('/bizapi/claim/claiminfo')
      .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
  },
}
