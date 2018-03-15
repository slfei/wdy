
import * as ErrorHandle from './globalErrorHandle';
import axios from 'axios';

export default {
    getBank () {
        return axios.post('/api/proxy/capital/addpage')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    getType(){
    	return axios.post('/api/universal/currenttype')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    addInfo(ruleform){
    	return axios.post('/api/proxy/capital/addinfo',ruleform)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    initDate(){
    	return axios.post('/api/proxy/capital/updatepage')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    modify(ruleform){
    	return axios.post('/api/proxy/capital/updateinfo',ruleform)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    }
}
