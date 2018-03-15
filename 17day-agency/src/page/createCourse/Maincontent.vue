<template>
	<div class="page_content">
		<router-link to="/course/list">
			<el-button class="return-list" type="text">{{$t('createCourse.returnToList')}}</el-button>
		</router-link>
		<wd-steps :steps="[$t('createCourse.steps[0]'), $t('createCourse.steps[1]'), $t('createCourse.steps[2]'), $t('createCourse.steps[3]')]" :current="stage" class="marginbottom"></wd-steps>
		<keep-alive >
			<step1 v-if="stage==1&&isGet" ref="step1" :init-data="initData[1]"/>
			<step2 v-if="stage==2&&isGet" ref="step2" :init-data="initData[2]"/>
			<step3 v-if="stage==3&&isGet" ref="step3" :init-data="initData[3]"/>
			<step4 v-if="stage==4&&isGet" ref="step4" :init-data="initData[4]"/>
		</keep-alive>
		<div class="margintop" style="text-align: center">
			<el-button v-show="stage>1" @click="back">{{$t('createCourse.back')}}</el-button>
			<el-button type="primary" v-show="stage<4" @click="forward(stage)">{{$t('createCourse.next')}}</el-button>
			<el-button v-show="stage==4" @click="preview">&nbsp&nbsp{{$t('createCourse.preview')}}&nbsp&nbsp</el-button>
			<el-button type="primary" v-show="stage==4" @click="submit">{{$t('createCourse.submit')}}</el-button>
			<div v-show="stage==4" style="color: #999999;font-size: 12px;margin-top: 20px;"><i class="el-icon-warning" style="color: #268fff"></i> {{$t('createCourse.submitTip')}}</div>
		</div>
		
	</div>
	
</template>
<script>
import WdSteps from '@/components/steps/steps'
import step1 from './step1'
import step2 from './step2'
import step3 from './step3'
import step4 from './step4'
import api from '@/js/api/createCourse'

export default{
	components: {
		WdSteps,
		step1,
		step2,
		step3,
		step4,
	},
	mounted(){
		api.checkDraft().then(res=>{
	    	this.initData = res;
	    }).then(()=>{
	    	this.isGet = true;
	    })
	},
	data() {
		return {
			stage: 1,//当前步骤是第几步
			initData:{},//草稿箱的数据
			isGet:false,//是否拿到草稿箱的数据
		}
	},
	methods: {
		forward(stage){
			var promise = this.$refs['step' + stage].submitForm();
			if (typeof promise == 'boolean') {
				if (promise){
					this.stage++;
				}
			} else if (promise && promise.then) {
				promise.then(() => {
					this.stage++;
				});
			}
		},
		back () {
			this.stage--;
		},
		preview(){
			var promise = this.$refs['step4'].submitForm();

			if (typeof promise =='object'){
				promise.then(()=>{
					var preview = window.open('');
					promise.then(()=>{
						return api.preview().then((res)=>{
							preview.location = res.url;

					}).catch(()=>{
						window.close();
					})
					})
				})
			}
		},
		submit(){
			var promise = this.$refs['step4'].submitForm();
			if (typeof promise =='object'){
				promise.then(()=>{
					api.submit().then( ()=>{
						this.$router.push({path:'/course/list'})
					})
				})
			}
		}
	}
}
</script>
<style scoped>
.page_content{
	width: 840px;
	margin: auto;
	padding: 40px 0;
	position: relative;
}
.marginbottom{
	margin-bottom: 40px;
}
.margintop{
	margin-top: 40px;
}
.return-list{
	border-color: #256fff;
	color: #256fff;
	position: absolute;
	left: -150px;
	top: 10px;
}
</style>