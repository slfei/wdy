
import * as  ErrorHandle from './globalErrorHandle';
import axios from 'axios';
export default {
    getSetting () {
        return axios.get('/api/institute/getshowpagedata')
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    getClass (data) {
        return axios.post('/api/proxy/course/letter',data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getTeacher (data) {
        return axios.get('/api/institute/getteacherlist', data)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    submitPersonSetting(data) {
        return axios.post('/api/institute/saveshowpagedata', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getTeacherSetting(data) {
        return axios.get('/api/personal/getshowpagedata', data)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    saveTeacherSetting(data) {
        return axios.post('/api/personal/saveshowpagedata', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getDiscount(params) {
        return axios.post('/api/activity/list', params)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    saveDiscount(data) {
        return axios.post('/api/activity/save', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    deleteDiscount(data) {
        return axios.post('/api/activity/delete', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getContactus(data) {
        return axios.get('/api/institute/getcontactus', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    saveContactus(data) {
        return axios.post('/api/institute/savecontactus', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getAboutus() {
        return axios.get('/api/institute/getaboutus')
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    saveAboutus(data) {
        return axios.post('/api/institute/saveaboutus', data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    getStudent(params){
        return axios.post('/api/activity/studentlist', params)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    preview(url,data){
        return axios.post(url,data)
            .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    }
}
