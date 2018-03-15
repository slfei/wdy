/* 
 * @Author: chenzhaoyang
 * @Date:   2017-10-27 19:54:17
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-10-30 12:02:29
 */

'use strict';
import axios from 'axios';
import * as globalErrorHandle from '@/js/api/globalErrorHandle';

export default {
    getEvaluationList(params) { // 评价列表
            return axios.post('/api/proxy/comment/list', params)
                .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        },
        getCourseList() { // 课程名称列表
            return axios.post('/api/proxy/course/letter')
                .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        },
        saveReply(params) { // 回复/修改回复
            return axios.post('/api/proxy/comment/saveanswer',params)
                .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        }

}
