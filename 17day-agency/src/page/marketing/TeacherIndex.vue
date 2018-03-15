<template>
    <div class="setting-wrap">
        <teacher-info  :teacherInfo="personalInfoArr" @getData="settingDatas"  ref="teacherchildMethod" @submitType="getSubmitType"></teacher-info>
        <subject :subjectFrom="subjectFromList" :classList="subjectList" ref="subjectchildMethod"  @submitType="getSubmitType"  @getData="settingDatas" ></subject>
        <div class="submit-cont">
            <el-button @click="previewData">{{$t('common.btn.preview')}}</el-button>
            <el-button type="primary" @click="saveTeacherData">&nbsp;{{$t('common.btn.submit')}}&nbsp;</el-button>
            <span class="tips">{{$t('marketing.globle.tips.update')}}</span>
        </div>
    </div>
</template>
<script type="es6">
    import subject from './PersonSubject.vue'
    import teacherInfo from './TeacherIndexInfo.vue'
    import * as api from '@/js/api'
    import { Loading } from 'element-ui';
    export default {
        name: 'teacherIndex',
        data(){
            return {
                subjectFromList:[],
                subjectList:[],
                teacherSettingData:{
                    classList:[],
                    personalInfo:{}
                },
                personalInfoArr:[],
                teacherSubmit:true,
                subjectSubmit:true
            }
        },
        created(){
            this.getData()
        },
        methods:{
            getSubmitType(type){//获取验证子组件表单的通过状态
                if(type[0]=="teacher"){
                    this.teacherSubmit=type[1]
                }else if(type[0]=="subject"){
                    this.subjectSubmit=type[1]
                }
            },
            getChildType(){
                this.$refs.teacherchildMethod.incrementTotal();
                this.$refs.subjectchildMethod.incrementTotal();
            },
            saveTeacherData(){
                //触发子组件验证表单方法
                this.getChildType()
                if(this.teacherSubmit&&this.subjectSubmit){
                    api.personSetting.saveTeacherSetting(this.teacherSettingData).then(res=>{
                        if(res.status==200){
                            this.$message({
                                message: '设置成功',
                                type: 'success'
                            });
                        }else{
                            this.$message.error(res.msg)
                        }
                    })
                }
            },
            getData(){    //ajax请求获取数据
                api.personSetting.getTeacherSetting().then(data =>{
                    for (let i of data.classList) {
                        this.subjectFromList.push(i)
                    }
                    this.personalInfoArr.push(data.personalInfo)
                })
                api.personSetting.getClass().then(res =>{
                    let data=res.data.list;
                    if(res.status==200){
                        this.subjectList=data.concat();
                    }else{
                        this.subjectList= [];
                    }
                })
            },
            settingDatas(list){
                switch(list[0]){
                    case 0:
                        this.teacherSettingData.personalInfo=list[1]
                    break;
                    case 1:
                        this.teacherSettingData.classList=list[1];
                    break;
                }
            },
            previewData(){//预览
                this.getChildType()
                if(this.teacherSubmit&&this.subjectSubmit){
                    let w=window.open();
                    api.personSetting.preview("/api/personal/preview",this.teacherSettingData).then(res => {
                        if(res.status==200){
                            w.location = `http://${res.data.url}`;
                        }else{
                            w.close()
                            this.$message.error(res.msg)
                        }
                    })
                }
            }
        },
        components: {
            subject,
            teacherInfo,
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .setting-wrap{
        width: 1004px;
        .submit-cont{
            width: 365px;
            margin: 40px auto;
            .tips{
                color: #999;
                font-size: 12px;
                line-height: 38px;
                padding-left: 15px;
            }
        }
    }
</style>
