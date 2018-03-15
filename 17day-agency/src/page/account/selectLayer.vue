<template>
    <div class="select-subject-wrap">
        <div class="cont">
            <el-dialog
              	top="20%"
                :title="title"
                 custom-class="w-dialog w-dialog-regular"
                :close-on-click-modal="false"
                :visible.sync="dialogVisible"
                :before-close="closeSelect">
                <div class="main-cont">
                    <el-transfer
                    	class="w-transfer"
                        v-model="dataList"
                         filterable
                        :filter-placeholder="$t('privilege.layer.placeholder')"
                        :props="{ key:'account_id',label:'account_name'}"
                        :titles="[leftName, rightName]"
                        :button-texts="[$t('privilege.layer.delete_btn'), $t('privilege.layer.add_btn')]"
                        :footer-format="{
                            noChecked: '${total}',
                            hasChecked: '${checked}/${total}'
                        }"
                        :data="dataVal">
                    </el-transfer>
                    <div class="warning-tips">
                        <span><i></i></span>
	                </div>
                    <div slot="footer" class="dialog-footer">
                        <el-button type="primary"  @click="selectData">{{$t('common.btn.ok')}}</el-button>
                        <el-button  @click="cancel">{{$t('common.btn.cancel')}}</el-button>
                    </div>
                </div>
            </el-dialog>
        </div>
    </div>
</template>
<script>
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
            dataVal:{
                type:Array
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
                dataList:[]
            }
        } ,
        methods:{
            closeSelect(){
                this.$emit('hideSelect',this.showSelectType);
                this.dataList=[]
            },
            selectData(){
                this.dataListAll=[];
                for (var value of this.dataVal) {
                    for(var i of this.dataList){
                        if(value.account_id==i){
                            this.dataListAll.push(value.account_id)
                        }
                    }
                }
                this.$emit('addRole',this.dataListAll);
                this.closeSelect();
            },
            cancel(){
            	    this.$confirm(this.$t('privilege.confirm.cont.cancel'), this.$t('privilege.confirm.title'), {
                        confirmButtonText: this.$t('common.btn.ok'),
                        cancelButtonText: this.$t('common.btn.cancel'),
			            type: 'warning',
			            customClass:"cancel"
			        }).then(() => {
			          this.closeSelect()
			        }).catch(() => {

			        });
            }

        },


    }
</script>
<style lang="scss" scoped type="text/css">
    .select-subject-wrap{
        .cont{
        	.el-dialog{
        		height: 502px;
        	}
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
            .dialog-footer{
            	display: flex;
            	justify-content: flex-end;
            }

        }
    }

</style>
<style lang="scss" src="@/styl/tip.scss"></style>
