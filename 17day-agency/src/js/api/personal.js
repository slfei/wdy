
import * as  ErrorHandle from './globalErrorHandle';
import axios from 'axios';

export default {
    registerPersonal (data) {
        return axios.post('/api/personal/enter', data)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },

    checkIdCode (id_code) {
        return axios.post('/api/personal/checkidcode', {
            id_code: id_code
        })
    },

    checkPassportCode(code) {
        return axios.post('/api/personal/checkpassortcode', {
            passport_code: code
        })
    },
    getPersonalInfo(){//获取个人后台的数据
    	 return axios.get('/api/proxy/personal/info')
    },
    getEnterInfo () {
        return axios.get('/api/personal/info').then(ErrorHandle.checkLoginAndApiError);
    },

    postPersonalInfo(data){//发送修改个人后台资料的数据
    	 return axios.post('/api/personal/enter',data).then(ErrorHandle.checkLoginAndApiError)
    },
    getPersonInfo(){ //个人信息的数据
    	return axios.get('/api/info/personalinfo')
    	 .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    unbind(){ //个人信息解绑
    	return axios.get('/api/info/unbind')
    	   .then(res=>res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    }
}
