import * as ErrorHandle from './globalErrorHandle';
import axios from 'axios';
export default {
    step1_mes (params) {
        return axios.post('/api/proxy/course/saveone',params)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
	getType() { //获取课程数据种类
        return axios.post('/api/proxy/course/category')
    },
    getFile() { //获取资料
        return axios.post('/api/proxy/material/fileletter')
    },
    getCourse() { //获取关联课程
        return axios.post('/api/proxy/course/letter')
    },
    getTeacher(){//获取老师
    	return axios.post('/api/institute/getteacherlist')
    },
    getBank(){//获取是否关联银行
        return axios.post('/api/proxy/course/bank')
    },
    getAccType(){
        return axios.post('/api/universal/currenttype')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    getVideo(){//获取视频
    	return axios.post('/api/proxy/material/letter')
    },
    step2_mes (params) {
        return axios.post('/api/proxy/course/savetwo',params)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    step3_mes (params) {
        return axios.post('/api/proxy/course/savethree',params)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    step4_mes (params) {
        return axios.post('/api/proxy/course/savefour',params)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    preview (){
        return axios.post('/api/proxy/course/preview')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
        },
    submit (){
        return axios.post('/api/proxy/course/submit')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    checkDraft(){
        return axios.post('/api/proxy/course/isdraft')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    }

}
