<template>
<div>
    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="130px" class="demo-ruleForm">
        <section class="form-grp">
            <div class="s-hd">
                {{$t('applicationPerson.infoBusiness.title')}}<span class="expound">&nbsp&nbsp&nbsp&nbsp{{$t('applicationPerson.infoBusiness.shortDes')}}</span>
            </div>
            <div class="s-bd">
                <el-form-item :label="$t('applicationPerson.infoBusiness.field.businessName')" prop="per_show_name">
                    <el-input v-model="ruleForm.per_show_name" :placeholder="$t('applicationPerson.placeholder.businessName')" :maxlength="20"></el-input>
                </el-form-item>
                <el-form-item :label="$t('applicationPerson.infoBusiness.field.description')" prop="short_des">
                    <el-input v-model="ruleForm.short_des" :placeholder="$t('applicationPerson.placeholder.shortDes')" :maxlength="100"></el-input>
                </el-form-item>
                <el-form-item :label="$t('applicationPerson.infoBusiness.field.avatar')" prop="personal_logo">
                    <image-uploader v-model="ruleForm.personal_logo" @error="onImageSelectError" @change="dispatchChangeForElItem">
                        <div slot="desc" class="size12">
                            {{$t('applicationPerson.text.limitImg')}} <br> {{$t('applicationPerson.text.limitSize')}} <br> {{$t('applicationPerson.text.limitType')}}
                        </div>
                    </image-uploader>
                </el-form-item>
                <el-form-item :label="$t('applicationPerson.infoBusiness.field.mainBusiness')" prop="person_type">
                    <el-select v-model="ruleForm.person_type" :placeholder="$t('applicationPerson.placeholder.select')">
                        <el-option :label="item" :value="key" v-for="(item, key) in insTypes" :key="key"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('applicationPerson.infoBusiness.field.introduction')" prop="description">
                    <el-input type="textarea" v-model="ruleForm.description" :placeholder="$t('applicationPerson.placeholder.introduction')" :maxlength="200"></el-input>
                </el-form-item>
            </div>
        </section>

        <section class="form-grp">
            <div class="s-hd">
                {{$t('applicationPerson.identityProve.title')}}
            </div>
            <div class="s-bd">
                <el-form-item :label="$t('applicationPerson.identityProve.field.realName')" prop="per_name">
                    <el-input v-model="ruleForm.per_name" :placeholder="$t('applicationPerson.placeholder.idName')"></el-input>
                </el-form-item>
                <div v-if="!env">
                    <el-form-item label="身份证明" prop="id_type">
                        <el-radio-group v-model="ruleForm.id_type">
                            <el-radio label="1">身份证</el-radio>
                            <el-radio label="2">护照</el-radio>
                        </el-radio-group>
                    </el-form-item>

                    <div v-if="ruleForm.id_type==1">
                        <el-form-item label="身份证明正面照" prop="id_pic">
                            <image-uploader v-model="ruleForm.id_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                <div slot="desc" class="size12">
                                    请保证身份证姓名，身份证号码清晰可见
                                    <br> 文件小于2M <br> 支持jpg,gif,png或bmp格式的图片
                                </div>
                            </image-uploader>
                        </el-form-item>
                        <el-form-item label="身份证明背面照" prop="id_pic_behand">
                            <image-uploader v-model="ruleForm.id_pic_behand" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                <div slot="desc" class="size12">
                                    请保证签发机关、有效期限清晰可见
                                    <br> 文件小于2M <br> 支持jpg,gif,png或bmp格式的图片
                                </div>
                            </image-uploader>
                        </el-form-item>
                        <el-form-item label="身份证号码" prop="id_code">
                            <el-input v-model="ruleForm.id_code" placeholder="请填写身份证号码"></el-input>
                        </el-form-item>
                    </div>

                    <div v-else>
                        <el-form-item label="护照" prop="passport_pic">
                            <image-uploader v-model="ruleForm.passport_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                <div slot="desc" class="size12">
                                    请保证护照姓名，护照号码清晰可见
                                    <br> 文件小于2M <br>支持jpg,gif,png或bmp格式的图片
                                </div>
                            </image-uploader>
                        </el-form-item>
                        <el-form-item>
                            <el-input v-model="ruleForm.passport_code" placeholder="请填写护照号码"></el-input>
                        </el-form-item>
                    </div>
                    <el-form-item label="资格证书" prop="certificate_type">
                        <el-select v-model="ruleForm.certificate_type" placeholder="请选择资格证书" required>
                            <el-option value="certificate" label="教师资格证"></el-option>
                            <el-option value="diploma" label="高学历证"></el-option>
                            <el-option value="professional_certificate" label="专业证书"></el-option>
                            <el-option value="weibo" label="本人微博认证号"></el-option>
                            <el-option value="other" label="其他"></el-option>
                        </el-select>
                        <div v-show="ruleForm.certificate_type">
                            <el-form-item prop="weibo_id" v-if="ruleForm.certificate_type == 'weibo'">
                                <el-input v-model="ruleForm.weibo_id" placeholder="请填写您的新浪微博认证账号"></el-input>
                            </el-form-item>
                            <el-form-item prop="cer_pic">
                                <image-uploader v-model="ruleForm.cer_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                                    <span slot="desc" class="size12">
                                    {{ ruleForm.certificate_type && cerTypeMap[ruleForm.certificate_type]['pic'] }}<br>
                                    <br> 文件小于2M <br> 支持jpg,gif,png或bmp格式的图片
                                </span>
                                </image-uploader>
                            </el-form-item>

                            <el-form-item prop="cer_name">
                                <el-input v-model="ruleForm.cer_name" placeholder="请输入证书名称"></el-input>
                                <div class="form-item-tip">{{ ruleForm.certificate_type && cerTypeMap[ruleForm.certificate_type]['tip'] }}</div>
                            </el-form-item>
                        </div>
                    </el-form-item>


                    <el-form-item label="手机" prop="phone" class="mobile-wrapper" ref="phone">
                        <div v-show="needValidPhone">
                            <el-input v-model="ruleForm.phone" placeholder="请填写手机号码"></el-input>
                            <el-button @click="sendCaptcha">{{ captchaCountDown == 0 ? '发送验证码' : captchaCountDown + '秒后重发'}}</el-button>
                        </div>
                        <div v-show="!needValidPhone">
                            <span style="color: #999999">{{ruleForm.phone}}</span>
                            <el-button @click="changePho" style="margin-left: 20px;">修改手机号码</el-button>
                        </div>
                    </el-form-item>
                    <el-form-item prop="phone_code" class="mobile-wrapper" v-if="needValidPhone" ref="phoneCode">
                        <div v-show="needValidPhone">
                            <el-input v-model="ruleForm.phone_code" placeholder="请输入验证码"></el-input>
                        </div>
                    </el-form-item>

                    <el-form-item label="邮箱" prop="email">
                        <el-input v-model="ruleForm.email" placeholder="请填写邮箱"></el-input>
                    </el-form-item>
                    <el-form-item label="承诺书" prop="promise_pic">
                        <image-uploader v-model="ruleForm.promise_pic" @error="onImageSelectError" @change="dispatchChangeForElItem">
                            <div slot="desc" class="size12">
                                请填写完本页信息后，点击下载
                                <a href="//17dayup-protocol.bj.bcebos.com/个人入驻承诺书.doc">承诺书</a>，上传亲笔签名后的扫描件

                                <br> 文件小于2M <br> 支持jpg,gif,png或bmp格式的图片
                            </div>
                        </image-uploader>
                    </el-form-item>
                </div>
                <!-- en -->
                <div v-if="env">
                    <el-form-item :label="$t('applicationPerson.identityProve.field.country')" prop="country">
                        <el-select :placeholder="$t('applicationPerson.placeholder.select')" v-model="ruleForm.country">
                            <el-option v-for="item in countriesList" :label="item.name" :value="item.id" :key="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item :label="$t('applicationPerson.identityProve.field.email')" prop="email" class="email-wrapper">
                        <div v-show="needValidEmail">
                            <el-input v-model="ruleForm.email" :placeholder="$t('applicationPerson.placeholder.emailInput')"></el-input>
                            <el-button @click="sendEmailCaptcha">{{ captchaCountDown == 0 ? $t('applicationPerson.btn.sendEmailCode') : captchaCountDown + $t('applicationPerson.btn.reSend')}}</el-button>
                            <br>
                            <span class="tipSendCaptcha" v-if="emailCodeSend&&ruleForm.email">The verification code has been sent to your mailbox. Please read the email and enter the verification code in the upper entry box</span>
                        </div>
                        <div v-show="!needValidEmail">
                            <span style="color: #999999">{{ruleForm.email}}</span>
                            <el-button @click="changeEmail" style="margin-left: 20px;">{{$t('applicationPerson.btn.editEmail')}}</el-button>
                        </div>
                    </el-form-item>

                    <el-form-item prop="captcha" class="email-wrapper" ref="emailCode" v-if="needValidEmail">
                        <div v-show="needValidEmail">
                            <el-input v-model="ruleForm.captcha" :placeholder="$t('applicationPerson.placeholder.emailCode')"></el-input>
                        </div>
                    </el-form-item>
                </div>
                <!--  -->
            </div>


        </section>

        <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')" :loading="isFinished">{{$t('applicationPerson.btn.submitFile')}}</el-button>
        </el-form-item>
    </el-form>
