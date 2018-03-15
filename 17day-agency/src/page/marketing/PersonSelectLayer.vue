<template>
    <div class="select-subject-wrap">
        <div class="cont">
            <el-dialog
                :title="title"
                custom-class="w-dialog w-dialog-regular"
                :close-on-click-modal="false"
                :visible.sync="dialogVisible"
                :before-close="closeSelect">
                <div class="main-cont">
                    <el-transfer class="w-transfer"
                        v-model="dataList"
                        filterable
                        :filter-placeholder="$t('marketing.globle.layer.placeholder')"
                        :props="{ key:'id',label:'name'}"
                        :titles="[leftName, rightName]"
                        :button-texts="[$t('marketing.globle.layer.delete_btn'), $t('marketing.globle.layer.add_btn')]"
                        :footer-format="{
                        noChecked: '${total}',
                        hasChecked: '${checked}/${total}'
                        }"
                        :data="dataVal">
                    </el-transfer>
                    <div class="warning-tips">
                        <span><i class="el-icon-information"></i>{{maxtips}}</span>
                    </div>
                </div>
                  <span slot="footer" class="dialog-footer">

                    <el-button type="primary" @click="selectData">{{$t('common.btn.ok')}}</el-button>
                      <el-button @click="closeSelect">{{$t('common.btn.cancel')}}</el-button>
                  </span>
            </el-dialog>
        </div>
    </div>

</template>
<script type="es6">
    import * as api from '@/js/api'
    export default {
        name: 'selectLayer',
        props:{
            title:{
                type:String,
                default(){
                    return this.$t('privilege.layer.title')
                }
            },
            leftName:{
                type:String,
                default(){
                    return this.$t('privilege.layer.leftName')
                }
            },
            rightName:{
                type:String,
                default(){
                    return this.$t('privilege.layer.rightName')
                }
            },
            //数据列表
            dataVal:{
                type:Array
            },
            //已选数据的id
            dataListVal:{
                type:Array
            },
            //可选择最大值 不传值为没有限制
            max:{
                type:Number
            },
            //错误提示
            maxtips:{
                type:String
            },
            dialogVisible:{
                type:Boolean,
                default:false
            }
        },
        data() {
            return {
                showSelectType:false,
                dataListAll:[],
                dataList:[],
                maxNumArr:[]
            }
        },
        methods:{
            closeSelect(){//关闭
                this.$emit('hideSelect',this.showSelectType);
                this.dataList=[];
            },
            selectData(){//匹配已选数据
                this.dataListAll=[];
                for (var value of this.dataVal) {
                    for(var i of this.dataList){
                        if(value.id==i){
                            this.dataListAll.push(value)
                        }
                    }
                }
                if(this.max||this.max==0){//限制选择最大值
                    if(this.dataListAll.length>this.max){
                        this.$message.error(this.maxtips);
                        return
                    }else{
                        this.$emit('getData',this.dataListAll);
                        this.closeSelect();
                    }
                }else{
                    this.$emit('getData',this.dataListAll);
                    this.closeSelect();
                }
            }
        },
        watch:{
            dataListVal(){//父组件传递的数据
                this.dataList=this.dataListVal.concat();
            }
        }
    }
</script>
<style lang="scss" scoped="" type="text/css">
    .select-subject-wrap{
        .cont{
            .main-cont{
                width: 562px;
                margin:0 auto;
                .warning-tips{
                    color: #999;
                    font-size: 12px;
                    margin:10px 0 0;
                    i{
                        color: #268fff;
                        padding-right: 5px;
                    }
                }
            }
        }
    }
</style>
