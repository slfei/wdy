<template>
<div id="addmember">
    <!--添加成员页面 start-->
    <section class="addialogWraper">
        <div class="addialog">
            <header>
                <span>{{$t('members.props.addEdit')}}</span>
                <span @click="close" class="el-icon-close"></span>
            </header>
            <div class="content">
                <div class="accountTel">
                    <div>
                        <span>{{$t('members.addform.accountNumber')}}</span><span>{{telData.user_account}}</span><span>{{$t('members.addform.nickName')}}</span><span>{{telData.nick_name}}</span>
                        <p>{{$t('members.addform.textInfo')}}</p>
                    </div>
                </div>
                <el-form :model="addForm" label-width="50px" :rules="addFormRules" ref="addForm">
                    <el-form-item :label="$t('members.form.avatar')" prop='avatar'>
                        <image-uploader v-model="addForm.avatar" class="avatar">
                            <div class="state" slot="desc">
                                {{$t('members.rules.fileSize')}}<br> {{$t('members.rules.fileType')}}
                                <br /> {{$t('members.rules.fileLimite')}}
                            </div>
                        </image-uploader>
                    </el-form-item>

                    <el-form-item :label="$t('members.form.name')" prop="account_name">
                        <el-input v-model='addForm.account_name'></el-input>
                    </el-form-item>

                    <el-form-item :label="$t('members.form.tel')" prop="phone">
                        <el-input v-model='addForm.phone'></el-input>
                    </el-form-item>

                    <el-form-item :label="$t('members.form.email')" prop="email">
                        <el-input v-model='addForm.email'></el-input>
                    </el-form-item>

                    <el-form-item :label="$t('members.form.introduction')" prop="desc">
                        <el-input v-model.trim='addForm.desc' type="textarea"></el-input>
                    </el-form-item>

                </el-form>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitForm('addForm')">{{$t('members.btn.save')}}</el-button>

                <el-button @click.native="cancel">{{$t('members.btn.cancel')}}</el-button>

            </div>
        </div>
    </section>
    <!--添加成员页面 end-->
</div>
</template>

