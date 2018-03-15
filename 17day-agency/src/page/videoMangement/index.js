/*
* @Author: chenzhaoyang
* @Date:   2017-09-22 18:47:23
* @Last Modified by:   chenzhaoyang
* @Last Modified time: 2017-10-16 16:25:59
*/

'use strict';
import videoMangement from './videoList.vue'


export default [
    {
        path: 'video',
        name: 'videoManage',
        component: videoMangement,
         meta: { privilege:16}
    }
]
