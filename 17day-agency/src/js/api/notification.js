import * as  ErrorHandle from './globalErrorHandle';
import axios from 'axios';


export default {
    list(data){
        return axios.post('/api/notice/list', data)
        .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    detail(id){
        return axios.post('/api/notice/detail', {
            id: id
        })
        .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
    livelist(data){
        return axios.post('/api/notice/livereminding', data)
        .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError);
    },
}
