<template>
	<div class="page-content" >
		<wd-steps :steps="[$t('bankAccount.steps[0]'),$t('bankAccount.steps[1]'),$t('bankAccount.steps[2]')]" :current="step"></wd-steps>
		<div class="step1" v-if="step==1">
			<div class="protocol">
				<protocol />
			</div>
			<div class="accept">
				<el-checkbox v-model="accept"/>&nbsp&nbsp&nbsp{{$t('bankAccount.alreadyRead')}}
			</div>
			<el-button type="primary" class="nextbtn" @click="next">{{$t('bankAccount.next')}}</el-button>
		</div>
		<div v-if="step==2" class="form">
			<el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="130px">
				<el-form-item :label="$t('bankAccount.promiseImg')" prop="image">
					<span style="font-size: 12px;color:#999999;">{{$t('bankAccount.promiseTip')}}</span>
	                <image-uploader v-model="ruleForm.image" @error="onImageSelectError" @change="dispatchChangeForElItem">
                     </image-uploader>
	            </el-form-item>
				<el-form-item :label="$t('bankAccount.accountName')" prop="name">
	                <el-input v-model="ruleForm.name"  :placeholder="$t('bankAccount.error[1]')" class="width400" :maxlength="30"></el-input>
	                <i class="el-icon-warning" style="color: #268fff;margin-left: 20px;"></i><span class="size12">&nbsp&nbsp{{$t('bankAccount.accountName_PH')}} <img src="../../assets/images/accountName.png" class="pic"></span>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.bank')" prop="bank">
	                <el-select v-model="ruleForm.bank"  :placeholder="$t('bankAccount.bank_PH')" class="width190" >
	                	<el-option
					      v-for="item,key in options"
					      :key="item.id"
					      :label="item.bank_name"
					      :value="item.id">
					    </el-option>
	                </el-select>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.openingBank')" prop="opening_bank">
	                <el-select v-model="ruleForm.province"  :placeholder="$t('bankAccount.province')" class="width190" @change="province_change">
	                	<el-option
					      v-for="value,key in province"
					      :key="key"
					      :label="key"
					      :value="key">
					    </el-option>
	                </el-select>
	                <el-select v-model="ruleForm.city"  :placeholder="$t('bankAccount.city')" class="width190">
	                	<el-option
					      v-for="value in province[ruleForm.province]"
					      :key="value"
					      :label="value"
					      :value="value">
					    </el-option>
	                </el-select>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.outlet')" prop="bank_outlets">
	                <el-input v-model="ruleForm.bank_outlets"  :placeholder="$t('bankAccount.outlet_PH')" class="width400"></el-input>
	                <i class="el-icon-warning" style="color: #268fff;margin-left: 20px;"></i><span class="size12">&nbsp&nbsp{{$t('bankAccount.outletTip')}}<img src="../../assets/images/bankName.png" class="pic"></span>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.bankAccount')" prop="bank_account" >
	                <el-input v-model="ruleForm.bank_account"  :placeholder="$t('bankAccount.bankAccount_PH')" class="width400" :maxlength="30"></el-input>
	            </el-form-item>
	            <el-form-item>
	                <el-button type="primary" @click="submit">{{$t('bankAccount.submit')}}</el-button><br>
	                <i class="el-icon-warning" style="color: #268fff"></i><span class="size12">&nbsp&nbsp{{$t('bankAccount.submitTip')}}</span>
	            </el-form-item>
			</el-form>
		</div>
		<div v-if="step == 3">
			<div v-if="status">
				<div class="reviewing"></div>
				<div style="font-size: 14px;text-align: center">{{$t('bankAccount.status[0]')}}<br>
				<el-button type="primary" style="margin-top: 20px;" @click="back">{{$t('bankAccount.backToCourse')}}</el-button>
				</div>
			</div>
			<div v-if="!status">
				<div class="fail"></div>
				<div style="font-size: 14px;text-align: center">{{$t('bankAccount.status[1]')}}<br><div class="reason">{{reason}}</div><br>{{$t('bankAccount.backToModify')}}<br>
				<button class="backstep" @click="modify">{{$t('bankAccount.prev')}}</button>
				</div>
			</div>
		</div>
		
	</div>
	
