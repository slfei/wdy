
import * as ErrorHandle from './globalErrorHandle';
import axios from 'axios';

var privilege;

export default {
    isEnter () {
        return axios.post('/api/institute/isenter')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },

    getPrivilege () {
        if (privilege) {
            return Promise.resolve(privilege);
        } else {
           return axios.post('/api/universal/getaccessids')
            .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
            .then(data => privilege = data);
        }
    },

}
