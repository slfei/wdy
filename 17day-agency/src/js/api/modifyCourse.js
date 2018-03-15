import * as ErrorHandle from './globalErrorHandle';
import axios from 'axios';

export default {
    checkone (courseid) {
        return axios.post('/api/proxy/course/checkone',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    checktwo (courseid) {
        return axios.post('/api/proxy/course/checktwo',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    checkthree (courseid) {
        return axios.post('/api/proxy/course/checkthree',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    checkfour (courseid) {
        return axios.post('/api/proxy/course/checkfour',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    submit (courseid) {
        return axios.post('/api/proxy/course/submit',courseid)
            // .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    preview (courseid) {
        return axios.post('/api/proxy/course/preview',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    revoke (courseid){
        return axios.post('/api/proxy/course/revokesubmit',courseid)
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    }
}