<template>
<div id="checkdialog">
    <div id="tel_check" v-show="visiable">
        <div class="content">
            <header>
                <span class="font">{{$t('members.btn.addMember')}}</span>
                <span class="close font el-icon-close" @click="close"></span>
            </header>
            <div class="main">
                <div class="up font">{{$t('members.props.tipWarn')}}</div>
                <el-form :inline="true" style="width:415px;" :model="telForm" :rules="telRules" ref="telForm">
                    <el-form-item :label="$t('members.form.phone')" label-width="60px" labelPosition="left" prop="user_account">
                        <el-input style="width:196px;" v-model="telForm.user_account" :placeholder="$t('members.placeholder.phoneInout')"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="confirmForm('telForm')" size="medium">{{$t('members.btn.confirm')}}</el-button>
                    </el-form-item>
                </el-form>

            </div>
        </div>
    </div>

</div>
</template>

<script>
import Vue from "vue"
import ImageUploader from "@/components/upload/ImageUploader"
import * as api from '@/js/api'
import bus from "@/js/eventBus"
export default {
    name: "dialog",
    props: ["telformVisible", "addformVisible"],
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
        return {
            visiable: true,
            telForm: {
                user_id: "",
                user_name: "",
                user_account: "",
                nick_name: ""
            },
            telRules: {
                user_account: [{
                    validator: checkTel,
                    trigger: 'blur'
                }]
            }

        }
    },
    methods: {
        confirmForm(telForm) {
            this.$refs[telForm].validate((valid) => {
                if (valid) {
                    api.member.memberAddpage({
                        phone: this.telForm.user_account
                    }).then(res => {
                        //console.log(res.data)
                        var result = res.data
                        this.$message(result.msg);
                        if (result.status == 200) {
                            this.telForm = result.data.account_info
                            bus.$emit("send", this.telForm)
                            setTimeout(() => {
                                this.$emit('changeaddV', true)
                                this.$emit('changeV', false)
                            }, 1000)
                            this.resetForm('telForm')
                        } else {
                            this.$emit('changeaddV', false)
                            this.$emit('changeV', true)
                        }
                    });
                }
            });
        },
        resetForm(telForm) {
            this.$refs[telForm].resetFields();
        },
        close() {
            this.$emit('changeV', false)
            this.resetForm('telForm')
        },

    }
}
</script>

<style lang="scss" >
#tel_check {
    width: 100%;
    height: 100%;
    background: rgba(51,51,51,0.7);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9999;
    font-size: 12px;
    .content {
        width: 415px;
        height: 182px;
        background: #fff;
        border-radius: 4px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -207.5px;
        margin-top: -91px;
        z-index: 9999999;
        font-size: 14px;
        header {
            height: 44px;
            width: 100%;
            padding: 0 20px;
            background: #268fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            border-radius: 4px 4px 0 0;
            .font {
                font-size: 14px !important;
            }
            .close {
                font-size: 12px;
                cursor: pointer;
            }
        }

        .main {
            width: 415px;
            height: 182px;
            padding: 30px 0 0 40px;
            box-sizing: border-box;
            font-size: 12px;
            .up {
                padding-bottom: 20px;
                text-align: left;
                box-sizing: border-box;
            }
            .el-input input {
                width: 196px;
                height: 32px !important;
                font-size: 12px;
                line-height: 0;
            }
            button {
                font-size: 12px;
                height: 32px;
                width: 64px;
                line-height: 0;
            }
            .el-form-item__label {
                font-size: 12px !important;
                text-align: left;
            }

        }
    }
}
</style>
