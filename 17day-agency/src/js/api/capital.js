import axios from 'axios';
import * as errorHandle from './globalErrorHandle'

export default {
    getCapital(data) { //获取资金管理展示的页面数据
        return axios.post('/api/proxy/capital/capital',data)
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    },
    withdraw(data) { //提现操作
        return axios.post('/api/proxy/capital/withdrawal',data)
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    },
    incomelist(data) { //收入列表
        return axios.post('/api/proxy/capital/incomelist',data)
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    },
    getBankInfo(data) { //银行账户信息
        return axios.post('/api/proxy/capital/bankinfo',data)
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    },
    getWithdrawList(data) { //提现列表
        return axios.post('/api/proxy/capital/list',data)
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    },
    getAccountInfo() {
      return axios.post('/api/universal/getmembership')
          .then(res=>res.data,errorHandle.apiError, errorHandle.networkStateError);
    }
}