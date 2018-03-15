/*
* @Author: chenzhaoyang
* @Date:   2017-10-13 10:44:36
* @Last Modified by:   chenzhaoyang
* @Last Modified time: 2017-11-02 15:18:06
*/

'use strict';
import axios from 'axios';
import * as globalErrorHandle from '@/js/api/globalErrorHandle';

export default {
    getRefundList(params) { //获取退款数据列表
            return axios.post('/api/proxy/order/refundlist', params)
                .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        },
        confirmRefund(params){ // 确认退款
            return axios.post('/api/proxy/order/comfirmrefund', params)
                .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        },
        getOrderList(params){ // 获取订单数据
            return axios.post('/api/proxy/order/orderlist', params)
                .then(res=>res.data,globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
        },
}
