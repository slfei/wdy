<template>
<div id="organProfile">
    <el-form label-width="130px" :model="ruleForm" :rules="rules" ref="ruleForm">
        <!--	经营信息 start-->
        <section class="manage  form1">
            <div class="title">
                <h3>{{$t('profile.business.title')}}</h3>
                <span id="alter" @click="judge.dialogs=true;" v-show="judge.iput_change">
		           		{{$t('profile.btn.edit')}}
		           	</span>
            </div>
            <div class="detail">
                <el-form-item :label="$t('profile.business.field.businessName')" prop="ins_show_name">
                    <el-input v-model="ruleForm.ins_show_name" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.shortDes')" prop="short_des">
                    <el-input type="text" v-model="ruleForm.short_des" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.logo')" prop="logo">
                    <div id="imgbox" v-if="judge.iput_change">
                        <img :src="ruleForm.logo" />
                    </div>
                    <image-uploader v-model="ruleForm.logo" width="160px" v-else @error="onImageSelectError" @change="dispatchChangeForElItem">
                    </image-uploader>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.mainBusiness')" prop="ins_type">
                    <el-input :value="insTypes[ruleForm.ins_type]" :readonly="judge.iput_change" v-if="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                    <el-select class='w-select' v-model="ruleForm.ins_type" placeholder="请选择" v-else>
                        <el-option :label="item" :value="key" v-for="(item, key) in insTypes" :key="key"></el-option>
                    </el-select>

                </el-form-item>

                <el-form-item :label="$t('profile.business.field.Introduction')" prop="ins_description">
                    <el-input v-if="judge.iput_change" v-model="ruleForm.ins_description" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                    <el-input v-else type="textarea" style="width: 400px;" v-model="ruleForm.ins_description" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.contact')" prop="legal_person">
                    <el-input v-model="ruleForm.legal_person" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.phone')" prop="phone">
                    <el-input class="tel" :disabled="modifyTel" v-model="ruleForm.phone" :class='{border1:!isModify}'>
                    </el-input>
                    <el-button class="w-button" v-show="modifyTel" @click="swicth">{{$t('profile.btn.editphone')}}</el-button>

                    <el-button :plain="true" type="info" v-show="isModify" @click.native="sendCaptcha(ruleForm.phone,5)" :disabled='isDisable|| time > 0' :class="[isDisable|| time > 0?'is-disabled':'w-button','captcha']">
                        <span v-cloak>{{msg}}</span>
                    </el-button>
                </el-form-item>

                <el-form-item label="" v-show="isModify" prop="captcha">
                    <el-input class="tel" type="text" v-model="ruleForm.captcha" :placeholder="$t('profile.placeholder.vcodeInput')" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>
                    <el-button type="primary" style="width: 102px;height:34px;line-height: 0;" @click="checkCaptcha(ruleForm.phone,5,ruleForm.captcha,1)">{{$t('profile.btn.confirm')}}
                    </el-button>
                </el-form-item>

                <el-form-item :label="$t('profile.business.field.email')" prop="email">
                    <el-input style="width:400px;" v-model="ruleForm.email" :readonly="judge.iput_change" :class='{border1:judge.iput_change}'>
                    </el-input>

                </el-form-item>
                <el-form-item label="" v-show="!judge.iput_change">
                    <el-button type="primary" @click="submit">{{$t('profile.btn.save')}}</el-button>
                    <el-button @click="cancel">{{$t('profile.btn.cancel')}}</el-button>
                </el-form-item>

            </div>
        </section>
        <!--	经营信息END-->

        <!--	机构信息 start-->
        <section class="manage">
            <div class="title">
                <h3>{{$t('profile.mechanism.title')}}</h3>
            </div>
            <div class="detail">
                <el-form-item :label="$t('profile.mechanism.field.mechanismName')">
                    <el-input v-model="ruleForm.ins_name" readonly class="border1"></el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.mechanism.field.codeCertificate')">
                    <img :src="ruleForm.organization_code_pic" class="vertical" @click="lookPic(ruleForm.organization_code_pic)" />
                </el-form-item>
                <el-form-item :label="$t('profile.mechanism.field.code')">
                    <el-input v-model="ruleForm.organization_code" readonly class="border1"></el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.mechanism.field.businessLicense')" v-if="ruleForm.has_license==1">
                    <img :src="ruleForm.license_pic" class="vertical" @click="lookPic(ruleForm.license_pic)" />
                </el-form-item>

                <el-form-item :label="$t('profile.mechanism.field.registrationNumber')" v-if="ruleForm.has_license==1">
                    <el-input v-model="ruleForm.license_code" readonly class="border1"></el-input>
                </el-form-item>

                <el-form-item :label="$t('profile.mechanism.field.certificate')">
                    <img :src="ruleForm.certificate_pic" class="vertical" @click="lookPic(ruleForm.certificate_pic)" />
                </el-form-item>

                <el-form-item :label="$t('profile.mechanism.field.certificateId')">
                    <el-input v-model="ruleForm.certificate_code" readonly class="border1"></el-input>
                </el-form-item>
            </div>
        </section>
        <!--	机构信息 end-->
    </el-form>
    <!--手机验证弹框 start-->
    <div id="boxWraper" v-show="judge.dialogs">
        <div id="box">
            <div class="hd">
                <h3>{{$t('profile.props.verificationPhone')}}</h3>
                <span class="el-icon-close close" @click="close">
			        	</span>
            </div>
            <div id="content">
                <p>{{$t('profile.tips.safeMsg')}}</p>
                <el-form :model="judge" :rules="judgeRules" ref="judge">

                    <el-form-item :label="$t('profile.business.field.phone')">
                        <el-input id="tel" class="tel" type="text" v-model="judge.tel_dialogs" readonly></el-input>
                        <el-button :plain="true" type="info" style="width:170px;margin-left:20px;" :disabled='isDisable|| time > 0' @click.native="sendCaptcha(judge.tel_dialogs,4)" :class="[isDisable|| time > 0?'is-disabled':'w-button','captcha']" v-text="msg">
                        </el-button>
                    </el-form-item>

                    <el-form-item label="" class="yzm" prop="telcaptcha">
                        <el-input class="tel" v-model="judge.telcaptcha" :placeholder="$t('profile.placeholder.vcodeInput')" style="width: 150px;"></el-input>
                        <el-button type="primary" style="width: 170px; margin-left:30px;" @click.native="checkCaptcha(ruleForm.phone,4,judge.telcaptcha,0)">{{$t('profile.btn.confirm')}}
                        </el-button>
                    </el-form-item>

                </el-form>

            </div>

        </div>
    </div>
    <!--手机验证 end-->
