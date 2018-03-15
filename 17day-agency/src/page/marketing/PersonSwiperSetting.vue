<template>

    <div class="swiper-cont">
        <h2 class="title">{{ $t('marketing.index.advertising_map.title')}}<span>{{ $t('marketing.index.advertising_map.tips')}}</span></h2>
        <div class="setting-img clearfix">
           <div>
               <ul class="list-tit clearfix">
                   <li>{{ $t('marketing.index.advertising_map.picture')}}</li>
                   <li>{{ $t('marketing.index.advertising_map.transition.text')}}</li>
                   <li>{{ $t('marketing.index.advertising_map.operation.text')}}</li>
               </ul>
               <div  class="list-cont">
                   <el-form :model="swiperData" ref="swiperData" class="w-demo-form" >
                       <ul v-for="(item,index) in swiperData.swiperFormList" :key="item.key" class="clearfix">
                           <li>
                               <div class="upload-img clearfix">
                                   <div class="upload-img-cont">
                                       <el-form-item>
                                           <image-uploader v-model="item.image" :sizeMax="2048000" @error="onImageSelectError" @change="dispatchChangeForElItem"></image-uploader>
                                       </el-form-item>
                                   </div>
                                    <p class="tips">{{ $t('marketing.index.advertising_map.size')}}</p>
                               </div>
                               <div>
                                   <el-button v-show="index==swiperData.swiperFormList.length-1" class="w-button" :disabled="index==4?!add_isdisabled:add_isdisabled" @click="addList(index)">{{ $t('marketing.index.advertising_map.add')}}</el-button>
                               </div>
                           </li>
                           <li>
                               <div class="select-cont">
                                   <el-row :gutter="15">
                                       <el-col :span="10">
                                           <el-select v-model="item.landing_type" class="w-select" @change="landingType(item.landing_type,index)">
                                               <el-option
                                                   v-for="items in options" :key="items.value" :label="items.label" :value="items.value">
                                               </el-option>
                                           </el-select>
                                       </el-col>
                                        <el-col :span="10" v-if="item.landing_type==1">
                                            <el-form-item>
                                                <el-select  class="w-select" filterable v-model="item.course_id" :placeholder=" $t('marketing.index.advertising_map.courses_list')">
                                                    <el-option
                                                       v-for="classItem in swiperData.subjectList" :key="classItem.id" :label="classItem.name" :value="classItem.id">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                   </el-row>
                               </div>
                           </li>
                           <li>
                               <div class="edit-cont">
                               <el-button type="text" :disabled="index==0?move_isdisabled:!move_isdisabled" @click="moveUp(index,swiperData.swiperFormList)">{{$t('marketing.globle.move[0]')}}</el-button>
                               <el-button type="text" :disabled="index==swiperData.swiperFormList.length-1?move_isdisabled:!move_isdisabled" @click="moveDown(index,swiperData.swiperFormList)">{{$t('marketing.globle.move[1]')}}</el-button>
                               <el-button type="text" :disabled="swiperData.swiperFormList.length==1?move_isdisabled:!move_isdisabled" @click="deleteList(index)">{{$t('marketing.globle.move[2]')}}</el-button>
                               </div>
                           </li>
                       </ul>
                   </el-form>
               </div>

           </div>
        </div>
    </div>
