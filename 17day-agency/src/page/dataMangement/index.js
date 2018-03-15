/*
* @Author: chenzhaoyang
* @Date:   2017-09-21 18:04:26
* @Last Modified by:   chenzhaoyang
* @Last Modified time: 2017-10-12 19:10:37
*/

'use strict';
import dataMangement from './dataList.vue'


export default [
    {
        path: 'data',
        name: 'dataManage',
        component: dataMangement,
        meta: { privilege: 15}
    }
]
