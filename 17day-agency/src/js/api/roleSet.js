import axios from 'axios';
import * as  ErrorHandle from './globalErrorHandle';
export default {
	
    getrolelist(){//获取角色列表
    	 return axios.get('/api/roleaccess/rolelist')
    	  .then(res=>res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    roleaccount(data){//获取角色成员  data 是参数对象
    	 return axios.post('/api/roleaccess/roleaccount',data)
    	  .then( res=>res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    	     
    },
    delRoleaccount(data){//删除角色成员  data 是参数对象
    	 return axios.post('/api/roleaccess/delmember',data)
    	    .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
    addNewRole(){//新增角色 获取数据
    	 return axios.get('/api/roleaccess/roleaddpage')
    	     .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    	        
    },
    addNewRoleSuc(data){//提交新增的角色  
    	 return axios.post('/api/roleaccess/roleaccessadd',data)
 	         .then(res=>res,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    	        
   },
    changeRole(data){//修改角色页面    'role_id' 角色id
    	 return axios.post('/api/roleaccess/roleinfo',data)
    	    .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },

   changeRoleSuc(data){//角色修改完成提交  
    	 return axios.post('/api/roleaccess/roleupdate',data)
    	     .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
    },
 
    addRoleMember(data){//   添加角色成员页面 -弹框'role_id'  角色id 'keywords' 关键字(选填 搜索时用)
    	 return axios.post('/api/roleaccess/rolememberaddpage',data)
    	         .then(res => res.data,ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
   },              
    addRoleMemberSuc(data){//添加角色成员保存    Request 'role_id' 角色id 'account_ids' 用户id（数组）
    	 return axios.post('/api/roleaccess/rolememberadd',data)
    	          .then(ErrorHandle.checkLoginAndApiError, ErrorHandle.networkStateError)
   },    


  }
    
