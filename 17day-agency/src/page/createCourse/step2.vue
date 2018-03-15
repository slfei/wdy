<template>
	<div>
		<el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="130px" class="demo-ruleForm">

            <section class="form-grp">
                <div class="s-hd">
                    {{$t('createCourse.priceSet')}}
                    <span class="expound" style="font-weight: normal;margin-left:12px;">{{$t('createCourse.changeRule')}}</span>
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('createCourse.coursePrice')" required>
                        <el-radio-group v-model="ruleForm.type">
                            <el-radio :label="1" :disabled="published">{{$t('createCourse.free')}}</el-radio>
                            <el-radio :label="2" :disabled="course_ischargeshow||published">{{$t('createCourse.charge')}}</el-radio>
                         </el-radio-group>
                    </el-form-item>

                    <div v-if="!ruleForm.course_ischargeshow&&ruleForm.type-1">
                            <el-form-item :label="$t('createCourse.coursePrice')" prop="price">
                                <el-input v-model="ruleForm.price" :readonly="!variable" autofocus></el-input><span class="margin">{{$t('createCourse.RMB')}}</span>
                                <i class="el-icon-information" style="color: #268fff;margin-left:5px;"></i>
                                <span class="expound">{{$t('createCourse.coursePrice_PH')}}</span>
                            </el-form-item>
                            <el-form-item>
                                <p class="el-icon-document blue" @click="showpricerules">{{$t('createCourse.ruleChangeExplain')}}</p>
                                <div class="price rules" v-show="price_rules_show">
                                    <span class="arrow"><em></em></span>
                                    <p>{{$t('createCourse.priceRule[0]')}}</p>
                                    <div v-html="$t('createCourse.priceRule[1]')" >
                                    </div>

                                </div>
                            </el-form-item>
                            <el-form-item :label="$t('createCourse.isRefund')">
                                <el-checkbox :label="$t('createCourse.whenever')"  v-model="ruleForm.is_refund" :disabled="published"></el-checkbox>
                                <div class="refund rules">
                                    <span class="arrow"><em></em></span>
                                    <p>{{$t('createCourse.refundRule[0]')}}</p>
                                    <div class="rule-content" v-html="$t('createCourse.refundRule[1]')">
                                    </div>
                                </div>
                            </el-form-item>

                        </div>
                <div class="s-hd">
                    {{$t('createCourse.courseValidity')}}
                </div>
                    <el-form-item :label="$t('createCourse.entryDeadline')" prop="stop_time">
                        <ul>
                            <el-radio-group v-model="ruleForm.stop_time" @change="changesign_stop" >
                                <li><el-radio :label="0">{{$t('createCourse.infinite')}}</el-radio></li>
                                <li><el-radio :label="1"><span>{{$t('createCourse.student')}}</span>
                                    <el-date-picker v-model="ruleForm.sign_stop" @change="date" type="date"
                                    value-format="yyyy-MM-dd" :placeholder="$t('createCourse.deadline_PH')" :picker-options="pickerOptions" style="width: 140px" popper-class="w-date-picker-popper"></el-date-picker><span class="margin">{{$t('createCourse.beforeEnd')}}</span></el-radio></li>
                             </el-radio-group>
                        </ul>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.studyDeadline')" prop="usefull_day">
                        <span class="expound" style="margin-left:12px;">{{$t('createCourse.studyRule')}}</span>
                        <ul>
                            <el-radio-group v-model="ruleForm.study_date" @change="changestudy_stop">
                                <li><el-radio :label="0" :disabled="published">{{$t('createCourse.infinite')}}</el-radio></li>
                                <li><el-radio :label="1" :disabled="published"><span>{{$t('createCourse.studentMust')}}</span>
                            <el-input style="width: 120px" v-model="ruleForm.usefull_day" :disabled="published"></el-input><span class="margin">{{$t('createCourse.reLearn')}}</span></el-radio></li>
                            </el-radio-group>
                        </ul>
                    </el-form-item>
                </div>
            </section>
        </el-form>
	</div>
