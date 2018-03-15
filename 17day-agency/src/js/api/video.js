/*
 * @Author: chenzhaoyang
 * @Date:   2017-10-12 14:36:42
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-10-16 18:09:26
 */

'use strict';

import axios from 'axios';
import * as ErrorHandler from './globalErrorHandle.js'
export default {
    getToken() {
        return axios.get('/api/universal/getststoken')
            .then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
    },

    uploadMedia(params) {
        return axios.post('/api/universal/uploadmedia', params).then(ErrorHandler.checkLoginAndApiError, ErrorHandler.networkStateError);
    }
}
