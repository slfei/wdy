<template>
    <div class="subject-wrap">
        <h2 class="title">{{ $t('marketing.index.course.title')}}<span>{{ $t('marketing.index.course.tips')}}</span></h2>
        <div class="subject-setting">
            <el-form :model="subjectData" ref="subjectData" label-width="130px" class="w-demo-form">
                    <div  v-for="(item,index) in subjectData.subjectFromList" :key="item.key"  class="clearfix p-relative" >
                        <div class="list-setting">
                            <div>
                                <el-form-item :label="$t('marketing.index.course.name.title')"
                                              :prop="'subjectFromList.' + index + '.name'"
                                              :key="item.key"
                                              :rules="[{ min: 2, max: 8, message: $t('marketing.index.course.name.filter[1]'), trigger: 'blur' }] ">
                                    <el-row>
                                        <el-col :span="14">
                                            <el-input class="w-input" v-model="item.name" :placeholder="$t('marketing.index.course.name.filter[0]')"></el-input>
                                        </el-col>
                                    </el-row>
                                </el-form-item>
                                <dl class="clearfix">
                                    <dt>{{$t('marketing.index.course.course_list.title')}}</dt>
                                    <dd>
                                        <div class="tips">{{$t('marketing.index.course.course_list.tips')}}</div>
                                        <el-button class="w-button" @click="addClass(index)">{{ $t('marketing.index.course.course_list.select')}}</el-button>
                                        <div class="addclass-cont">
                                            <draggable v-model="item.class"  @start="dragMove(index)" @end="dragEnd">
                                                <transition-group>
                                                    <div class="draggable-cont" :class="{'draggable-border':draggabletype==index}"  v-for="element in item.class" :key="element.name">
                                                        <div class="img-border">
                                                            <div>
                                                                <img :src="element.image"  alt=""/>
                                                            </div>
                                                        </div>
                                                        <p>{{element.name}}</p>
                                                    </div>
                                                </transition-group>
                                            </draggable>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="edit-cont">
                            <el-button type="text" :disabled="index==0?move_isdisabled:!move_isdisabled" @click="moveUp(index,subjectData.subjectFromList)">{{$t('marketing.globle.move[0]')}}</el-button>
                            <el-button type="text" :disabled="index==subjectData.subjectFromList.length-1?move_isdisabled:!move_isdisabled" @click="moveDown(index,subjectData.subjectFromList)">{{$t('marketing.globle.move[1]')}}</el-button>
                            <el-button type="text" :disabled="subjectData.subjectFromList.length==1?move_isdisabled:!move_isdisabled" @click.prevent="deleteList(index)">{{$t('marketing.globle.move[2]')}}</el-button>
                        </div>
                    </div>
            <el-button @click="addSubject" class="w-button mb-20" :disabled="subjectData.subjectFromList.length==3?!add_isdisabled:add_isdisabled">{{$t('marketing.index.course.add')}}</el-button>
            </el-form>
        </div>
        <select-layer :title="$t('marketing.index.course.layer.title')" :leftName="$t('marketing.index.course.layer.leftName')" :rightName="$t('marketing.index.course.layer.rightName')" :maxtips="$t('marketing.index.course.layer.maxtips')" :dataListVal="dataList"  v-show="showType" :dataVal="classList" @getData="getData" :max='8' :dialogVisible="showType"  @hideSelect ="Selectfn"></select-layer>
    </div>
