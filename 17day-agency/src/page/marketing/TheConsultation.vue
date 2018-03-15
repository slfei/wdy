<template>
    <div class="consultation-wrap">
        <h2 class="title">{{$t('marketing.consultant.title')}}</h2>
        <div class="cont">
            <el-form ref="consultationFrom" :rules="rules" :model="consultationFrom" label-width="115px" class="w-demo-form">
                <el-row>
                    <el-col :span="21">
                        <el-form-item :label="$t('marketing.consultant.name')" prop="link">
                            <el-input class="w-input" v-model="consultationFrom.link" :placeholder="$t('marketing.consultant.example')"></el-input>
                            <br><p style="line-height: 20px;width: 500px;    color:#999999;font-size: 12px;">{{$t('marketing.consultant.tips')}}</p>
                        </el-form-item>
                    </el-col>
                </el-row>
                <div>
                    <el-button type="primary" @click="submitForm('consultationFrom')">{{$t('common.btn.save')}}</el-button>
                </div>
            </el-form>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
    import * as api from '@/js/api'
    export default {
        name: 'consultation',
        data(){
//            var validateLink = (rule, value, callback) => {
//                if (value === '') {
//                  callback(new Error('请填写服务账号链接'));
//                } else {
//                    let match = /^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/;
//                    if(!match.test(value)){
//                        callback(new Error('账号链接格式为以http://、https://、ftps://开头，中间包含字母或数字，末尾包含.com、.cn、.net等的格式'));
//                    }else{
//                        callback()
//                    }
//                }
//            };
            return {
                consultationFrom:{
                    link:""
                },
                rules:{
                    link: [
                    { type:'url', required:false,trigger: 'blur', message: this.$t('marketing.consultant.filter') }
                  ],
                }
            }
        },
        created(){
            this.getData()
        },
        methods:{
            submitForm(formName){
                 this.$refs[formName].validate((valid) => {
                  if (valid) {
                        api.personSetting.saveContactus({contact_url:this.consultationFrom.link}).then(res =>{
                            if(res.status==200){
                                this.$message({
                                  message: this.$t('marketing.globle.tips.setting'),
                                  type: 'success'
                                });
                                this.getData();
                            }else{
                                this.$message(res.msg)
                            }
                        })
                  } else {
                        return false;
                  }
                });
            },
            getData(){
                api.personSetting.getContactus().then(res =>{
                    if(res.status==200){
                        this.consultationFrom.link=res.data.contact_url
                    }else{
                        this.$message.error(res.msg)
                    }

                })
            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .consultation-wrap{
        width: 1000px;
        .title{
            font-size: 16px;
            color: #333;
            font-weight:inherit;
            padding-bottom: 25px;
            margin:0;
            span{
                font-size: 12px;
                color: #999;
                display: inline-block;
                padding-left: 20px;
            }
        }
        .cont{
            width:800px;
            .float-l{
                float: left;
                width: 300px;
            }
            .mr-15{
                margin-right: 15px;
            }
        }
    }

</style>
