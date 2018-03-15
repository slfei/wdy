<template>
	<div>
		<div class="course-list">
		<div class="header">
		&nbsp&nbsp{{$t('courseManagement.onSale')}}<span>{{header_data[0]}}</span>
		&nbsp{{$t('courseManagement.chargeCourseOnSale')}}<span>{{header_data[1]}}</span>
		&nbsp{{$t('courseManagement.freeCourseOnSale')}}<span>{{header_data[2]}}</span>
		</div>
		<el-button class="createbtn" @click="create_course">{{$t('courseManagement.createCourse')}}</el-button>
		<el-tabs v-model="activeOption" @tab-click="tabChange" class="tabs  w-tabs">
		    <el-tab-pane :label="$t('courseManagement.chargeCourse')+charge_total" name="2"></el-tab-pane>
		    <el-tab-pane :label="$t('courseManagement.freeCourse')+free_total" name="1"></el-tab-pane>
	  	</el-tabs>
	  	<el-select v-model="status" :placeholder="$t('courseManagement.pleaseChoose')" @change="selectType">
		    <el-option
		      v-for="item in state_options"
		      :key="item.value"
		      :label="item.label"
		      :value="item.value"
		      >
		    </el-option>
	  	</el-select>
		<el-input class="search" :placeholder="$t('courseManagement.courseName')" v-model="name_cache"/>
		<el-button type="primary" @click="searchCourse" style="margin-left:15px;">{{$t('courseManagement.search')}}</el-button>
		<div class="list">
			<el-row class="list_header">
			  <el-col :span="8">&nbsp&nbsp&nbsp&nbsp{{$t('courseManagement.courseInfo')}}</el-col>
			  <el-col :span="4" style="position: relative" class="paddingLeft cursor"><span @click="reverse('created_at')" style="float: left">{{$t('courseManagement.createTime')}}</span>
			  	<div style="float: left;width: 15px;margin-left: 3px">
			  		<span :class="['list_action_up',sort == 'asc' && sort_type == 'created_at'?'up-color1':'up-color2']" @click="sortType('created_at','asc')"></span>
			  		<span :class="['list_action_down',sort == 'desc' && sort_type == 'created_at'?'down-color1':'down-color2']" @click="sortType('created_at','desc')"></span>
			  	</div>
			  </el-col>
			  <el-col :span="4" style="position: relative" class="paddingLeft cursor"><span @click="reverse('student_num')" style="float: left">{{$t('courseManagement.applyNum')}}</span>
			  	<div style="float: left;width: 15px;margin-left: 3px">
			  		<span :class="['list_action_up',sort == 'asc' && sort_type == 'student_num'?'up-color1':'up-color2']" @click="sortType('student_num','asc')"></span>
			  		<span :class="['list_action_down',sort == 'desc' && sort_type == 'student_num'?'down-color1':'down-color2']" @click="sortType('student_num','desc')"></span>
			  	</div>
				</el-col>
			  <el-col :span="4" class="paddingLeft">{{$t('courseManagement.courseStatus')}}</el-col>
			  <el-col :span="4" class="paddingLeft">{{$t('courseManagement.action')}}</el-col>
			</el-row>
			<el-row class="nodata" v-show="havelist">
				{{$t('courseManagement.noData')}}
			</el-row>
			<el-row v-for="item,index in course_list" class="course_list" :key="index" v-show="!havelist">
			  	<el-col :span="8">
			  		<img :src="item.course_img" class="course_img">
					<div style="display: inline-block;position: relative;width: 160px">
						<div class="course_name">{{item.course_name}}</div>
						<span class="course_type">{{item.type-1?$t('courseManagement.charge'):$t('courseManagement.free')}}</span>
					</div>
				</el-col>
			    <el-col :span="4" class="paddingLeft" style="font-size: 14px;">{{item.created_at.split(' ')[0]}}</el-col>
			    <el-col :span="4" class="paddingLeft" style="font-size: 14px;">{{item.student_num}}</el-col>
			  	<el-col :span="4" class="paddingLeft" style="font-size: 14px;">
			  		<div v-if="item.status == $t('courseManagement.refuse')" class="status">
			  			<span class="warning">{{$t('courseManagement.refuse')}}</span><br>
			  			<span class="checkOpinion" @click="checkOpinion(item.course_id)">{{$t('courseManagement.checkReason')}}</span>
			  		</div>
					<span v-else>{{whichStatus(item.status)}}</span>
				</el-col>
			  <el-col :span="4"><span class="course_modify paddingLeft" @click="check(item.course_id,item.status)" style="font-size: 14px;">{{$t('courseManagement.modify')}}</span></el-col>
			</el-row>
		</div>
		<el-pagination
			v-show="total"
			style="text-align: center;margin-top: 40px;"
	    	layout="prev, pager, next"
	    	class="w-pagination"
	    	:total="total"
	    	:page-size="page_size"
	    	:current-page="page_num"
	    	@current-change="changepage">
	  	</el-pagination>
	  	<el-dialog
	  	custom-class="w-dialog"
	  	:title="$t('courseManagement.reason')"
        :visible.sync="ismodalshow"
        >
        <div style="position: relative">
        	<i class="el-icon-information"></i>
        	<span style="position: absolute;left: 35px;font-size: 16px;top: 3px;">{{$t('courseManagement.refuseWord[0]')}}<br></span>
    	</div>
        <br>
        <span class="reason" style="margin: 20px 0 0 35px;">{{reason}}<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{$t('courseManagement.refuseWord[1]')}}</span>
        <span slot="footer" class="dialog-footer">
    		<el-button type="primary" @click="ismodalshow = false">{{$t('courseManagement.sure')}}</el-button>
  		</span>
	  	</el-dialog>
	  	<el-dialog
	  	:title="$t('courseManagement.sureAction')"
        :visible.sync="isconfirmshow"
        size="tiny"
        >
        <div style="line-height: 25px;">
        <span class="el-icon-warning"></span>
        <p style="font-size: 16px;display: inline-block;width: 500px;margin: 5px 0;">{{$t('courseManagement.draft[0]')}}<br>{{$t('courseManagement.draft[1]')}}</p>
        </div>
        <span slot="footer" class="dialog-footer">
        	<el-button type="primary" @click="checkDraft">{{$t('courseManagement.sure')}}</el-button>
        	<el-button @click="delDraft">{{$t('courseManagement.cancel')}}</el-button>
  		</span>
	  	</el-dialog>
		</div>
	</div>
