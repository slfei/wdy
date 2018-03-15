<template>
	<div id="personalInfo">
		<h3>{{$t('person.title')}}</h3>
		<el-form label-width="90px">
			<el-form-item :label="$t('person.number')">
				<div v-text="info.user_account"></div>
			</el-form-item>
			<el-form-item :label="$t('person.nickname')">
				<div v-text="info.nick_name"></div>
			</el-form-item>
			<el-form-item :label="$t('person.role')">
				<div v-text="info.role_name"></div>
			</el-form-item>
			<el-form-item :label="$t('person.bind')">
			    <span v-text="info.institute_name"></span>
				<el-button type="info" :plain="true" @click="offBound" class="btn w-button" v-show="info.role_id!=1">{{$t('person.unbind')}}</el-button>
			</el-form-item>
		</el-form>

		<el-dialog
            :title="$t('person.dialog.title')"
            :visible.sync="visible"
            size="tiny"
            top="40%"
            :close-on-click-modal='false'>
            <div class="warning">
            	<span class="el-icon-warning"></span>
            	{{$t('person.dialog.no_privilege')}}
            </div>
      </el-dialog>
	</div>
</template>
<script>
import Vue from "vue"
import ImageUploader from "@/components/upload/ImageUploader"
import * as api from '@/js/api'
import bus from "@/js/eventBus"
export default {
		name:"personalInfo",
		data(){
			return{
                visible:false,
                iscurrentType:"",
                info:{
                    user_account:"",
                    nick_name:"",
                    role_name:"",
                    institute_name:"",
                    role_id:window.USER_INFO ? window.USER_INFO.role:''
                }
			}
		},
		beforeCreate(){
			api.common.checkCurrenttype().then(res=>{
				if(res.status==705){
                  	this.iscurrentType=3
                }else{
                	this.iscurrentType=res.data.type
                }
			})
		},
		created(){
			this.initData()
		},
		methods:{
		    initData(){
			    api.personal.getPersonInfo().then(res=>{
				    this.info=res.personalinfo
			    })
		    },
		    offBound(){
				this.$confirm( this.$t('person.confirm.cont[0]')+this.info.institute_name+this.$t('person.confirm.cont[1]'), this.$t('person.confirm.title'), {
                    cancelButtonText: this.$t('common.btn.cancel'),
                    confirmButtonText: this.$t('common.btn.ok'),
                    type: 'warning',
                    customClass:"cancel",
                    closeOnClickModal:false
                }).then(() => {
                    api.personal.unbind().then(res=>{
                        if(res.status==200){
                            this.visible=true;
                            setTimeout(()=>{
                                this.visible=false;
                                location.href="//"+window.WWW_HOST
                                //要跳转主页 2后自动关闭提示框window.WWWW_HOST
                            },2000)
                        }
                    })

                }).catch(() => {

                });
            },
		}
	}
</script>

<style lang="scss">
#personalInfo{
	h3{
		font-size: 16px;
		font-weight:500;
	}
    .el-form-item{
        margin-bottom: 10px;
    }
    .el-form-item__label{
    	font-size: 14px;
    }
    .el-form-item__content div,
    .el-form-item__content span{
    	font-size: 14px;
    	color: #999999;
    }
    .el-button{
    	background: #fff;
    	color: #268fff;
    	border: 1px solid #268fff;
    	margin-left: 20px;
    	}
    	.el-button span{
    		color: #268fff;
    	}
    .warning{
    	font-size: 14px;
       .el-icon-warning{
    		color: darkred;
    		display: inline-block;
    		font-size: 14px;
    		margin-right: 5px;
        }
    }
    .btn{
    	height:32px;
    	width: 88px;
    	line-height: 0;
    }
    /*******/
    .el-dialog{
    	width: 450px;
    	height: 130px;
    	border-radius: 3px;

    .el-dialog__header{
    	background: #268FFF;
    	padding:  0 20px;
    	height: 44px;
    	line-height: 44px;
    	border-top-left-radius: 3px;
    	border-top-left-radius: 3px;
    	.el-dialog__title{
    		color: #fff;
    		font-size: 14px;
    		margin-top: -15px;
    		}
    	.el-dialog__headerbtn{
			margin-top:13px;
			.el-icon-close{
				color: #fff;
				font-size: 12px;
			}
    	}
    	}
    	.el-dialog__body{
    		height: 86px;
    	}
    	.warning{
    		margin-left:20px;
    		margin-top:5px;
    	}
    	.el-icon-warning:before {
    		content: "\E623";
    		color: #ff1818 !important;
    		font-size: 15px;
        }
     }
}
</style>
<style lang="scss" src="@/styl/tip.scss"></style>
