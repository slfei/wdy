
import * as globalErrorHandle from './globalErrorHandle'
import axios from 'axios';

export default {
  getTeacherList () {
    return axios.get('/bizapi/teacher/list')
      .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
  },

  getTeacherInfo (id) {
    return axios.post('/bizapi/teacher/info', {
      teacher_id: id
    }).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)

  },

  saveTeacher (data) {
    return axios.post('/bizapi/teacher/save', data)
      .then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
  },

  deleteTeacher (id) {
    return axios.post('/bizapi/teacher/delete',{
      teacher_id: id
    }).then(globalErrorHandle.checkLoginAndApiError, globalErrorHandle.networkStateError)
  }
}
