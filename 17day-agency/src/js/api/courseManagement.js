import * as ErrorHandle from './globalErrorHandle';
import axios from 'axios';

export default {
    getListInfo () {
        return axios.post('/api/proxy/course/listinfo')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    getList (params) {
        return axios.post('/api/proxy/course/list',params)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    getCheckOpinions(id){
		return axios.post('/api/proxy/course/reason',id)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    checkDraft(){
        return axios.post('/api/proxy/course/isdraft')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    delDraft(){
        return axios.post('/api/proxy/course/deldraft')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    }
}