</div>
</template>

<script>
import Vue from 'vue'
import ImageUploader from "@/components/upload/ImageUploader"
import * as api from '@/js/api'
import validatorMixin from '@/js/mixin/validatorMixin'
export default {
    name: "organProfile",
    mixins: [validatorMixin],
    data() {
        var checkModify = (rule, value, callback) => {
            var reg = /^\d{6}$/
            if (!this.isValidation) {
                if (!value) {
                    callback(new Error(this.$t('profile.rules.codeNull')))
                } else if (!reg.test(value)) {
                    callback(new Error(this.$t('profile.rules.codeError')))
                } else {
                    callback()
                }
            } else {
                callback()
            }
        };
        return {
            time: 0,
            second: 60,
            timer: '',
            isDisable: false,
            isValidation: false,
            modifyTel: false,
            isModify: false,
            judge: {
                iput_change: true, //input框在点击修改后border出现
                dialogs: false, //手机验证弹框
                isimgloder: false, //判断图片是否重新上传
                telcaptcha: "", //保存验证码,
                tel_dialogs: ''
            },
            judgeRules: {
                tel_dialogs: [{
                    required: false,
                    message: this.$t('profile.rules.phoneNull'),
                    trigger: 'blur'
                }],
                telcaptcha: [{
                    required: true,
                    pattern: /^\d{6}$/,
                    message: this.$t('profile.rules.codeError'),
                    trigger: 'blur'
                }]

            },
            ruleForm: {
                ins_show_name: '', // 经营名称，主要首页显示用
                short_des: "", // 一句话介绍
                logo: '', // 机构logo_url
                ins_type: '1', //主营类目，枚举（）
                ins_description: '', //机构简介，关联表数据
                legal_person: "",
                phone: '', //手机号
                email: '', // 邮箱
                operator: '', //修改人
                operator_id: '',
                captcha: "",


                ins_name: '猎户网', // 机构名称，审核用
                organization_code_pic: '', //组织机构代码证书，图片url
                organization_code: '', //组织机构代码
                has_license: '1', // 是否有营业执照
                license_pic: '', //营业执照，图片url
                license_code: '', //营业执照编号
                certificate_pic: '', //资质认证，图片url
                certificate_code: '', //资质认证编号

            },
            rules: {
                ins_show_name: [{
                        required: false,
                        message: this.$t('profile.rules.nameNull'),
                        trigger: 'blur'
                    },
                    {
                        max: 20,
                        message: this.$t('profile.rules.sizeError'),
                        trigger: 'change,blur'
                    }
                ],
                short_des: [{
                        required: false,
                        message: this.$t('profile.rules.introductionNull'),
                        trigger: 'blur'
                    },
                    {
                        max: 50,
                        message: this.$t('profile.rules.introductionSize'),
                        trigger: 'change,blur'
                    }
                ],
                logo: [{
                    required: false,
                    message: this.$t('profile.rules.imgNull'),
                    trigger: 'change'
                }],
                ins_type: [{
                    required: false,
                    message: this.$t('profile.rules.mainNull'),
                    trigger: 'change'
                }],
                legal_person: [{
                    required: false,
                    message: this.$t('profile.rules.contactNull'),
                    trigger: 'blur'
                }],
                ins_description: [{
                        required: false,
                        message: this.$t('profile.rules.desNull'),
                        trigger: 'blur'
                    },
                    {
                        max: 200,
                        message: this.$t('profile.rules.desSize'),
                        trigger: 'change,blur'
                    }

                ],
                phone: [{
                    required: false,
                    pattern: /^1[34578]\d{9}$/,
                    message: this.$t('profile.rules.phoneError'),
                    trigger: 'blur'
                }],
                captcha: [{
                    pattern: /^\d{6}$/,
                    validator: checkModify,
                    trigger: 'blur'
                }],
                email: [{
                    required: false,
                    message: this.$t('profile.rules.emailError'),
                    trigger: 'blur',
                    type: "email"
                }]

            },
            insTypes: {},
        }

    },
    created() {
        this.initData()
        this.getInsType()
    },
    methods: {
        initData() {
            api.institute.getInstituteInfo().then((res) => {
                if (res.data.status == 200) {
                    var dataValue = res.data.data
                    for (var key in dataValue) {
                        if (key == 'ins_type') {
                            dataValue[key] = dataValue[key].toString()
                        }
                        if (key in this.ruleForm) {
                            this.ruleForm[key] = dataValue[key]
                        }
                    }
                    this.judge.tel_dialogs = this.ruleForm.phone
                } else {
                    console.log("err")
                }
            })
        },
        getInsType() {
            api.institute.getInsType().then(data => {
                //console.log(data)
                this.insTypes = data

            });
        },
        requireFn() {
            for (var i in this.rules) {
                this.rules[i][0]["required"] = true;
            }
        },
        requireNo() {
            for (var i in this.rules) {

                this.rules[i][0]["required"] = false;
            }
        },
        sendCaptcha(tel, type) {
            this.runtime()
            api.common.sendCaptcha(tel, type).then(res => {
                this.judge.telcaptcha = ""
            })
        },
        formCheck(options, isValid) {
            api.common.checkCaptcha(options).then((data) => {
                if (data.status == 200) {
                    this.$message({
                        type: 'success',
                        message: this.$t('profile.tips.verificationSuccess')
                    });
                    this.clearTimer()
                    this.isValidation = true
                    if (isValid) {
                        this.modifyTel = true;
                        this.isModify = false;
                    } else {
                        this.judge.dialogs = !this.judge.dialogs
                        this.judge.iput_change = false
                        this.requireFn()
                        this.resetForm("judge")
                        this.modifyTel = true;
                    }
                } else {
                    this.$message({
                        type: 'warning',
                        message: data.msg
                    });
                }
            })

        },
        checkCaptcha(tel, type, captcha, isValid) { //验证码验证；
            if (!isValid) {
                this.$refs.judge.validate(result => {
                    if (result) {
                        this.formCheck({
                            phone: tel,
                            type: type,
                            captcha: captcha
                        }, isValid)
                    }
                });
            } else {
                this.formCheck({
                    phone: tel,
                    type: type,
                    captcha: captcha
                }, isValid)
            }
        },
        submit() {
            this.judge.isimgloder = false;
            // 表单验证方法
            this.$refs.ruleForm.validate(function(result) {
                if (result) {
                    api.institute.postInstituteInfo(this.ruleForm).then(res => {
                        //console.log(res.data+"修改数据")
                        if (res.data.status == 200 && this.isValidation == true) {
                            this.clearTimer()
                            this.judge.iput_change = true;
                            this.isModify = false;
                            this.modifyTel = false;
                            this.requireNo()
                            this.initData()
                            this.judge.telcaptcha = "";
                            this.ruleForm.captcha = "";
                        } else if (!this.isValidation) {
                            this.$message({
                                type: 'warning',
                                message: this.$t('profile.rules.codeError')
                            });
                        } else {
                            this.$message({
                                type: 'warning',
                                message: res.data.msg
                            });
                        }

                    })
                } else {
                    //console.log("表达验证不合法")
                    this.judge.iput_change = false;
                }
            }.bind(this));

        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        close() {
            this.judge.dialogs = false
            this.resetForm("judge")
            this.clearTimer()
        },
        cancel() {
            this.$confirm(this.$t('profile.tips.cancelWarn'), this.$t('profile.props.ts'), {
                confirmButtonText: this.$t('profile.btn.confirm'),
                cancelButtonText: this.$t('profile.btn.cancel'),
                type: 'warning',
                customClass: "cancel"
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: this.$t('profile.tips.alreadyCancel')
                });
                this.clearTimer()
                this.judge.iput_change = true;
                this.requireNo()
                this.initData()
                this.judge.telcaptcha = ""
                this.ruleForm.captcha = "";
                this.isModify = false;
                this.modifyTel = false;
            }).catch(() => {

            });
        },
        clearTimer() { //清除倒计时
            clearInterval(this.timer)
            this.time = 0
            this.second = 60;
        },
        runtime() { //验证码倒计时
            this.clearTimer()
            this.timer = setInterval(() => {
                this.second--;
                this.time = this.second
                if (this.second <= 0) {
                    this.clearTimer()
                }
            }, 1000)
        },
        lookPic(url) {
            window.open(url)
        },
        swicth() {
            this.modifyTel = false;
            this.isModify = true;
            this.isValidation = false;
        }
    },
    computed: {
        msg: function() {
            return this.time > 0 ? this.time + this.$t('profile.tips.timeDown') : this.$t('profile.btn.sendVerificationCode');
        }
    },
    components: {
        ImageUploader
    }
}
</script>
<style lang="scss">
#organProfile {
    .manage {
        .title {
            h3 {
                display: inline-block;
                font-size: 16px;
            }
            #alter {
                color: #268fff;
                margin-left: 18px;
                cursor: pointer;
                font-size: 12px;
            }
        }
    }

    .el-input {
        width: 400px;
        font-size: 14px;
    }
    .el-textarea__inner {
        font-size: 14px;
    }
    .border1 input {
        border: none;
        color: #999;
        background: none;
    }

    #imgbox {
        height: 134px;
        width: 134px;
        text-align: center;
        img {
            max-height: 134px;
            max-width: 134px;
        }
    }
    #personlogo {
        border-radius: 50%;
        width: 90px;
        height: 90px;
    }
    .tel {
        width: 120px;
        button,
        input {
            height: 34px;
            font-size: 14px;
        }

    }
    .captcha {

        font-size: 12px;
        padding: 10px 15px;
        border-radius: 4px;
        margin: 0;
    }
    .form1 {
        .tel {
            margin-right: 20px;
        }
    }
    #tel {
        input {
            border: none;
            color: #999;
            font-size: 14px;
        }
    }
    .w-button {
        font-size: 12px;
    }
    #box {
        width: 560px;
        height: 230px;
        background: #FFFFFF;
        position: relative;
        top: 50%;
        left: 50%;
        margin-left: -207.5px;
        margin-top: -115px;
        border-radius: 4px;

    }
    #box .hd {
        height: 44px;
        width: 100%;
        background: #268fff;
        padding: 0 20px;
        box-sizing: border-box;
        border-radius: 4px 4px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #FFFFFF;
        h3 {
            font-size: 14px;
        }
        .close {
            cursor: pointer;
            font-size: 12px;
        }
    }
    #box .el-form-item__label {
        width: 110px;
    }

    #content {
        padding: 20px 40px 0;
        box-sizing: border-box;
        text-align: center;
        .el-button {
            font-size: 12px;
        }
        p {
            margin: 0;
            font-size: 12px;
        }
    }
    .yzm {
        margin-left: 67px;
    }
    #content p {
        text-align: left;
        line-height: 20px;
        .el-button {
            font-size: 12px;
        }
    }
    #boxWraper {
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        position: fixed;
        z-index: 888;
        top: 0;
        left: 0;
        .close {
            cursor: pointer;
        }
    }
    .el-form-item {
        margin-bottom: 18px;
    }
    .horizontal {
        width: 240px;
        height: 160px;
    }
    .vertical {
        width: 200px;
        height: 240px;
    }

}
</style>
<style lang="styl" src="@/styl/tip.scss"></style>
