<template>

	<div class="main clear">
		<div class="header">
			<div class="sub-header">
				<el-button type="text" @click = "backToList">{{$t('createCourse.returnToList')}}</el-button><br>
				<img :src="img" class="img">
				<br><span class="title">{{title}}</span><br><br>
				<button class="preview" @click="preview">{{$t('createCourse.preview')}}</button>
			</div>
			
		</div>
		<div class="navbar">
			<div class="nav-item" :class="{active:stage == 1}" @click="changeStage(1)">{{$t('createCourse.basicInfo')}}</div>
			<div class="nav-item" :class="{active:stage == 4}" @click="changeStage(4)">{{$t('createCourse.catalog')}}</div>
			<div class="nav-item" :class="{active:stage == 2}" @click="changeStage(2)">{{$t('createCourse.price')}}</div>
			<div class="nav-item" :class="{active:stage == 3}" @click="changeStage(3)">{{$t('createCourse.marketSet')}}</div>
		</div>
		<div class="check">
			<span style="margin-left: 20px; color: #999999">{{warning[which]}}</span>
			<el-button :disabled="state" type="primary" :loading="isLoading" style="float: right;margin: 5px 20px 0 0;" @click="submit">{{button_word[which]}}</el-button>
		</div>
		<div class="content clear" >
			<div class="shadow" v-show="show_shadow"></div>
			<keep-alive>
				<step1 v-if="stage==1" ref="step1" :init-data="initData[0]" @listenChild="saveData"></step1>
				<step2 v-if="stage==2" ref="step2" :init-data="initData[1]" @listenChild="saveData"></step2>
				<step3 v-if="stage==3" ref="step3" :init-data="initData[2]" @listenChild="saveData"></step3>
				<step4 v-if="stage==4" ref="step4" :init-data="initData[3]" @listenChild="saveData"></step4>
			</keep-alive>
			<div style="width: 100%;text-align:center;float: right;">
				<el-button type="primary" class="save" @click="save">{{$t('createCourse.save')}}</el-button>
			</div>
		</div>
	</div>
