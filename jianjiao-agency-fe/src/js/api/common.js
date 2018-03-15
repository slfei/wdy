import axios from 'axios';
import * as errorHandle from './globalErrorHandle'
let currenttype;
export default {
  uploadImage(file, onProgress) {
    var form = new FormData();
    form.append('image', file);

    return axios.post('/api/universal/uploadimage', form, {
      onUploadProgress: onProgress,
      // overwrite global post setttings
      transformRequest: [function(data) {
        return data
      }],
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }).then(errorHandle.apiError, errorHandle.networkStateError);
  },

  sendCaptcha(phone, type) {
    return axios.get('/api/universal/sendcaptcha', {
      params: {
        phone: phone,
        type: type
      }
    }).then(errorHandle.apiError, errorHandle.networkStateError);
  },


  /*
   ** 验证手机号
   ** @params {data.phone} 手机号
   ** @params {data.captcha} 验证码
   ** @params {data.type} 验证类型
   */
  checkCaptcha(data) {
    return axios.post('/api/universal/checkcaptcha', data).then(res => res.data);
  }




}
