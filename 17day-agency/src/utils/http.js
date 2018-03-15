/*
 * @Author: chenzhaoyang
 * @Date:   2017-10-09 14:18:18
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-10-13 19:05:07
 */

'use strict';
import axios from 'axios';
import * as globalErrorHandle from '@/js/api/globalErrorHandle';

export default {
    getDataList(params) { //获取资料列表数据
        return axios.post('/api/proxy/material/filelist', params)
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
    },
    delfile(params) { //资料列表删除资料
        return axios.post('/api/proxy/material/delfile', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    savefile(params) { //修改文件名
        return axios.post('/api/proxy/material/savefile', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    checkdelfile(params) { // 文件是否关联课程
        return axios.post('/api/proxy/material/checkdelfile', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    }
}