</template>
<script>
import api from '@/js/api/courseManagement'
export default{
	mounted(){
		this.getListInfo();
		this.getList({
			type:2,
			page_size:10,
		});
		console.log()
	},
	data(){
		return{
			header_data: [],//头部的免费课程和收费课程的数量信息
			course_list:[],//传过来的课程信息列表项
			activeOption:'2',//目前标签页选择的是哪一页
			sort_type:'created_at',//排序类型 created_at-创建时间 student_num-报名人数
			sort:'desc',//desc-从高到低，asc-从低到高
			page_size:10,//每页大小
			page_num:1,//第几页
			type:2,//课程的类型 1-免费课，2-收费课
			name:'',//搜索课程的名称
			name_cache:'',//当我在点击搜索按钮的时候再将cache的值赋给name
			status:0,//0-全部、1-编辑中、2-审核中、3-审核不通过、4-审核通过、5-已下架
			total:0,//请求的数据总数有多少条
			free_total:'',//免费课程的数量
			charge_total:'',//收费课程的数量
			ismodalshow:false,//摩太框是否显示
			isconfirmshow:false,//确认草稿箱是否显示
			reason:'',//审核不通过的理由
			havelist:false,//是否有数据  没有则显示暂无数据
			state_options:[{
	          value: 0,
	          label: this.$t('courseManagement.status[0]')
	        },{
	          value: 1,
	          label: this.$t('courseManagement.status[1]')
	        },{
	          value: 2,
	          label: this.$t('courseManagement.status[2]')
	        },{
	          value: 3,
	          label: this.$t('courseManagement.status[3]')
	        },{
	          value: 4,
	          label: this.$t('courseManagement.status[4]')
	        },{
	          value: 5,
	          label: this.$t('courseManagement.status[5]')
	        }]
		}
	},
	methods:{
		tabChange() {
			this.page_num = 1;
			this.type = this.activeOption;
			this.getList({type:this.type,page_size:10});

		},
		whichStatus(status) {
			switch (status) {
				case 1:
					return this.$t('courseManagement.status[1]');
					break;
				case 2:
					return this.$t('courseManagement.status[2]');
					break;
				case 3:
					return this.$t('courseManagement.status[3]');
					break;
				case 4:
					return this.$t('courseManagement.status[4]');
					break;
				default:
					return 'nodata';
			}
		},
		getListInfo(){
			api.getListInfo().then(res=>{
				this.header_data.push(res.adopt);
				this.header_data.push(res.adopt_charge);
				this.header_data.push(res.adopt_free);
				this.free_total = res.free;
				this.charge_total = res.charge;
			})
		},
		getList(parmars){
			api.getList(parmars).then(res=>{
				if(res.list.length){
					this.havelist = false ;
				}else{
					this.havelist = true ;
				}
				this.course_list = res.list;
				this.total = res.total;
			})
		},
		selectType(){
			this.page_num = 1 ;
			this.getList({
				sort_type:this.sort_type,
				sort:this.sort,
				status:this.status,
				page_num:this.page_num,
				name:this.name,
				page_size:this.page_size,
				type:this.type,
			});
		},
		searchCourse(){
			this.page_num = 1 ;
			this.name = this.name_cache;
			this.getList({
				sort_type:this.sort_type,
				sort:this.sort,
				status:this.status,
				page_num:this.page_num,
				name:this.name,
				page_size:this.page_size,
				type:this.type,
			});
		},
		sortType(sort_type,sort){
			this.sort_type = sort_type;
			this.sort = sort;
			this.selectType();
		},
		changepage(page){
			this.page_num = page;
			this.getList({
				sort_type:this.sort_type,
				sort:this.sort,
				status:this.status,
				page_num:this.page_num,
				name:this.name,
				page_size:this.page_size,
				type:this.type,
			});
		},
		checkOpinion(courseid){//查看审核意见
			this.ismodalshow = true ;
			api.getCheckOpinions({courseid}).then(res=>{
				this.reason = res.reason;
			})
		},
		reverse(type){
			this.sort_type = type;
			this.sort == 'desc'?this.sort = 'asc':this.sort = 'desc';
			this.selectType();
		},
		checkDraft(){
			this.$router.push({path:'/createCourse'})
		},
		delDraft(){
			api.delDraft().then(res=>{
			}).then(()=>{
				this.$router.push({path:'/createCourse'})
			})
		},
		create_course(){
			api.checkDraft().then(res=>{
				if(res[1]){
					this.isconfirmshow = true;
				}else{
					this.$router.push({path:'/createCourse'});
				}
			})
		},
		check(id,status){
			this.$router.push({ name: 'modifyCourse', params: { id ,status}})
		}
	}
}
</script>
<style scoped>
.header{
	width: 1000px;
	height: 50px;
	background: #f6fbff;
	line-height: 50px;
	font-size: 14px;
}
.header span{
	color: #268fff;
	margin-left: 5px;
}
.createbtn{
	color: #268fff;
	margin-top: 20px;
	border-color: #268fff;
}
.tabs{
	margin-top: 20px;
}
.search{
	width: 300px;
	margin-left: 20px;
}
.paddingLeft{
	padding-left: 10px;
}
.list{
	margin-top: 20px;
	padding: 0;
	border: 1px solid #d9d9d9;
	border-radius: 3px;
}
.list_header{
	height: 55px;
	line-height: 55px;
	font-size: 14px;
	background:#f5f5f5;
}
.list_action_up{
	margin-top: 15px;
	float: left;
	display: inline-block;
	height: 0;
	width: 0;
	border-style:solid;
	border-width: 5px;
}
.list_action_down{
	margin-top: 4px;
	float: left;
	display: inline-block;
	height: 0;
	width: 0;
	border-style:solid;
	border-width: 5px;
}
.up-color1{
	border-color: transparent transparent #268fff transparent;
}
.up-color2{
	border-color: transparent transparent #999999 transparent;
}
.down-color1{
	border-color: #268fff transparent transparent transparent;
}
.down-color2{
	border-color: #999999 transparent transparent transparent;
}
.course_list{
	height: 101px;
	width: 100%;
	border-top:  1px solid #d9d9d9;
	line-height: 100px;
	font-size: 12px;
}
.course_img{
	height: 55px;
	width: 100px;
	border-radius: 2px;
	vertical-align:middle;
	margin-left: 20px;
}
.course_name{
	width: 210px;
	height: 14px;
	word-wrap:break-word;
	line-height: 16px;
	font-size: 14px;
	position: absolute;
	left: 10px;
	top:-26px;
}
.course_type{
	height: 12px;
	line-height: 12px;
	font-size: 12px;
	color: #55a1ff;
	position: absolute;
	left: 10px;
	top:10px;
}
.course_modify{
	color: #55a1ff;
	cursor: pointer;
}
.warning{
	font-size: 14px;
	color: #ff1818;
}
.checkOpinion{
	font-size: 14px;
	color: #55a1ff;
	cursor: pointer;
}
.status{
	margin-top: 30px;
	line-height: 20px;
}
.el-icon-information{
	font-size: 24px;
	color: #ff1818;
}

.reason{
	margin-left: 30px;
}
.el-icon-warning{
	color: #268fff;
	font-size: 24px;
	float: left;
	margin-top: 10px;
	margin-right: 10px;
}
.nodata{
	height: 60px;
	width: 100%;
	color:#999999;
	line-height: 60px;
	border-top: 1px solid #d9d9d9;
	text-align: center;
}
.cursor{
	cursor: pointer;
}
</style>
<style type="text/css">
.course-list .el-dialog{
	border-radius: 4px;
}
.course-list .el-dialog__header {
	height: 45px;
	background: #268fff;
	border-radius: 4px;
}
.course-list .el-dialog__header .el-dialog__title{
	font-size: 14px;
	color:white;
	font-weight: 100;
}

</style>
