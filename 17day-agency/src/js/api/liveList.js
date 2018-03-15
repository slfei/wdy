import axios from 'axios';
import * as errorHandle from './globalErrorHandle'

export default {
    getLiveList(data) { 
        return axios.post('/api/proxy/course/livelist',data)
          .then(errorHandle.apiError, errorHandle.networkStateError);
    }, 
    getSevenDay(data) {
        return axios.post('/api/proxy/course/sevenday',data)
          .then(errorHandle.apiError, errorHandle.networkStateError);
    },  //api/universal/currenttime
    getCurrentTime(){ //获取当前时间戳
        return axios.post('/api/universal/currenttime')
          .then(errorHandle.apiError, errorHandle.networkStateError);
    }  
}