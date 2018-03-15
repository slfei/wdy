
import axios from 'axios';
import * as globalErrorHandle from './globalErrorHandle';

export default {
    getInsType () {
        return axios.get('/api/institute/getinstype')
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },

    registerInstitute (data) {
        return axios.post('/api/institute/enter', data)
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
    },

    checkShowName (showName) {
        return axios.post('/api/institute/checkshowname', {
            ins_show_name: showName
        })
    },

    checkInstituteName (name) {
        return axios.post('/api/institute/checkinsname', {
            ins_show_name: name
        })
    },

    checkInstituteCode (code) {
        return axios.post('/api/institute/checkcode', {
            organization_code: code
        })
    },
    getInstituteInfo(){//获取机构资料数据
    	 return axios.get('/api/proxy/institute/info')
    },

    getEnterInfo () {
        return axios.get('/api/institute/info').then(globalErrorHandle.checkLoginAndApiError);
    },

    postInstituteInfo(data){//发送修改机构资料的数据
    	 return axios.post('/api/institute/enter',data)

    },
    getCountry(){
        return axios.post('/api/universal/getcountry')
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    sendCaptchaEmail(email, type) {
        return axios.get('/api/universal/sendcaptcha', {
            params: {
                email: email,
                type: type
            }
        }).then(globalErrorHandle.apiError, globalErrorHandle.networkStateError);
    }

}
