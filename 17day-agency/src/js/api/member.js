import axios from 'axios';
import * as globalErrorHandle from './globalErrorHandle';
export default {
	
    getMemberlist(data){//获取成员列表数据
    	 return axios.post('/api/member/memberlist',data)
    },
    
    delMemberlist(id){
    	return axios.post('/api/member/delmember',id)
    },
    
    getMemberUpdatepage(id){//获取修改成员页面的接口,id为传参的对象
    	 return axios.post('/api/member/memberupdatepage',id)
    },
    
    postMemberUpdate(data){//发送修改成员数据的接口, data均为对象传id及数据。
    	 return axios.post('/api/member/memberupdate',data)
    },
    
    memberAddpage(tel){//   添加成员页面接口    /api/member/memberaddpage Request    "phone" 手机号
    	 return axios.post('/api/member/memberaddpage',tel)
   },
//	
    memberAdd(data){//   添加成员接口  
    	 return axios.post('/api/member/memberadd',data)
    }
	
}