<script>
import Vue from "vue"
import ImageUploader from "@/components/upload/ImageUploader"
import * as api from '@/js/api'
import bus from "@/js/eventBus"
export default {
    name: "addmember",
    props: ["addformVisible"],
    data() {
        var checkTel = (rule, value, callback) => {
            var regTel = /^1[3|4|5|7|8]\d{9}$/;
            if (!value) {
                return callback(new Error(this.$t('members.rules.phoneNull')));
            } else if (!regTel.test(value)) {
                return callback(new Error(this.$t('members.rules.phonetype')));
            } else {
                callback()
            }
        };
        var checkName = (rule, value, callback) => {

            if (!value) {
                return callback(new Error(this.$t('members.rules.nameNull')));
            } else {
                callback()
            }
        };
        var checkEmail = (rule, value, callback) => {
            var reg = /^\w+(\.\w+)*@(\w){2,}((\.\w{2,3}){1,3})$/;
            var res = reg.test(value);
            if (!value) {
                return callback(new Error(this.$t('members.rules.emailNull')));
            } else if (!res) {
                return callback(new Error(this.$t('members.rules.emailType')));
            } else {
                callback()
            }
        };
        return {
            addFormVisible: false, //新增界面是否显示
            addFormRules: {
                name: [{
                    required: true,
                    message: this.$t('members.rules.nameNullError'),
                    trigger: 'blur'
                }]
            },
            telData: "",
            addForm: { //新增界面数据
                avatar: '',
                account_name: '',
                phone: '',
                email: '',
                desc: ''
            },
            addFormRules: {
                account_name: [{
                        required: true,
                        message: this.$t('members.rules.nameNullError'),
                        trigger: 'blur'
                    },
                    {
                        max: 10,
                        message: this.$t('members.rules.uploadSize'),
                        trigger: 'change,blur'
                    }
                ],
                avatar: [{
                    required: true,
                    message: this.$t('members.rules.avatorNull'),
                    trigger: 'change'
                }],
                phone: [{
                    required: true,
                    validator: checkTel,
                    trigger: 'blur'
                }],
                email: [{
                    required: true,
                    validator: checkEmail,
                    trigger: 'blur'
                }],
                desc: [{
                        required: true,
                        message: this.$t('members.rules.insNull'),
                        trigger: 'blur'
                    },
                    {
                        max: 200,
                        message: this.$t('members.rules.insSize'),
                        trigger: 'change,blur'
                    }
                ]
            }

        }
    },
    created() {
        bus.$on("send", (val) => {
            this.telData = val;
        })
    },
    methods: {
        submitForm(addForm) {
            this.$refs[addForm].validate((valid) => {
                if (valid) {
                    var obj = Object.assign(this.addForm, this.telData)
                    obj.account_id = obj.user_id
                    api.member.memberAdd(obj).then(res => {
                        if (res.data.status == 200) {
                            this.$message({
                                type: 'success',
                                message: this.$t('members.tip.saveSuccess')
                            });
                            this.$emit("changeaddV", false)
                            this.$emit("vary")
                            this.resetForm('addForm')
                        } else {
                            this.$message.error(this.$t('members.tip.saveError'));
                        }
                    });
                }
            });
        },
        resetForm(telForm) {
            this.$refs[telForm].resetFields();
        },
        cancel() {
            this.$confirm(this.$t('members.props.cancerWarn'), this.$t('members.props.tip'), {
                cancelButtonText: this.$t('members.btn.cancel'),
                confirmButtonText: this.$t('members.btn.confirm'),
                type: 'warning',
                customClass: "cancel"
            }).then(() => {
                this.$emit("changeaddV", false)
            });
        },
        close() {
            this.$emit("changeaddV", false)
        }
    },
    components: {
        ImageUploader
    },
}
</script>
<style lang="scss" >
#addmember .addialogWraper .single-image-uploader .siu-input{
    margin-right: 20px;
    min-width: 120px;
    max-width: 200px;
}
#addmember .single-image-uploader .siu-desc[data-v-93d09d18] {
    float: left;
    line-height: 18px;
    color: #999;
    width: 250px;
		max-width:250px;
}
#addmember{
section.addialogWraper{
  	width:100%;
  	height: 100%;
  	background: rgba(51,51,51,0.7);
  	position: fixed;
  	top: 0;
  	left: 0;
  	z-index:7;
  }
  .addialog{
  	position: absolute;
  	width: 534px;
  	height: 613px;
  	border-radius: 4px;
  	background:#fff;
  	left: 50%;
  	top: 50%;
  	margin-left: -267px;
  	margin-top:-291.5px;
  	z-index: 999;
  	header{
  	 	height: 44px;
  	 	width: 100%;
  	 	background: #268fff;
  	 	line-height: 44px;
  	 	display: flex;
  	 	justify-content: space-between;
  	 	align-items: center;
  	 	padding: 0 20px;
  	    margin-bottom: 20px;
  	 	color:#fff;
  	 	font-size: 14px;
 	    border-top-left-radius: 4px;
        border-top-right-radius: 4px;
  	 	.el-icon-close{
  	 		cursor: pointer;
  	 		font-size: 12px;
  	 	}
  	 }
  	.content{
  	 	padding: 0 40px;
  	    box-sizing: border-box;
  	    .avatar{

  	    	.siu-input{
  	    		border-radius:4px;
  	    	}
  	    	img{ min-width: 93px;
		  	     max-width:160px;
		  	     height: 93px;
  	        }
  	    }
  	    .state{
  	    	padding-top:20px;
  	        box-sizing: border-box;
  	        font-size: 12px;
  	    }
  	    .el-form-item__label{
  	    	font-size: 12px !important;
  	    	}
  	    .el-input__inner{
  	    	height: 32px !important;
  	    	font-size: 12px !important;
  	    }
	  	.el-form-item__content {
		    line-height: 32px;
		    position: relative;
		    font-size: 12px;
			}
	    .el-textarea__inner{
		   	height: 80px;
		   	font-size: 12px;
	   }
	    .el-form-item{
	     	margin-bottom: 18px;
	   }
  	    .accountTel{
  	    	width: 100%;
  	    	background: #F5F5F5;
  	    	border-radius: 5px;
  	    	margin-bottom: 20px;
  	    	padding:15px 18px;
  	    	font-size: 12px;
  	    	box-sizing: border-box;

  	    	span:nth-child(1),span:nth-child(3){
  	    		margin-right:12px;
  	    	}
  	    	span:nth-child(2){
  	    		margin-right:40px;
  	    	}
  	    	p{
  	    		padding-top:5px;
  	    		box-sizing: border-box;
  	    		color: #999;
  	    	}
  	    }
  	}
  	 .dialog-footer{
  	 	display: flex;
  	 	justify-content: center;
  	 	.el-button{
  	 		font-size: 12px;
  	 	}
  	 	.el-button:first-child{
  	 		margin-right: 10px !important;
  	 	}
  	 }

  }

}
	</style>
	<style lang="scss" src="@/styl/tip.scss"></style>
