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
				<el-form-item :label="$t('bankAccount.accountName')" prop="name">
	                <el-input v-model="ruleForm.name"  :placeholder="$t('bankAccount.error[1]')" class="width400" :maxlength="30"></el-input>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.bank')" prop="bank" required>
	                <el-select v-model="ruleForm.bank"  :placeholder="$t('bankAccount.bank_PH')" class="width400">
	                	<el-option
					      v-for="item in options"
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
	            <el-form-item :label="$t('bankAccount.outlet')" prop="bank_outlets" >
	                <el-input v-model="ruleForm.bank_outlets"  :placeholder="$t('bankAccount.outlet_PH')" class="width400"></el-input>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.bankAccount')" prop="bank_account" >
	                <el-input v-model="ruleForm.bank_account"  :placeholder="$t('bankAccount.bankAccount_PH')" class="width400" :maxlength="30"></el-input>
	            </el-form-item>
	            <el-form-item :label="$t('bankAccount.letter')" prop="image">
	                <image-uploader v-model="ruleForm.image"  >
	                	<div slot="desc" class="expound">
                            {{$t('bankAccount.download')}}<a href="//17dayup-protocol.bj.bcebos.com/%E4%B8%AA%E4%BA%BA%E9%93%B6%E8%A1%8C%E8%B4%A6%E6%88%B7%E6%89%BF%E8%AF%BA%E4%B9%A6.docx">{{$t('bankAccount.letter')}}</a>{{$t('bankAccount.letterTips[0]')}}<br>{{$t('bankAccount.letterTips[1]')}}
                            <img src="../../assets/images/promise.png" class="promiseSmall">
                            <div class="promiseWord">{{$t('bankAccount.letterExample')}}</div>
                            <img src="../../assets/images/promise.png" class="promiseBig">
                        </div>
                     </image-uploader>
	            </el-form-item>
	            <el-form-item>
	                <el-button type="primary" @click="submit">{{$t('bankAccount.submit')}}</el-button>
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
import ImageUploader from "@/components/upload/ImageUploader"
import WdSteps from '@/components/steps/steps'
import api from '@/js/api/financalAccount'
import province from '@/js/province'
import protocol from './accountProtocol'
export default{
	components:{
		WdSteps,
		protocol,
		ImageUploader,
	},
	mounted(){
		this.getBank();
		this.init();
	},
	data(){
		return {
			province,
			status:true,
			step:1,
			accept:true,
			options:[],
			initDate:{},
			reason:'',
			rules:{
				name:[
					{required:true,message:this.$t('bankAccount.error[1]'),trigger:'blur'},
				],
				bank:[
					{validator:(rule,value,callback)=>{
						if(this.ruleForm.bank){
							callback()
						}else{
							callback(this.$t('bankAccount.error[2]'))
						}
					},trigger:'blur'}
				],
				opening_bank:[
					{
						required:true,
						validator:(rule,value,callback)=>{
						if(this.ruleForm.city){
							callback()
						}else{
							callback(this.$t('bankAccount.error[3]'))
						}
					},trigger:'blur'}
				],
				bank_outlets:[
					{required:true,message:this.$t('bankAccount.error[5]'),trigger:'blur'},
				],
				bank_account:[
					{required:true,message:this.$t('bankAccount.error[4]'),trigger:'blur'},
					{validator:(rule,value,callback)=>{
						if(value == Number(value)){
							callback()
						}else{
							callback(this.$t('bankAccount.error[6]'))
						}
					},trigger:'blur'},
				],
				image:[
					{required:true,message:this.$t('bankAccount.letterWA'),trigger:'change'}
				]
			},
			ruleForm:{
				name:'',
				bank:'',
				bank_outlets:'',
				bank_account:'',
				province:'',
				city:'',
				image:'',
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
		submit() {
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
				console.log(res)
				this.options = res.bank_list;
			})
		},
		province_change(){
			this.ruleForm.city = '';
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
.width190{
	width: 190px !important;
	margin-right: 15px !important;
	display: inline-block !important;
}
.width400{
	width: 400px !important;
}
.expound{
    font-size:12px;
    color: #999;
    font-weight: 400;
    position: relative;
}
.promiseSmall{
	position: absolute;
	height: 190px;
	width: 130px;
	left: 260px;
	top: -50px;
	border: 1px solid #d9d9d9;
}
.promiseBig{
	position: absolute;
	z-index: 10000;
	left: -75px;
	top: -360px;
	width: 332px;
	box-shadow: -4px 4px 6px rgba(0, 0, 0, .05),
				4px 4px 6px rgba(0, 0, 0, .05),
				-4px -4px 6px rgba(0, 0, 0, .05),
				4px -4px 6px rgba(0, 0, 0, .05);
	display: none;
}
.promiseWord{
	position: absolute;
	text-align: center;
	left: 275px;
	top: -70px;
	height: 20px;
	width: 100px;
}
.promiseSmall:hover~.promiseBig{
	display: block;
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