</template>
<script type="es6" >
    import draggable from 'vuedraggable'//拖拽排序
    import selectLayer from './PersonSelectLayer.vue'
    import * as api from '@/js/api'
    import { Loading } from 'element-ui';
    import movePosition from '@/js/mixin/movePositionMixin'
    export default {
        mixins: [movePosition],
        name: 'SubjectSetting',
        props:{
            subjectFrom:{
                type:Array,
                default(){
                    return []
                }
            },
            classList:{//课程列表
                type:Array,
                default(){
                    return []
                }
            }
        },
        data() {
            return {
                move_isdisabled:true,//上移、下移、删除按钮是否禁用
                add_isdisabled:false,//添加按钮是否禁用
                showType:false,
                layerIndex:0,
                dataList:[],
                subjectData:{
                    subjectFromList:[{name: "", class: [],key:Date.now()}]
                },
                draggabletype:'-1'
            }
        },
        methods:{
            defaultData(){
                return  {name: "", class: [],key:Date.now()};
            },
            addSubject(){//添加集合
                let subjectFromList=this.subjectData.subjectFromList;
                if(subjectFromList.length<3){
                    subjectFromList.push(this.defaultData());
                }
            },
            deleteList(index){//删除集合某个元素
                if(this.subjectData.subjectFromList.length>1){
                    this.subjectData.subjectFromList.splice(index,1)
                }
            },
            Selectfn(type){//隐藏选择课程的弹框
                this.showType=type;
            },
            getData(list){//选择课程后回显
                this.subjectData.subjectFromList[this.layerIndex].class=list.concat()
            },
            addClass(i){//添加课程 将已经选中的id带到弹框中渲染弹框右侧数据
                this.showType=true;
                this.layerIndex=i;
                this.dataList=[];
                if(this.subjectData.subjectFromList[i].class.length){
                    for (let i=0;i<this.subjectData.subjectFromList[this.layerIndex].class.length;i++){
                        this.dataList.push(this.subjectData.subjectFromList[this.layerIndex].class[i].id)
                    }
                }
            },
            submitData(){//将数据传给父组件
                this.$emit('getData',[1,this.subjectData.subjectFromList])
            },
            incrementTotal(){//在父组件验证表单
                let formName="subjectData";
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submitType',["subject",true])
                    }else{
                        this.$emit('submitType',["subject",false])
                        return false;
                    }
                });
            },
            dragMove(i){
                this.draggabletype=i
            },
            dragEnd(){
                this.draggabletype=-1
            }
        },
        components:{
            selectLayer,
            draggable
        },
        watch:{
            subjectFrom:function(val){//父组件请求接口后把值传给子组件
                if(val.length>0){
                    this.subjectData.subjectFromList=val
                }else{
                    this.subjectData.subjectFromList.push(this.defaultData());
                }
            },
            subjectData:{//检测数据变化 传给父组件
                self:this,
                handler: function (val, oldVal) {
                    this.submitData()
                },
                deep: true
            }
        }
    }
</script>
<style lang="scss" scoped="" type="text/css">
    .p-relative{
        position: relative;
        &:last-of-type{
            .list-setting{
                margin-bottom:20px!important;
            }
        }
    }
    .tips{
        color: #999;
        font-size: 12px;
        line-height:38px;
    }
    .subject-wrap{
        .title{
            font-size: 16px;
            color: #333;
            font-weight:inherit;
            margin-bottom: 0;
            padding:20px 0 25px;
            margin:0;
            span{
                font-size: 12px;
                color: #999;
                display: inline-block;
                padding-left: 20px;
            }
        }
        .subject-setting{
            .mb-20{
                margin-bottom: 20px;
            }
            .list-setting{
                border:1px solid #d9d9d9;
                border-radius: 4px;
                width: 870px;
                padding: 20px;
                padding-bottom: 10px;
                float: left;
                margin-bottom:40px;

                dl{
                    margin: 0;
                }
                dt,dd{
                    float: left;
                    display: inline-block;

                }
                dt{
                    width: 130px;
                    padding-right: 10px;
                    text-align: right;
                    line-height: 36px;
                    padding-bottom:5px;
                    font-size:14px;
                    ins{
                        text-decoration: none;
                        color: #ff1818;
                        padding-right: 3px;
                        font-size: 18px;
                        font-weight:bold;
                    }

                }
                dd{
                    width:600px;
                    margin-left:0px;
                    .draggable-cont{
                        display: inline-block;
                        width: 160px;
                        word-wrap: break-word;
                        font-size:14px;
                        cursor:move;
                        padding: 5px;
                        box-sizing: content-box;
                        border: 2px transparent dashed;
                        border-radius: 4px;
                        margin-right:15px;
                        margin-left:-7px;
                        vertical-align: text-top;
                        margin-bottom:5px;
                        img{
                            width: 100%;
                            height: 90px;
                            border-radius: 4px;
                        }
                        p{
                            margin: 5px 0 0px;
                            display: -webkit-box;
                            -webkit-box-orient: vertical;
                            -webkit-line-clamp: 3;
                            overflow: hidden;
                            max-height: 49px;
                        }
                    }
                    .draggable-border{
                        border: 2px #ccc dashed;
                    }

                }
            }
            .addclass-cont{
                margin-top: 20px;
                position: relative;
            }
            .showErro{
                color: #f00;
                opacity: 1;
                font-size: 12px;
                animation:mymove .2s forwards;
            }
            @keyframes mymove
            {
                0%{opacity: 0}
                55%{opacity: 0}
                100%{opacity: 1}
            }

            .edit-cont{
                position: absolute;
                left:889px ;
                top: 50%;
                margin-top: -37px;
                width: 150px;
            }
        }
    }
</style>
<style>
    .addclass-cont >div >div{
        float: left;
        margin-right: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 160px;
    }
    .subject-wrap .subject-setting .addclass-cont{
        margin-top: 10px!important;
    }
    .addclass-cont >div >div img{
        width: 100%;
        height: 90px;
        border-radius: 4px;
        cursor: move;
    }
</style>
