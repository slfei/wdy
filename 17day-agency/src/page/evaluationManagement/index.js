/* 
* @Author: chenzhaoyang
* @Date:   2017-10-27 16:48:47
* @Last Modified by:   chenzhaoyang
* @Last Modified time: 2017-10-31 19:57:33
*/

'use strict';


import evaluationManagement from './evaluationList.vue'


export default [
    {
        path: 'evaluation',
        name:'commentManage',
        component: evaluationManagement,
         meta: { privilege: 17}
    }
]