</template>
<script>
import step1 from '@/page/createCourse/step1'
import step2 from '@/page/createCourse/step2'
import step3 from '@/page/createCourse/step3'
import step4 from '@/page/createCourse/step4'
import api from '@/js/api/modifyCourse'
export default{
	components: {
		step1,
		step2,
		step3,
		step4,
	},
	mounted(){
		this.checkone(this.$route.params.id);
		this.checktwo(this.$route.params.id);
		this.checkthree(this.$route.params.id);
		this.checkfour(this.$route.params.id);
	},
	data(){

		return {
			title:'',
			img:'',
			warning:[this.$t('courseManagement.warning[0]'),
			this.$t('courseManagement.warning[1]'),
			this.$t('courseManagement.warning[2]')],
			button_word:[this.$t('courseManagement.buttonWord[0]'),this.$t('courseManagement.buttonWord[0]'),this.$t('courseManagement.buttonWord[1]')],
			which:'',//现在处于什么状态  0为审核不通过 1为审核通过 2为审核中
			state:'',//是否点击过保存按钮  未点击则不能提交审核
			stage:0,//现在修改的是第几步
			courseid:null,//当前的课程id
			initData:[],//当前获取到的初始数据
			show_shadow:false,
			equalData:null,//用来判断当前数据和保存之前的数据是否相等
			nowData:null,//现在的数据
			isEqual:false,
			isLoading:false,
		}
	},
	methods:{
		saveData(data){
			if(this.isEqual){
				this.nowData = data ;
			}else{
				this.equalData = JSON.parse(JSON.stringify(data))  ;
			}

		},
		deepEqual(x,y){
			if ((typeof x == "object" && x != null) && (typeof y == "object" && y != null)) {
			    for (var prop in x) {
			      if (y.hasOwnProperty(prop))
			      {
			        if (! this.deepEqual(x[prop], y[prop]))
			          return false;
			      }
			      else
			        return false;
			    }
			    return true;
			  }
			  else if (x != y)
			    return false;
			  else
			    return true;
		},
		save(){
			var promise = this.$refs['step' + this.stage].submitForm(this.$route.params.id);
			promise.then((res)=>{
				this.which = 0;
				this.state = false ;
				this.$refs['step'+ this.stage].sendMsg();
			}).then(()=>{
				this.$message.success(this.$t('courseManagement.success'))
			})
		},
		submit(){
			this.state = false;
			this.which = 0;
			if(this.$route.params.status == this.$t('courseManagement.status[2]') && this.show_shadow){
				var promise =api.revoke({courseid:this.$route.params.id});
				promise.then(()=>{
					this.show_shadow = false;
					this.state = false;
					this.which = 0;
				})
			}else{
				this.isLoading = true;
				console.log(this.stage)
				var promise = this.$refs['step' + this.stage].submitForm(this.$route.params.id);
				promise.then(()=>{
					var promise1 = api.submit({courseid:this.$route.params.id});
					promise1.then((res)=>{
						if(res.status == 200){
							this.$router.push({path:'/course/list'});
						}
					})
				})
			}
		},
		preview(){
			var promise =api.preview({courseid:this.$route.params.id});
			promise.then((res)=>{
				let preview =window.open();
                preview.location = res.url;
			})
		},
		checkone(id){
			api.checkone({courseid:id}).then(res=>{
				this.initData[0] = res;
				this.title = this.initData[0].course_name;
				this.img = this.initData[0].course_img;
				if(this.$route.params.status == this.$t('courseManagement.status[4]')){
					this.state = false;
					this.which = 1;
				}else if(this.$route.params.status == this.$t('courseManagement.status[2]')){
					this.show_shadow = true;
					this.state = false;
					this.which = 2;
					this.show_shadow = true;
				}else if(this.$route.params.status == this.$t('courseManagement.status[3]')||this.$t('courseManagement.status[1]')||this.$t('courseManagement.status[5]')){
					this.state = false;
					this.which = 0;
				}
				this.stage = 1;
			})
		},
		checktwo(id){
			api.checktwo({courseid:id}).then(res=>{
				this.initData[1] = res;
			})
		},
		checkthree(id){
			api.checkthree({courseid:id}).then(res=>{
				this.initData[2] = res;
			})
		},
		checkfour(id){
			api.checkfour({courseid:id}).then(res=>{
				this.initData[3] = res;
			})
		},
		changeStage(stage){
			this.isEqual = true;
			this.$refs['step'+ this.stage].sendMsg();
			if(this.deepEqual(this.nowData,this.equalData)){
				this.isEqual = false;
				this.stage = stage ;
			}else{
				this.$confirm(this.$t('courseManagement.leaveTips'),this.$t('courseManagement.tip'),{
					type:'warning',
					confirmButtonText: this.$t('courseManagement.sure'),
		          	cancelButtonText: this.$t('courseManagement.cancel'),
				}).then(()=>{
					this.isEqual = false;
					this.stage = stage;
				}).catch(()=>{
					this.isEqual = false;
				})
			}
		},
		backToList(){
			this.isEqual = true;
			this.$refs['step'+ this.stage].sendMsg();
			if(this.deepEqual(this.nowData,this.equalData)){
				this.$router.push({path:'/course/list'});
				this.isEqual = false;
			}else{
				this.$confirm(this.$t('courseManagement.leaveTips'),this.$t('courseManagement.tip'),{
					type:'warning',
					confirmButtonText: this.$t('courseManagement.sure'),
		          	cancelButtonText: this.$t('courseManagement.cancel'),
				}).then(()=>{
				this.$router.push({path:'/course/list'});
					this.isEqual = false;
				}).catch(()=>{
					this.isEqual = false;
				})
			}
		}
	}
}
</script>
<style scoped>
.main{
	padding-top: 170px;
}
.active{
	color: #268fff;
	background: #f6fbff;
}
.clear:after{
	clear: both;
	content: '';
	display:block;
}
.header{
	top: 76px;
	position: absolute;
	left: 0;
	right: 0;
	height: 150px;
	background: #f5f5f5;
}
.sub-header{
	width: 1180px;
	margin: 0 auto;
	height: 150px;
}
.img{
	width: 165px;
	height: 95px;
	border-radius: 3px;
	float: left;
}
.title{
	font-size: 20px;
	float: left;
	margin-left: 20px;
}
.preview{
	height: 30px;
	width: 90px;
	display: inline-block;
	font-size: 12px;
	color: #268fff;
	border:1px solid #268fff;
	border-radius: 3px;
	background: transparent;
	margin:10px 0 0 20px;
	cursor: pointer;
}
.navbar{
	width: 135px;
	height: 178px;
	border: 1px solid #d9d9d9;
	border-radius: 3px;
	font-size: 16px;
	text-align: center;
	float: left;
}
.nav-item{
	line-height: 44px;
	cursor: pointer;
}
.nav-item:hover{
	color: #268fff;
	background: #f6fbff;
}
.check{
	width: 1000px;
	height: 45px;
	background: #f6fbff;
	float: right;
	line-height: 45px;
}
.content{
	width: 1000px;
	float: right;
	margin-top: 40px;
	position: relative;
}
.save{
	margin-top: 40px;
	margin-bottom: 40px;
}
.shadow{
	position: absolute;
	top: -2%;
	left: -3%;
	width: 106%;
	height: 102%;
	z-index: 2000;
	background: rgba(0,0,0,.1);
}
</style>