</template>
<script>
import ImageUploader from "@/components/upload/ImageUploader"
import E from 'wangeditor'
import api from '@/js/api/createCourse'
export default {
    props: {
        initData: {},
        status:'',
    },
    mounted(){
        this.getBank();
        this.getAccType();

    },
    activated(){
        if(this.initData){
            if( typeof this.initData.variable == 'boolean'){
                this.published = this.initData.published;
            }
            if( typeof this.initData.variable == 'boolean'){
                this.variable = this.initData.variable;
            }
            if(this.initData.msg){
                this.msg = this.initData.msg;
            }
            this.sendMsg();
        }
    },
	data() {
        var form = {
                type: 1,//是否收费
                price:'',//收费课程的价格
                stop_time: 0,//课程的有效期限为永久还是限时
                sign_stop: '',//有效期限限时到哪个时间段
                study_date:0,//学习期限为永久有效还是限时间
                usefull_day:'',//有限的学习时间为多少
                is_refund: false,//是否承诺课前随时退 0为不退 1为可以开课前退
            };
        if (this.initData) {
            form.type = parseFloat(this.initData.type);
            form.price = parseFloat(this.initData.price);
            if(this.initData.price != 0){
                form.type = 2;
            }
            if(this.initData.sign_stop != 0){
                form.stop_time = 1;
                form.sign_stop = this.initData.sign_stop;
            };
            if(this.initData.usefull_day != 0){
                form.study_date = 1;
                form.usefull_day = this.initData.usefull_day;
            };
            if(this.initData.is_refund != 0){
                form.is_refund = true ;
            };
            this.msg = this.initData.msg;
        };
		return {
			ruleForm:form,
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                }
            },//选取的日期，必须要大于当前时间
            price_rules_show: true,
            course_ischargeshow: false,//关联银行账号是否出现
            account_type:'',//如果为1 则是个人 2为机构
            msg:'',
            variable:true,
            published:false,
			rules: {
				price: [
                    {   required:true,
                        validator: (rule, value, callback) => {
                            if(!this.variable){
                                callback(this.initData.msg)
                            };
                            if (!this.ruleForm.price&&this.ruleForm.type-1) {
                                callback(new Error(this.$t('createCourse.coursePrice_WA[0]')));
                            } else if (value != parseFloat(value)){
                                callback(this.$t('createCourse.coursePrice_WA[1]'));
                            } else if (value <= 0){
                                callback(this.$t('createCourse.coursePrice_WA[2]'));
                            } else if (value == parseFloat(value) && (parseFloat(value).toFixed(2) - value) != 0){
                                callback(this.$t('createCourse.coursePrice_WA[3]'));
                            } else{
                                callback();
                            }
                        },
                        trigger: 'blur'
                    },
				],
                usefull_day:[
                {   required:true,
                    validator:(rule,value,callback)=>{
                        if(this.ruleForm.study_date!=0){
                            if(!(value == parseInt(value))){
                                callback(this.$t('createCourse.deadline_WA'));
                            }else{
                            }
                        }
                    },
                    trigger: 'blur'
                }],
                stop_time:[
                {   required:true,
                    validator:(rule,value,callback)=>{
                        if(this.ruleForm.stop_time!=0){
                            if(value){
                            }else{
                                callback(this.$t('createCourse.studyDeadline_WA'));
                            }
                        }
                    },
                    trigger: 'blur'
                }],
			}
		}
	},
	methods: {
        sendMsg(){
            this.$emit('listenChild',{
                            type:this.ruleForm.type,
                            price:this.ruleForm.type == 2?this.ruleForm.price:null,
                            sign_stop:this.ruleForm.stop_time&&this.ruleForm.sign_stop,
                            usefull_day:this.ruleForm.study_date&&this.ruleForm.usefull_day,
                            is_refund:(()=>{
                                if(this.ruleForm.type == 2){
                                    return this.ruleForm.is_refund?1:0
                                }else{
                                    return null;
                                }
                            })()
                        })
        },
        showpricerules() {
            this.price_rules_show = !this.price_rules_show;
        },
        submitForm(courseid){
            if(this.ruleForm.study_date&&!(parseInt(this.ruleForm.usefull_day))){
                this.$message.error(this.$t('createCourse.stepTips[0]'))
            }else if (this.ruleForm.stop_time&&!this.ruleForm.sign_stop){
                this.$message.error(this.$t('createCourse.stepTips[1]'))
            }else if(this.ruleForm.type-1&&!this.ruleForm.price){
                this.$message.error(this.$t('createCourse.stepTips[2]'))
            }else{
                return new Promise((resolve, reject) => {
                        return api.step2_mes({
                            courseid,
                            type:this.ruleForm.type,
                            price:this.ruleForm.type == 2?this.ruleForm.price:null,
                            sign_stop:this.ruleForm.stop_time&&this.ruleForm.sign_stop,
                            usefull_day:this.ruleForm.study_date&&this.ruleForm.usefull_day,
                            is_refund:(()=>{
                                if(this.ruleForm.type == 2){
                                    return this.ruleForm.is_refund?1:0
                                }else{
                                    return null;
                                }
                            })()
                        }).then(resolve, reject);
                 })
            }
        },
        date(date){
            this.ruleForm.sign_stop = date ;
        },
        changesign_stop(){
            if(this.ruleForm.stop_time == 0){
                this.ruleForm.sign_stop = '';
            }
        },
        changestudy_stop(){
            if(this.ruleForm.study_date == 0){
                this.ruleForm.usefull_day = '';
            }
        },
        getBank(){
            api.getBank().then((res)=>{
                this.course_ischargeshow = !res.data.data.is_bank;
            })
        },
        getAccType(){
            api.getAccType().then((res)=>{
                this.account_type = res.type;
            }).then(()=>{
            })
        },
        bound(){
            this.$router.push({
                path:'/finance/capital'
            })
        }
	}
}
</script>
<style scoped>
.select{
	width: 180px;
	margin-right: 10px;
}
.blue{
    color:#4098ff;
    cursor: pointer;
}
.s-hd{
    font-size:16px;
    color:#333;
    font-weight:bold;
    border-bottom:1px solid #f5f5f5;
    padding-bottom:20px;
    margin-bottom:20px;
}
.expound{
    color:#999999;
    font-size: 12px;
}
.el-input{
    width:400px;
}

.form-line{
	margin-bottom:22px;
}
.margin{
    margin: 0 5px;
}
.expoundbackgroud{
    background:#f5f5f5;
}
.rules{
    background-color: #f5f5f5;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    color:#999999;
    font-size: 12px;
    padding: 10px  20px;
    line-height: 18px;
    position: relative;
}
.price{
    width: 468px;

}
.refund{
    width: 358px;
}
.price p,.refund p{
    line-height: 30px;
    margin:  5px 0;
}
.rule-content{
    line-height: 20px;
}
.arrow{
    display:block;
    width:0;
    height:0;
    border-width:0 10px 10px;
    border-style:solid;
    border-color:transparent transparent #d9d9d9;
    position:absolute;
    top:-10px;
    left:70px;
    margin-left:-10px;
}

.arrow em{
    display:block;
    width:0;
    height:0;
    border-width:0 10px 10px;
    border-style:solid;
    border-color:transparent transparent #f5f5f5;
    position:absolute;
    top:1px;
    left:-10px;
}
ul,li{
    margin: 5px;
}
</style>
