/*
* @Author: chenzhaoyang
* @Date:   2017-10-12 19:03:46
* @Last Modified by:   chenzhaoyang
* @Last Modified time: 2017-11-01 15:50:40
*/

'use strict';
import financeManagement from './refund.vue'
import capitalManage from './capitalManage.vue'
import orderQuery from './orderQuery.vue'


export default [
    {
        path: 'refund',
        name:'refundManage',
        component: financeManagement,
        meta: { privilege: 9}
    },
    {
      path: 'capital',
      name:'capitalManage',
      component: capitalManage,
        meta: { privilege:11}
    },
    {
        path: 'orderQuery',
        name: 'order',
        component: orderQuery,
         meta: { privilege:10}
    }
]