</template>
<script>
import WdSteps from '@/components/steps/steps'
import ImageUploader from "@/components/upload/ImageUploader"
import validatorMixin from '@/js/mixin/validatorMixin';
import api from '@/js/api/financalAccount'
import province from '@/js/province'
import protocol from './accountProtocol'
export default{
	mixins: [validatorMixin],
	components:{
		WdSteps,
		ImageUploader,
		protocol,
	},
	created(){
		this.getBank();
		this.init();
	},
	data(){
		return {
			province,
			initflag:false,
			step:1,
			accept:true,
			options:null,
			status:true,
			reason:'',
			rules:{
				image:[
					{required:true,message:this.$t('bankAccount.error[0]'),trigger:'change'}
				],
				name:[
					{required:true,message:this.$t('bankAccount.error[1]'),trigger:'blur'},
				],
				bank:[
					{required:true,validator:(rule,value,callback)=>{
						if(this.ruleForm.bank){
							callback()
						}else{
							callback(this.$t('bankAccount.error[2]'))
						}
					},trigger:'blur'}
				],
				opening_bank:[
					{ required:true,validator:(rule,value,callback)=>{
						if(this.ruleForm.city){
							callback()
						}else{
							callback(this.$t('bankAccount.error[3]'))
						}
					},trigger:'blur'}
				],
				bank_outlets:[
					{type:'string',required:true,message:this.$t('bankAccount.error[5]'),trigger:'blur'},
				],
				bank_account:[
					{required:true,message:this.$t('bankAccount.error[4]'),trigger:'blur'},
					{validator:(rule,value,callback)=>{
						if(value == Number(value)){
							callback()
						}else{
							callback(this.$t('bankAccount.error[6]'))
						}
					},trigger:'blur'}
				],
			},
			ruleForm:{
				image:null,
				name:null,
				bank:null,
				province:null,
				city:null,
				bank_outlets:null,
				bank_account:'',
			}
		}
	},
	methods:{
		next(){
			if(this.accept){
				this.step = 2;
			}else{
				this.$message(this.$t('bankAccount.pleaseConfirm'))
			}
		},
		submit(){
			console.log(this.ruleForm)
			this.$refs['ruleForm'].validate(valid =>{

					if(valid){
						if(this.status&&this.$route.params.isfirst=='create'){
							api.addInfo(this.ruleForm).then(()=>{
								this.step = 3;
							})
						}else{
							api.modify(this.ruleForm).then(()=>{
								this.step = 3;
							})
						}
					}
				})
		},
		getBank(){
			api.getBank().then(res=>{
				this.options = res.bank_list;
			})
		},
		province_change(){
			if(this.initflag){
				this.ruleForm.city = '';
			}
		},
		init(){
			if(this.$route.params.isfirst == 'modify'){
				this.step = 3;
				this.status = false;
				api.initDate().then((res)=>{
					if(res.bank_info){
						this.ruleForm = res.bank_info;
						this.ruleForm.bank = Number(res.bank_info.bank);
						this.reason = res.bank_info.reason;
					}
				}).then(()=>{
					this.initflag = true;
				})
			}
		},
		back(){
			this.$router.push({path:'/course/list'})
		},
		modify(){
			this.step = 2;
			this.status = true;
		}
	}
}
</script>
<style scoped>
.page-content{
	width: 1180px;
	padding: 40px 170px;
	position: relative;

}
.protocol{
	width: 840px;
	height: 420px;
	margin-top: 40px;
	border:1px solid #d9d9d9;
}
.accept{
	width: 840px;
	height: 35px;
	line-height: 35px;
	padding-left: 20px;
	border:1px solid #d9d9d9;
	border-top: transparent;
}
.nextbtn{
	margin: 30px auto !important;
	display: block !important;
}
.form{
	margin-top: 30px;
}
.size12{
	font-size: 12px;
	font-weight: 500;
	position: relative;
}
.pic{
	position: absolute;
	top: 20px;
	left: 0px;
	width: 366px;
	height: 76px;
}
.width190{
	width: 190px;
	margin-right: 15px;
	display: inline-block;
}
.width400{
	width: 400px;
}
.reviewing{
	width: 160px;
	height: 220px;
	background: url('../../assets/images/apply-inreview.png') no-repeat;
	margin: 40px auto;
}
.fail{
	width: 160px;
	height: 220px;
	background: url('../../assets/images/apply-fail.png') no-repeat;
	margin: 40px auto;
}
.backstep{
	margin-top: 20px;
	font-size: 12px;
	height: 35px;
	width: 80px;
	color: #268fff;
	border-radius: 4px;
	border: 1px solid #268fff;
	background: #fff;
	cursor: pointer;
}
.reason{
	text-align: left;
	margin:10px 270px;
	word-wrap: break-word;
}
</style>