</template>
<script type="es6">
    import ImageUploader from '@/components/upload/ImageUploader'
    import utils from '@/js/utils'
    import validatorMixin from '@/js/mixin/validatorMixin'
    import movePosition from '@/js/mixin/movePositionMixin'

    export default {
        mixins: [validatorMixin,movePosition],
        name: 'SwiperSetting',
        props:{
            swiperForm:{//轮播图数据
                type:Array,
                default:function(){
                    return []
                }
            },
            subject:{//课程数据
                type:Array,
                default:function(){
                    return []
                }
            }
        },
        data(){
            return {
                options: [{//跳转状态下拉框
                    value: 0,
                    label: this.$t('marketing.index.advertising_map.transition.option[1]')
                }, {
                    value: 1,
                    label: this.$t('marketing.index.advertising_map.transition.option[0]')
                }],
                add_isdisabled:false,//按钮禁用
                move_isdisabled:true,//移动按钮禁用
                swiperData:{//全部数据
                    swiperFormList:[],
                    subjectList:[]
                }
            }
        } ,
        methods:{
            defaultData(){//轮播图默认数据
                return {landing_type:0, image:"",course_id:'',key:Date.now()};
            },
            addList(i){//添加新的轮播图 最多5张
                let swiperData=this.swiperData,
                    swiperLen=swiperData.swiperFormList.length;
                if(swiperLen<5){
                    swiperData.swiperFormList.push(this.defaultData());
                }
            },
            landingType(type,i){//选择不需要跳转 课程id设置为空
                if(type==0){
                    this.swiperData.swiperFormList[i].course_id=""
                }
            },
            //删除集合的某个元素
            deleteList(id){
                let swiperFormList= this.swiperData.swiperFormList;
                if(swiperFormList.length>1){
                    swiperFormList.splice(id,1)
                }
            },
            //需要提交的数据
            submitData(){
                this.$emit('getData',[0,this.swiperData.swiperFormList])
            }
        },
        components: {
            ImageUploader
        },
        watch:{
            swiperForm:function(val){//轮播图列表
                if(val.length>0){
                    this.swiperData.swiperFormList=val.concat()
                }else{
                    this.swiperData.swiperFormList.push(this.defaultData());
                }
            },
            subject:function(val){//课程列表
                if(val.length>0){
                    this.swiperData.subjectList=val.concat()
                }
            },
            swiperData:{//需要提交的数据
                handler: function (val, oldVal) {
                    this.submitData()
                },
                deep: true
            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .locale-en{
        .w-select{
            width: 190px
        }
        .list-cont,.list-tit {
            li:nth-child(1) {
                width: 380px;
            }
            li:nth-child(2) {
                width: 450px;
            }

        }

    }
    .list-cont,.list-tit {
        li:nth-child(1) {
            width: 425px;
        }
        li:nth-child(2) {
            width: 400px;
        }
        li:nth-child(3) {
            width: 130px;
        }
    }
    .swiper-cont{
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
    .setting-img{
        .list-tit{
            padding: 0 20px;
            background-color: #f5f5f5;
            border: 1px solid #d9d9d9;
            border-radius: 4px 4px 0 0;
            li{
                float: left;
                height: 50px;
                line-height: 50px;
                font-size: 14px;
                color: #333;

            }
        }
        .list-cont{
            border: 1px solid #d9d9d9;
            border-top:0 none;
            border-radius: 0 0 4px 4px;
            background-color: #fff;
            padding:20px 20px 0 20px;
            ul:last-child{
                padding-bottom: 20px;
            }
            li{
                float: left;

                .upload-img{
                    overflow: hidden;
                    padding-bottom: 20px;
                    .upload-img-cont{
                        width: 240px;
                        height: 60px;
                        float: left;
                    }
                    .tips{
                        color: #999;
                        font-size: 14px;
                        float: left;
                        padding-left: 20px;
                        margin: 0;
                        width: 120px;
                        padding-top: 15px;
                    }
                }
                .select-cont,.edit-cont{
                    padding-top: 15px;
                }

            }

        }
    }
    }
</style>
<style lang="scss" type="text/css">

    .setting-wrap{
        .single-image-uploader{
            .siu-input{
                height: 60px!important;
                margin: 0px!important;
                width: 240px!important;
                box-sizing: content-box;
                border-radius: 4px;
                img{
                    width: 100%;
                    height: 60px!important;
                    border-radius:4px ;
                }
                i{
                    margin: 0!important;
                    font-size: 12px!important;
                    & + div{
                        display: inline-block;
                    }
                }
                & >div{
                       line-height: 60px;
                       cursor: pointer;
                }
                .mask{
                    line-height: 60px!important;
                    border-radius: 4px;
                }

            }
        }
    }

</style>



