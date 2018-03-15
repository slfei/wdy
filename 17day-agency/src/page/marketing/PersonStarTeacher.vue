<template>
    <div class="teacher-wrap">
        <h2 class="title">{{ $t('marketing.index.lecturer.title')}}<span>{{ $t('marketing.index.lecturer.tips')}}</span></h2>
        <div class="cont">
            <el-form :model="teacherData" ref="personSetting" label-width="150px" class="w-demo-form" >
                <el-form-item  :label="$t('marketing.index.lecturer.name')">
                    <el-row>
                        <el-col :span="12"><el-input icon="el-input__icon el-icon-caret-bottom" class="w-input" v-model="teacherData.nameList" @focus="addTeacher" :readonly="true" ></el-input></el-col>
                    </el-row>
                </el-form-item>
            </el-form>
        </div>
        <select-layer :title="$t('marketing.index.lecturer.layer.title')" :leftName="$t('marketing.index.lecturer.layer.leftName')" :rightName="$t('marketing.index.lecturer.layer.rightName')" :max='4' :maxtips="$t('marketing.index.lecturer.layer.maxtips')" :dataListVal="dataList" :dataVal="layerData" @getData="getData" :dialogVisible="showType"  v-show="showType"  @hideSelect ="Selectfn"></select-layer>
    </div>
</template>
<script type="text/ecmascript-6">
    import selectLayer from './PersonSelectLayer.vue'
    import * as api from '@/js/api'
    export default {
        name: 'TeacherSetting',
        props:{
            names:{
                type:String
            },
            teacher:{
                type:Array,
                default:function(){
                    return [{
                        id:'',
                        name:""
                    }]
                }
            }
        },
        data(){
            return {
                showType:false,//选择弹框显示状态
                layerData:[],//选择弹框的数据
                dataList:[],//已经选择的讲师用来控制弹框右侧显示内容
                teacherData:{//讲师列表
                    teacherFormList:[],
                    nameList:""
                }

            }
        },
        created(){
            this.getTeacherList()
        },
        methods:{
            Selectfn(type){
                this.showType=type
            },
            addTeacher(i){
                this.showType=true;
                this.dataList=[];
                if(this.teacherData.teacherFormList.length>0){
                    for (let i=0;i<this.teacherData.teacherFormList.length;i++){
                        this.dataList.push(this.teacherData.teacherFormList[i].id)
                    }
                }
            },
            getData(list){
               this.teacherData.teacherFormList.length=0
                let nameArr=[];
                for(let i=0;i<list.length;i++){
                    nameArr.push(list[i].name);
                    this.teacherData.teacherFormList.push(list[i])
                }
//                console.log(this.teacherData.teacherFormList)
                this.teacherData.nameList=nameArr.join(',');
            },
            getTeacherList(){
                api.personSetting.getTeacher().then(data =>{
                      this.layerData=data;
                })
            },
            submitData(){

                this.$emit('getData',[2,this.teacherData.teacherFormList])
            }
        },
        components:{
            selectLayer
        },
        watch:{
            names:function(){//已选的讲师逗号隔开
                this.teacherData.nameList=this.names
            },
            teacher:function(){
                if(this.teacher.length>0){//讲师列表
                    this.teacherData.teacherFormList=this.teacher.concat()
                }
            },
            teacherData:{
                handler: function (val, oldVal) {
                    this.submitData()
                },
                deep: true
            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">

    .ml20{
        margin-left: 20px;
    }
    .teacher-wrap{
        .title{
            font-size: 16px;
            color: #333;
            font-weight:inherit;
            padding:20px 0 25px;
            margin:0;
            span{
                font-size: 12px;
                color: #999;
                display: inline-block;
                padding-left: 20px;
            }
        }
        .cont{
            dt,dd{
                float: left;
                display: inline-block;
            }
            dt{
                width: 120px;
                padding-right: 20px;
                text-align: right;
                line-height: 36px;
                padding-bottom:5px;
                ins{
                    text-decoration: none;
                    color: #f00;
                    padding-right: 3px;
                }
            }
            dd{
                margin-right: 20px;
            }
        }
    }
</style>