</div>
</template>


<script>
import Vue from 'vue'
import ImageUploader from "@/components/upload/ImageUploader"
import * as api from '@/js/api'
import utils from '@/js/utils'
import validatorMixin from '@/js/mixin/validatorMixin'
import Validators from '@/js/validator/index';


export default {
    mixins: [validatorMixin],
    components: {
        ImageUploader
    },
    computed: {
        needValidPhone() {
            return !this.validPhoneNumber || this.validPhoneNumber != this.ruleForm.phone;
        },
        needValidEmail() {
            return !this.validEmail || this.validEmail != this.ruleForm.email;
        }
    },
    props: {
        initData: {},
        env: {
            type: Boolean
        }
    },
    data() {
        var form = {
            per_show_name: '', //个人真实姓名
            personal_logo: '', //个人真实头像
            person_type: '', //个人主营类目，枚举（）
            short_des: '', // 简介
            description: '',

            // section two
            per_name: '',
            country: '', //国家
            id_type: '1', //身份证明方式（1身份证，2护照）
            id_pic: '', //证件照片
            id_pic_behand: '', //证件照片背面
            id_code: '', //证件id号
            passport_pic: '',
            passport_code: '',

            //certificate_pic: '', //教师资质认证，图片url
            //certificate_name: '', //教师资质名称
            //diploma_pic: '', //学位证图片
            //diploma_name: '',  //学位证名称
            //professional_certificate_pic: '', //专业证书图片
            weibo_id: '', //微博帐号
            //weibo_pic: '', //微博截图
            //weibo_name: '', //微博实名
            //other_pic: '', //其他认证图片
            //other_name: '', // 其他认证名称

            certificate_type: '',
            cer_pic: '',
            cer_name: '',
            phone: '', //手机号
            email: '', // 邮箱
            promise_pic: '', // 承诺书照片
        };
        if (this.initData) {
            formWithInitData(form, this.initData);
        }
        return {
            ruleForm: form,
            rules: {
                per_show_name: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.businessNameEmpty'),
                    trigger: 'blur'
                }, ],
                short_des: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.introductionEmpty'),
                    trigger: 'blur'
                }, ],
                personal_logo: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.imgEmpty'),
                    trigger: 'change'
                }],
                person_type: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.mainBusinessEmpty'),
                    trigger: 'change'
                }],
                description: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.desEmpty'),
                    trigger: 'blur'
                }, ],

                // section two
                per_name: [{
                    required: true,
                    message: this.$t('applicationPerson.rules.realNameEmpty'),
                    trigger: 'blur'
                }, ],

                country: [{
                    required: true,
                    message: 'please choose country',
                    trigger: 'change'
                }, ],

                id_pic: {
                    required: true,
                    message: this.$t('applicationPerson.rules.idProofEmpty'),
                    trigger: 'change'
                },
                id_pic_behand: {
                    required: true,
                    message: this.$t('applicationPerson.rules.idBackEmpty'),
                    trigger: 'change'
                },
                id_code: [{
                        required: true,
                        message: this.$t('applicationPerson.rules.idNumberEmpty'),
                        trigger: 'blur'
                    },
                    {
                        validator: Validators.idCardNo,
                        trigger: 'blur'
                    },
                    {
                        trigger: 'blur',
                        validator: (rule, value, callback) => {
                            this.checkRepeat('id_code', value)
                                .then(res => callback(res.data.status == 200 ? undefined : res.data.msg));
                        }
                    }
                ],

                passport_pic: {
                    required: true,
                    message: this.$t('applicationPerson.rules.passportImgEmpty')
                },
                passport_code: [{
                        required: true,
                        message: this.$t('applicationPerson.rules.passportNumberEmpty'),
                        trigger: 'blur'
                    },
                    {
                        trigger: 'blur',
                        validator: (rule, value, callback) => {
                            this.checkRepeat('passort_code', value)
                                .then(res => callback(res.data.status == 200 ? undefined : res.data.msg))
                        }
                    }
                ],

                cer_pic: {
                    required: true,
                    message: this.$t('applicationPerson.rules.imgUploadEmpty')
                },
                cer_name: {
                    required: true,
                    message: this.$t('applicationPerson.rules.nameEmpty'),
                    trigger: 'blur'
                },
                certificate_type: {
                    required: true,
                    message: this.$t('applicationPerson.rules.certificateEmpty'),
                    trigger: 'change'
                },
                weibo_id: {
                    requried: true,
                    message: '请输入新浪微博认证账号',
                    trigger: "blur"
                },

                phone: [{
                        required: true,
                        message: '请填写手机号',
                        trigger: 'blur'
                    },
                    {
                        validator: Validators.phone,
                        trigger: 'blur'
                    }
                ],
                phone_code: [{
                        required: true,
                        validator: (rule, value, callback) => {
                            if (this.ruleForm.phone_code.length >= 6) {
                                this.validatePhoneCode();
                            } else if (this.ruleForm.phone_code.length <= 0) {
                                callback('请输入验证码');
                            }
                        },
                        trigger: 'change'
                    },

                ],
                captcha: [{
                        required: true,
                        validator: (rule, value, callback) => {
                            if (this.ruleForm.captcha.length >= 6) {
                                this.validateEmailCode();
                            } else if (this.ruleForm.captcha.length <= 0) {
                                callback('Please enter your email verification code');
                            }
                        },
                        trigger: 'change'
                    },

                ],
                email: [{
                        required: true,
                        message: this.$t('applicationPerson.rules.emailEmpty'),
                        trigger: 'blur'
                    },
                    {
                        validator: Validators.email,
                        trigger: 'blur'
                    }
                ],

                promise_pic: {
                    required: true,
                    message: this.$t('applicationPerson.rules.commitmentEmpty'),
                    trigger: 'change'
                }
            },
            insTypes: [],
            isFinished: false,
            validPhoneNumber: '',
            validEmail: '',
            captchaCountDown: 0,
            cerTypeMap: {
                certificate: {
                    pic: '请提交有效期内的教师资格证照片，需确保头像和文字清晰',
                    tip: '如：音乐教师资格证。(10字以内，会标注在老师主页)'
                },
                diploma: {
                    pic: '请提交大学本科以上学历水平证件照片，如学生证、毕业证等（需包含照片、姓名、专业、官方印章等有效信息）',
                    tip: '如：绘画艺术硕士学位。（10字内，会标注在老师主页）'
                },
                professional_certificate: {
                    pic: '请提交教学能力或专业能力证明，如职称证书、考级证书等（需包含官方印章等有效信息）',
                    tip: '如：民乐琵琶演奏十级。（10字内，会标注在老师主页）'
                },
                weibo: {
                    pic: '请提交微博认证账号截图',
                    tip: '如：微博认证名师。（10字内，会标注在老师主页）'
                },
                other: {
                    pic: '请提交其他证明您教学水平的证明',
                    tip: '如：专职讲师聘书。（10字内，会标注在老师主页）'
                }
            },
            countriesList: [],
            emailCodeSend: false
        };
    },

    created() {
        this.getInsType();
        this.getCountriesList();
        this.validPhoneNumber = this.ruleForm.phone;
        this.validEmail = this.ruleForm.email;
    },
    destroy() {
        if (this.destroyCountDown) {
            this.destroyCountDown();
        }
    },
    methods: {
        changePho() {
            this.ruleForm.phone = '';
            this.validPhoneNumber = '';
            this.ruleForm.phone_code = '';
            if (this.destroyCountDown) {
                this.destroyCountDown();
                this.captchaCountDown = 0;
            }
        },
        changeEmail() {
            this.validEmail = '';
            this.ruleForm.email = '';
            this.ruleForm.captcha = '';
            this.emailCodeSend = false;
            if (this.destroyCountDown) {
                this.destroyCountDown();
                this.captchaCountDown = 0;
            }
        },
        getCountriesList() {
            api.common.getCountry().then(res => {
                this.countriesList = res.data;
                this.countriesList.map(function(item) {
                    return item.id = item.id.toString();
                });
            })
        },
        submitForm(formName) {
            if (!this.isFinished) {
                this.$refs[formName].validate((valid) => {
                    console.log(JSON.stringify(this.ruleForm));
                    if (!valid) return;
                    // if (this.needValidPhone && !this.env) {
                    //     return this.showFormItemError(this.$refs.phone, '请先验证手机号');
                    // }

                    var type = this.ruleForm.certificate_type;
                    this.ruleForm[type + '_pic'] = this.ruleForm.cer_pic;
                    this.ruleForm[type + '_name'] = this.ruleForm.cer_name;
                    this.isFinished = true;
                    if (!this.env) {
                        delete this.ruleForm.country;
                    }
                    api.personal.registerPersonal(this.ruleForm)
                        .then(data => {
                            this.$emit('success');
                            this.isFinished = false;
                        }, () => {
                            this.isFinished = false;
                        })
                });
            }

        },
        getInsType() {
            api.institute.getInsType().then(data => this.insTypes = data);
        },

        sendCaptcha() {
            if (!this.ruleForm.phone) return;

            var _this = this;
            this.$refs.ruleForm.validateField('phone', function(errors) {
                if (!errors) {
                    api.common.sendCaptcha(_this.ruleForm.phone, 7).then(() => {
                        _this.destroyCountDown = utils.countdown(60, {
                            onProgress: (s) => _this.captchaCountDown = s
                        });
                    })
                };
            });

        },
        sendEmailCaptcha() {
            if (!this.ruleForm.email) return;

            var _this = this;
            this.$refs.ruleForm.validateField('email', function(errors) {
                if (!errors) {
                    api.common.sendEmailCaptcha(_this.ruleForm.email, 6).then(() => {
                        _this.emailCodeSend = true;
                        _this.destroyCountDown = utils.countdown(300, {
                            onProgress: (s) => _this.captchaCountDown = s
                        });
                    })
                }
            });
        },

        validatePhoneCode() {
            var phone = this.ruleForm.phone;
            api.common.checkCaptcha({
                type: 7,
                captcha: this.ruleForm.phone_code,
                phone: phone
            }).then(res => {
                if (res.status == 200) {
                    this.validPhoneNumber = phone;
                } else {
                    this.showFormItemError(this.$refs.phoneCode, '验证码错误');
                }
            })
        },

        validateEmailCode() {
            var email = this.ruleForm.email;
            api.common.checkCaptcha({
                type: 6,
                captcha: this.ruleForm.captcha,
                email: email
            }).then(res => {
                if (res.status == 200) {
                    this.validEmail = email;

                } else {
                    this.showFormItemError(this.$refs.emailCode, 'E-mail verification code error');
                }
            })
        },

        checkRepeat(key, value) {
            switch (key) {
                case 'id_code':
                    return api.personal.checkIdCode(value);
                case 'passort_code':
                    return api.personal.checkPassportCode(value);
            }
        },

        resetForm(formName) {
            this.$refs[formName].resetFields();
        },

        showFormItemError(formItem, message) {
            formItem.validateState = 'error';
            formItem.validateMessage = message;
        }
    }
}

function formWithInitData(form, data) {
    var cer_types = ['certificate', 'diploma', 'professional_certificate', 'weibo', 'other'];
    for (var key in form) {
        if (data[key] && form.hasOwnProperty(key)) {
            form[key] = data[key] + '';
        }
    }
    for (var i = 0, len = cer_types.length; i < len; i++) {
        var cer_type = cer_types[i];
        var nameKey = cer_type + '_name';
        if (data[nameKey]) {
            form.certificate_type = cer_type;
            form.cer_pic = data[cer_type + '_pic']
            form.cer_name = data[nameKey];
        }
    }
    return form;
}
</script>


<style lang="stylus">
.size12{
    font-size: 12px;
}
.expound{
    font-size:12px;
    color: #999;
    font-weight: 400;
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
    .email-wrapper
        .el-input
            width 267px
        .tipSendCaptcha
              line-height 14px
              color #268fff
              font-size 12px
    .el-input,.el-textarea
        width 400px

    .form-line
        margin-bottom 22px
    .el-form-item .el-form-item
        margin-top 20px
</style>
