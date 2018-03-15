<template>
    <div>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="160px" class="demo-ruleForm">
            <section class="form-grp">
                <div class="s-hd">
                    {{$t('institute.business.title')}} <span class="expound">&nbsp;&nbsp;&nbsp;&nbsp;{{$t('institute.business.tips')}}</span>
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('institute.business.name')" prop="ins_show_name">
                        <el-input v-model="ruleForm.ins_show_name" :placeholder="$t('institute.placeholder.business_name')"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('institute.business.introduce')" prop="short_des">
                        <el-input v-model="ruleForm.short_des" :placeholder="$t('institute.placeholder.business_introduce')" :maxlength="100"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('institute.business.logo')" prop="logo">
                        <image-uploader v-model="ruleForm.logo" @error="onImageSelectError" @change="dispatchChangeForElItem">
                            <div slot="desc" class="size12">
                                {{$t('institute.business.logo_tips')}} <br>
                                <span v-html="$t('common.img_tips')"></span>
                            </div>
                        </image-uploader>
                    </el-form-item>
                    <el-form-item :label="$t('institute.business.category')" prop="ins_type">
                        <el-select v-model="ruleForm.ins_type" :placeholder="$t('institute.placeholder.business_category')">
                            <el-option :label="item" :value="key" v-for="(item, key) in insTypes" :key="key"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="$t('institute.business.intro')" prop="ins_description">
                        <el-input type="textarea" v-model="ruleForm.ins_description" :placeholder="$t('institute.placeholder.business_intro')" :maxlength="200"></el-input>
                    </el-form-item>
                </div>
            </section>

            <!-- section two -->

            <section class="form-grp">
                <div class="s-hd">
                    {{$t('institute.institution.title')}}    <span class="expound">&nbsp;&nbsp;&nbsp;&nbsp;{{$t('institute.institution.tips')}}</span>
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('institute.institution.name')" prop="ins_name">
                        <el-input v-model="ruleForm.ins_name" :maxlength="50" :placeholder="$t('institute.placeholder.institute_name')"></el-input>
                        <br><span v-show="!env" class="expound">{{$t('institute.institution.name_tips')}}</span>
                    </el-form-item>
                    <div v-if="env" >
                        <el-form-item :label="$t('institute.institution.country')" prop="country">
                            <el-select :placeholder="$t('institute.placeholder.institute_category')" v-model="ruleForm.country">
                                <el-option v-for="item in countryList" :label="item.name" :value="item.id" :key="item.id" >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </div>
                    <div v-else>
                        <el-form-item  :label="$t('institute.institution.nature')" prop="has_license">
                            <el-radio-group v-model="ruleForm.has_license">
                                <el-radio label="1">{{$t('institute.institution.nature_options[0]')}}</el-radio>
                                <el-radio label="2">{{$t('institute.institution.nature_options[1]')}}</el-radio>
                            </el-radio-group>
                        </el-form-item>

                        <div v-if="ruleForm.has_license=='1'">

                            <el-form-item :label="$t('institute.institution.license')" prop="license_pic">
                                <image-uploader v-model="ruleForm.license_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                    <div slot="desc" class="size12">
        {{$t('institute.institution.license_tips')}}<br>
        <span v-html="$t('common.img_tips')"></span>
                                    </div>
                                </image-uploader>
                            </el-form-item>

                            <el-form-item :label="$t('institute.institution.code')" prop="license_code">
                                <el-input v-model="ruleForm.license_code"></el-input>
                            </el-form-item>
                        </div>

                        <el-form-item :label="$t('institute.institution.certificate')" prop="certificate_pic">
                            <image-uploader v-model="ruleForm.certificate_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                <div slot="desc" class="size12">
    {{$t('institute.institution.certificate_tips')}}<br>
    <span v-html="$t('common.img_tips')"></span>
                                </div>
                            </image-uploader>
                        </el-form-item>

                        <el-form-item :label="$t('institute.institution.certificate_id')" prop="certificate_code">
                            <el-input v-model="ruleForm.certificate_code"></el-input>
                        </el-form-item>
                    </div>
                </div>
            </section>

            <!-- section three -->
            <section class="form-grp">
                <div class="s-hd">
                    {{$t('institute.proposer.title')}}
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('institute.proposer.name')" prop="legal_person">
                        <el-input v-model="ruleForm.legal_person"></el-input>
                    </el-form-item>
                    <div v-if="env">
                        <el-form-item  :label="$t('institute.proposer.email')"  prop="email" class="mobile-wrapper" ref="email">
                            <div v-show="needValidEmail">
                                <el-input style="width:210px" v-model="ruleForm.email" :placeholder="$t('institute.placeholder.proposer_email')"></el-input>
                                <el-button @click="sendCaptchaEmail" :disabled="sendingCaptchaEmail || captchaCountDown > 0">
                                    {{ this.captchaCountDown == 0 ?  $t('institute.proposer.send_code') :  $t('institute.proposer.send_time', { time: this.captchaCountDown })}}
                                </el-button>
                            </div>
                            <div v-show="!needValidEmail">
                                <span style="color: #999999">{{ruleForm.email}}</span>
                                <el-button @click="changeEmail" style="margin-left: 20px;">{{$t('institute.proposer.email_modify')}}</el-button>
                            </div>

                            <div v-show="email_send" style="height:20px;padding-top:5px"><span class="expound">{{$t('institute.proposer.email_tips')}}</span></div>
                        </el-form-item>
                        <el-form-item prop="email_code" class="mobile-wrapper" v-if="needValidEmail" ref="emailCode">
                            <div v-show="needValidEmail">
                                <el-input style="width:210px" v-model="ruleForm.email_code" :placeholder="$t('institute.placeholder.proposer_code')" ></el-input>
                            </div>
                        </el-form-item>
                    </div>
                    <div v-else>
                        <el-form-item :label="$t('institute.proposer.idcard_front')" prop="id_pic_front">
                            <image-uploader v-model="ruleForm.id_pic_front" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                <div slot="desc" class="size12">
                                    {{$t('institute.proposer.front_tips')}}<br>
    <span v-html="$t('common.img_tips')"></span>
                                </div>
                            </image-uploader>
                        </el-form-item>

                        <el-form-item :label="$t('institute.proposer.idcard_contrary')" prop="id_pic_behand">
                            <image-uploader v-model="ruleForm.id_pic_behand" @error="onImageSelectError">
                                <div slot="desc" class="size12">
    {{$t('institute.proposer.contrary_tips')}}<br>
    <span v-html="$t('common.img_tips')"></span>
                                </div>
                            </image-uploader>
                        </el-form-item>

                        <el-form-item :label="$t('institute.proposer.mobile')" prop="phone" class="mobile-wrapper" ref="phone">
                            <div v-show="needValidPhone">
                                <el-input v-model="ruleForm.phone" :placeholder="$t('institute.placeholder.proposer_mobile')"></el-input>
                                <el-button @click="sendCaptcha" :disabled="sendingCaptcha || captchaCountDown > 0">
                                    {{ this.captchaCountDown == 0 ?  $t('institute.proposer.send_code') :  $t('institute.proposer.send_time', { time: this.captchaCountDown })}}
                                </el-button>
                            </div>
                            <div v-show="!needValidPhone">
                                <span style="color: #999999">{{ruleForm.phone}}</span>
                                <el-button @click="changePho" style="margin-left: 20px;">{{$t('institute.proposer.mobile_modify')}}</el-button>
                            </div>
                        </el-form-item>
                        <el-form-item prop="phone_code" class="mobile-wrapper" v-if="needValidPhone" ref="phoneCode">
                            <div v-show="needValidPhone">
                                <el-input v-model="ruleForm.phone_code" :placeholder="$t('institute.placeholder.proposer_code')" ></el-input>
                            </div>
                        </el-form-item>

                        <el-form-item :label="$t('institute.proposer.email')" prop="email">
                            <el-input style="width:210px" v-model="ruleForm.email" :placeholder="$t('institute.placeholder.proposer_email')"></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('institute.proposer.promise')" prop="promise_pic">
                            <image-uploader v-model="ruleForm.promise_pic" @error="onImageSelectError">
                                <div slot="desc" class="size12">
    <span v-html="$t('institute.proposer.promise_tips')"></span><br>
    <span v-html="$t('common.img_tips')"></span>
                                </div>
                            </image-uploader>
                        </el-form-item>
                    </div>
                </div>
            </section>

            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')" :loading="isFinished">{{$t('institute.btn.submit')}}</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>


