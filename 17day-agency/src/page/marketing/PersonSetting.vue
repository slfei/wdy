<template>
    <div class="setting-wrap">
        <swiper-setting :swiperForm="childData.swiperFormList" :subject="childData.subjectList" @getData="settingDatas"></swiper-setting>
        <subject :subjectFrom="childData.subjectFromList" :classList="childData.subjectList" ref="subjectchildMethod"  @submitType="getSubmitType"  @getData="settingDatas" ></subject>
        <star-teacher :names="childData.teacherFromList" :teacher="childData.teacherFrom" @getData="settingDatas"></star-teacher>
        <div class="submit-cont">
            <el-row>
                <el-col :span="24" :offset="8">
                    <el-button @click="previewData()">{{$t('common.btn.preview')}}</el-button>
                    <el-button type="primary"  @click="savePersonData">&nbsp;{{$t('common.btn.submit')}}&nbsp;</el-button>
                    <span class="tips">{{$t('marketing.globle.tips.update')}}</span>
                </el-col>
            </el-row>
        </div>

    </div>
</template>
<script type="es6">
    import swiperSetting from './PersonSwiperSetting.vue'
    import subject from './PersonSubject.vue'
    import starTeacher from './PersonStarTeacher.vue'
    import selectLayer from './PersonSelectLayer.vue'
    import * as api from '@/js/api'
    export default {
        name: 'PersonItem',
        data() {
            return {
                childData:{//子组件数据
                    swiperFormList:[],
                    subjectList:[],
                    subjectFromList:[],
                    teacherFrom:[],
                    teacherFromList:""
                },
                personSettingData:{//提交的数据
                    swiperList:[],
                    classList:[],
                    teacherList:[]
                },
                //子组件验证通过状态 true:通过 false:未通过
                subjectSubmit:true,
                url:''
            }
        } ,
        created(){
            this.getData()
        },
        methods:{
            settingDatas(list){//从子组件获取要提交的数据
                switch(list[0]){
                    case 0:
                        this.personSettingData.swiperList=list[1].concat();
                    break;
                    case 1:
                        list[1].map((item)=>{
                            item.class.map((list)=>{
                                delete list.key;
                                delete list.label;
                            })
                        })
                        this.personSettingData.classList=list[1].concat();
                    break;
                    default:
                        list[1].map((item)=>{
                            delete item.key;
                            delete item.label;
                        })
                        this.personSettingData.teacherList=list[1].concat();
                }
            },
            getSubmitType(type){//获取验证子组件表单的通过状态
                if(type[0]=="subject"){
                    this.subjectSubmit=type[1]
                }
            },
            getChildType(){
                this.$refs.subjectchildMethod.incrementTotal();
            },
            savePersonData(){
                this.getChildType()
                if(this.subjectSubmit){
                    api.personSetting.submitPersonSetting(this.personSettingData).then(res => {
                        if(res.status==200){
                            this.$message({
                                message: '提交成功',
                                type: 'success'
                            });
                            this.getData();
                        }else{
                            this.$message.error(res.msg)
                        }
                    })
                }
            },
            getData(){    //ajax请求获取数据
                let name=[],
                    childData=this.childData;
                api.personSetting.getSetting().then(res =>{
                    let data=res.data;
                    if(res.status==200){
                        childData.swiperFormList=data.swiperList.concat();
                        childData.subjectFromList=data.classList.concat();
                        childData.teacherFrom=data.teacherList.concat();
                        childData.teacherFrom.map(item=>{name.push(item.name)});
                        childData.teacherFromList=name.join(',');
                    }else{
                        [childData.swiperFormList,childData.subjectFromList,childData.teacherFrom] = [[]];
                    }
                })
                api.personSetting.getClass().then(res =>{
                    let data=res.data.list;
                    if(res.status==200){
                        childData.subjectList=data.concat();
                    }else{
                        childData.subjectList= [];
                    }
                })
            },
            previewData(){//预览
                let w=window.open();
                api.personSetting.preview("/api/institute/preview",this.personSettingData).then(res => {
                    if(res.status==200){
                        w.location = `http://${res.data.url}`;
                    }else{
                        w.close()
                        this.$message.error(res.msg)
                    }
                })
            }
        },
        components: {
            swiperSetting,
            subject,
            starTeacher,
            selectLayer
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .setting-wrap{
        width: 1004px;
        .submit-cont{
            margin: 40px 0;
            .tips{
                color: #999;
                font-size: 12px;
                line-height: 38px;
                padding-left: 15px;
            }
        }
    }
</style>
