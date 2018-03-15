/*
 * @Author: chenzhaoyang
 * @Date:   2017-10-11 13:45:22
 * @Last Modified by:   chenzhaoyang
 * @Last Modified time: 2017-11-13 19:16:29
 */

'use strict';
import axios from 'axios';
import * as globalErrorHandle from '@/js/api/globalErrorHandle';

export default {
    getInstituteId() { // 获取 institute_id
        return axios.post('/api/universal/currenttype').then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    getAlbumList(params) { //获取合辑列表数据
        return axios.post('/api/proxy/material/album', params)
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
    },
    getVideoList(params) { //获取合辑下的视频列表数据
        return axios.post('/api/proxy/material/video', params)
            .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
    },
    delfile(params) { //资料列表删除资料
        return axios.post('/api/proxy/material/delvideo', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    savealbum(params) { //修改合辑文件名
        return axios.post('/api/proxy/material/savealbum', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);

    },
    deleteAlbum(params) { //删除合辑
        return axios.post('/api/proxy/material/delalbum', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);

    },
    saveChildrenFile(params) { //修改单个视频文件名
        return axios.post('/api/proxy/material/savevideo', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);

    },
    delChildrenFile(params) { //删除单个视频文件名
        return axios.post('/api/proxy/material/delvideo', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    getAlbumNameList(params) { // 获取视频所属分类列表
        return axios.post('/api/proxy/material/albumname', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);

    },
    moveAlbum(params) { //转移到其他分类
        return axios.post('/api/proxy/material/movealbum', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    checkdelvideo(params) { //视频是否关联课程
        return axios.post('/api/proxy/material/checkdelvideo', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    checkdelAlbum(params) { //合辑是否可删除
        return axios.post('/api/proxy/material/checkdelalbum', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    getCourseList(params) { //直播回放课程列表
        return axios.post('/api/proxy/material/courselist', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    },
    getPlayBackList(params) { //直播课程列表
        return axios.post('/api/proxy/material/playbacklist', params).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError);
    }
}