<script>
import ImageUploader from "@/components/upload/ImageUploader"
import api from '@/js/api/institute';
import commonApi from '@/js/api/common';
import utils from '@/js/utils';
import validatorMixin from '@/js/mixin/validatorMixin';

import Validators from '@/js/validator/index';
export default {
    mixins: [validatorMixin],
    props: {
        initData: { },
        env: {
            type: Boolean
        }
    },
    components: {
        ImageUploader
    },
    watch:{
        "ruleForm.has_license": function(newVal) {
            console.log(newVal)
            if(newVal == 1){
                this.rules['certificate_pic'] = null;
                this.rules['certificate_code'] = null;
            }else if(newVal == 2){
                Object.assign(this.rules, this.rules_certificate);
            }

        }
    },
    computed: {
        needValidPhone () {
            return !this.validPhoneNumber || this.validPhoneNumber != this.ruleForm.phone;
        },
        needValidEmail () {
            return !this.validEmailNumber || this.validEmailNumber != this.ruleForm.email;
        }
    },
    data() {
        var form = {
            ins_show_name: '', // 经营名称，主要首页显示用
            short_des: '', // 一句话介绍
            logo: '', // 机构logo_url
            ins_type: '', //主营类目，枚举（）
            ins_description: '', //机构简介，关联表数据

            ins_name: '', // 机构名称，审核用
            country:'',//国家
            // organization_code_pic: '', //组织机构代码证书，图片url
            // organization_code: '', //组织机构代码
            has_license: '1', // 是否有营业执照
            license_pic: '', //营业执照，图片url
            license_code: '', //统一社会信用代码
            certificate_pic: '', //资质认证，图片url
            certificate_code: '', //资质认证编号

            legal_person: '', //机构法人、申请人名称
            id_pic_front: '', // 机构法人身份证正面，图片url
            id_pic_behand: '', // 机构法人身份证背面，图片地址
            phone: '', //手机号
            phone_code: '',
            email: '', // 邮箱
            email_code:'',
            promise_pic: '' , // 承诺书照片
        };
        if (this.initData) {
            for (var key in this.initData) {
                if (key in form) {
                    form[key] = ''+this.initData[key];
                }
            }
        }

        return {
            locale:window.LOCALE,
            email_send:false,
            ruleForm: form,
            rules_certificate: {
                certificate_pic: [
                    {
                        required: true, message: this.$t('institute.institution.rules[5]') , trigger: 'change'
                    }
                ],
                certificate_code: [
                    { required: true, message: this.$t('institute.institution.rules[6]'), trigger: 'blur' },
                ],
            },
            rules: {
                certificate_pic: [
                    {
                        required: false, message: this.$t('institute.institution.rules[5]'), trigger: 'change'
                    }
                ],
                certificate_code: [
                    { required: false, message: this.$t('institute.institution.rules[6]'), trigger: 'blur' },
                ],
                ins_show_name: [
                    { required: true, message: this.$t('institute.business.rules[0]'), trigger: 'blur' },
                    { max:20, message: this.$t('institute.business.rules[1]'), trigger: 'blur' },
                    {
                        validator: (rule, value, callback) => {
                            this.checkRepeat('ins_show_name', value).then(res => callback(res.data.status == 200 ? undefined : res.data.msg))
                        },
                        trigger: 'blur'
                    }
                ],
                short_des: [
                    { required: true, message: this.$t('institute.business.rules[2]'), trigger: 'blur' },
                ],
                logo: [
                    {
                        required: true, message: this.$t('institute.business.rules[3]'), trigger: 'change'
                    }
                ],
                ins_type: [
                    { required: true, message: this.$t('institute.business.rules[4]'), trigger: 'change' }
                ],
                ins_description: [
                    { required: true, message: this.$t('institute.business.rules[5]'), trigger: 'blur' },
                ],

                // section two
                ins_name: [
                    { required: true, message: this.$t('institute.institution.rules[0]'), trigger: 'blur' },
                    { max:50, message: this.$t('institute.institution.rules[1]'), trigger: 'blur' },
                    {
                        validator: (rule, value, callback) => {
                            this.checkRepeat('ins_name', value).then(res => callback(res.data.status == 200 ? undefined : res.data.msg))
                        },
                        trigger: 'blur'
                    }
                ],


                has_license: [
                    { required: true, message: this.$t('institute.institution.rules[2]'), trigger: 'change' }
                ],

                license_pic: [
                    {
                        required: true, message: this.$t('institute.institution.rules[3]'), trigger: 'change'
                    }
                ],
                license_code: [
                    { required: true, message: this.$t('institute.institution.rules[4]'), trigger: 'blur' },
                ],
                country:[{ required: true, message: this.$t('institute.institution.rules[7]'), trigger: 'change' }],

                // section three
                legal_person: [
                    { required: true, message:  this.$t('institute.proposer.rules[0]'), trigger: 'blur' },
                ],
                id_pic_front: [
                    {
                        required: true, message: this.$t('institute.proposer.rules[1]'), trigger: 'change'
                    }
                ],
                id_pic_behand: [
                    {
                        required: true, message: this.$t('institute.proposer.rules[2]'), trigger: 'change'
                    }
                ],

                phone: [
                    { required: true, message: this.$t('institute.proposer.rules[3]'), trigger: 'blur' },
                    { validator: Validators.phone, trigger: 'blur' }
                ],
                phone_code: [
                    { required: true, validator: (rule, value, callback) => {
                            if (this.ruleForm.phone_code.length >= 6) {
                                this.validatePhoneCode();
                            } else if (this.ruleForm.phone_code.length <= 0) {
                                callback(this.$t('institute.proposer.rules[4]'));
                            }
                        }, trigger: 'change'},

                ],
                email: [
                    { required: true, message: this.$t('institute.proposer.rules[5]'), trigger: 'blur' },
                    { validator: Validators.email, trigger: 'blur'}
                ],
                email_code: [
                    { required: true, validator: (rule, value, callback) => {
                            if (this.ruleForm.email_code.length >= 6) {
                                this.validateEmailCode();
                            } else if (this.ruleForm.email_code.length <= 0) {
                                callback(this.$t('institute.proposer.rules[4]'));
                            }
                        }, trigger: 'change'},

                ],
                promise_pic: [
                    {
                        required: true, message: this.$t('institute.proposer.rules[6]'), trigger: 'change'
                    }
                ]
            },
            insTypes: {},
            validPhoneNumber: '', //已通过验证的手机号
            validEmailNumber: '',//已通过验证的邮箱
            captchaCountDown: 0,
            sendingCaptcha: false,
            sendingCaptchaEmail: false,
            isFinished:false,
            countryList:[]
        };
    },
    created () {
        this.getInsType();
        this.getCountryList();
        this.validPhoneNumber = this.ruleForm.phone;
        this.validEmailNumber = this.ruleForm.email;
    },
    destroy () {
        if (this.destroyCountDown) {
            this.destroyCountDown();
        }
    },
    methods: {
        changePho(){
            this.ruleForm.phone = '';
            this.validPhoneNumber = '' ;
            this.ruleForm.phone = '';
            this.ruleForm.phone_code = '';
            if (this.destroyCountDown) {
                this.destroyCountDown();
                this.captchaCountDown = 0 ;
            }
        },
        changeEmail(){
            this.ruleForm.email = '';
            this.validEmailNumber = '' ;
            this.ruleForm.email = '';
            this.ruleForm.email_code = '';
            if (this.destroyCountDown) {
                this.destroyCountDown();
                this.captchaCountDown = 0 ;
            }
        },
        submitForm(formName) {
            if(!this.isFinished){
                this.$refs[formName].validate((valid) => {
                    if (!valid) return ;
                    if(!this.env){
                        if('country' in this.ruleForm){
                            delete this.ruleForm.country;
                        }
                        if (this.needValidPhone) {
                            return this.showFormItemError(this.$refs.phone, this.$t('institute.rules.mobile_error'));
                        }
                    }else{
                        if (this.needValidEmail) {
                            return this.showFormItemError(this.$refs.email, this.$t('institute.rules.email_error'));
                        }
                    }
                    //console.log(JSON.stringify(this.ruleForm));
                    this.isFinished = true;
                    api.registerInstitute(this.ruleForm).then(data => {
                        this.$emit('success');
                        this.isFinished = false;
                    },()=>{ this.isFinished = false;})
                });
            }

        },

        getInsType () {
            api.getInsType().then(data => this.insTypes = data);
        },

        sendCaptcha () {
            this.$refs.phone.validate('blur');
            var phoneStatus=/^1[3|4|5|7|8]\d{9}$/.test(this.ruleForm.phone);
            if (!phoneStatus){
                return false;
            }
            commonApi.sendCaptcha(this.ruleForm.phone, 6).then(() => {
                this.sendingCaptcha = false;
                this.destroyCountDown = utils.countdown(60, {
                    onProgress: (s) => this.captchaCountDown = s
                });
            });
            this.sendingCaptcha = true;
        },
        sendCaptchaEmail () {
            this.$refs.email.validate('blur');
            var emailStatus=/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/.test(this.ruleForm.email);
            if (!emailStatus){
                return false;
            }
            api.sendCaptchaEmail(this.ruleForm.email, 6).then(() => {
                this.sendingCaptchaEmail = false;
                this.email_send=true;
                this.destroyCountDown = utils.countdown(60, {
                    onProgress: (s) => this.captchaCountDown = s
                });
            });
            this.sendingCaptchaEmail = true;
        },

        validatePhoneCode () {
            var phone = this.ruleForm.phone;
            commonApi.checkCaptcha({
                type: 6,
                captcha: this.ruleForm.phone_code,
                phone: phone
            }).then(res => {
                if (res.status == 200) {
                    this.validPhoneNumber = phone;
                } else {

                    this.showFormItemError(this.$refs.phoneCode, this.$t('institute.rules.code_error'));
                }
            })
        },
        validateEmailCode(){
            var email = this.ruleForm.email;
            commonApi.checkCaptcha({
                type: 6,
                captcha: this.ruleForm.email_code,
                email: email
            }).then(res => {
                if (res.status == 200) {
                    this.email_send=false;
                    this.validEmailNumber = email;
                } else {
                    this.showFormItemError(this.$refs.emailCode, this.$t('institute.rules.code_error'));
                }
            })
        },

        checkRepeat (key, value) {
            switch(key) {
                case 'ins_show_name':
                    return api.checkShowName(value);
                case 'ins_name':
                    return api.checkInstituteName(value);
                // case 'organization_code':
                //     return api.checkInstituteCode(value);
            }
        },

        resetForm(formName) {
            this.$refs[formName].resetFields();
        },

        showFormItemError(formItem, message) {
            console.log(formItem,message)
            formItem.validateState = 'error';
            formItem.validateMessage = message;
        },
        getCountryList(){
            api.getCountry().then(res => {
                this.countryList=res.data;
                this.countryList.map(function(item) {
                    return item.id = item.id.toString();
                });
            });
        }
    }
}
</script>


<style lang="stylus">
 .expound{
    font-size:12px;
    color: #999;
    font-weight: 400;
 }
.size12{
    font-size: 12px;
}
.form-grp
    .s-hd
        font-size 16px
        color #333
        font-weight bold
        border-bottom 1px solid #f5f5f5
        padding-bottom 20px
        margin-bottom 20px

    .mobile-wrapper
        .el-input
            width 160px


    .el-input,.el-textarea
        width 400px

    .form-line
        margin-bottom 22px
</style>
