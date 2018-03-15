<template>
<div>
  <el-form label-width="160px" class="demo-ruleForm" :rules="rules" :model="ruleForm" ref="ruleForm">
    <section class="form-grp">
      <div class="s-hd">
        基本信息
      </div>
      <div class="s-bd">
        <el-form-item label="经营名称" prop="institution_name" ref="institution_name">
          <el-input v-model="ruleForm.institution_name" placeholder="显示在网站上的名字，请认真填写，30字以内" :maxlength="30" @blur="setDraftData"></el-input>
        </el-form-item>
        <el-form-item label="机构logo" prop="logo">
          <image-uploader v-model="ruleForm.logo" @changefile="changeImage" @error="onImageSelectError">
            <div slot="desc" class="size12 img-logo">
              建议尺寸为120*120 <br> 支持jpg,gif,png或bmp格式的图片
            </div>
          </image-uploader>
        </el-form-item>
        <el-form-item label="主营类目">
          <el-select placeholder="请选择" v-model="ruleForm.main_categories" class="main-categories" @change="setDraftData">
            <el-option v-for="item in categorylist" :key="item.cat_id" :label="item.cat_name" :value="item.cat_id">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="机构类型">
          <el-radio-group v-model="ruleForm.type" @change="setDraftData">
            <el-radio label="1">公司</el-radio>
            <el-radio label="2">工作室</el-radio>
            <el-radio label="3">学校</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="地址" class="address-group" prop="address">

          <city-selector v-model="city" />
          <el-input placeholder="例：海淀大街38号银科大厦712" v-model="ruleForm.specific_address"></el-input>
        </el-form-item>
      </div>
    </section>

    <section class="form-grp">
      <div class="s-hd">
        资质填写
      </div>
      <div class="s-bd">
        <el-form-item label="经营者身份证正面照" prop="id_image_front">
          <image-uploader v-model="ruleForm.id_image_front" @change="setDraftData">
            <div slot="desc" class="size12 img-identity">
              请保证身份证姓名、身份证号码清晰可见
              <br> 支持jpg,gif,png或bmp格式的图片<br>
              <el-popover ref="popover-proof" placement="bottom-start" width="316" trigger="hover">
                <img src="../../../assets/images/id_proof.png" width="314" height="195">
              </el-popover>
              <el-button type="text" v-popover:popover-proof class="size12 see-example">查看示例</el-button>
            </div>
          </image-uploader>

        </el-form-item>
        <el-form-item label="经营者身份证背面照" prop="id_image_back">
          <image-uploader v-model="ruleForm.id_image_back" @change="setDraftData">
            <div slot="desc" class="size12 img-identity">
              请保证身份证姓名、身份证号码清晰可见
              <br> 支持jpg,gif,png或bmp格式的图片<br>
              <el-popover ref="popover-back" placement="bottom-start" width="316" trigger="hover">
                <img src="../../../assets/images/id_back.png" width="314" height="195">
              </el-popover>
              <el-button type="text" v-popover:popover-back class="size12 see-example">查看示例</el-button>
            </div>
          </image-uploader>
        </el-form-item>
        <el-form-item label="营业执照" prop="business_license">
          <image-uploader v-model="ruleForm.business_license" @change="setDraftData">
            <div slot="desc" class="size12">
              请上传营业执照副本扫描件，保证各项内容清晰可见，且申请时间在有限期范围内
              <br> 支持jpg,gif,png或bmp格式的图片
            </div>
          </image-uploader>
        </el-form-item>
        <el-form-item label="统一社会信用代码" prop="social_code" ref="social_code">
          <el-input placeholder="营业执照注册号或统一社会信用代码" v-model="ruleForm.social_code" @blur="setDraftData"></el-input>
        </el-form-item>
        <el-form-item label="申请人" prop="applicant">
          <el-input placeholder="申请人姓名" v-model="ruleForm.applicant" @blur="setDraftData"></el-input>
        </el-form-item>
        <el-form-item label="联系电话" prop="phone" ref="phone">
          <el-input placeholder="我们将拨打此电话向您核实信息" class="phone-input" v-model="ruleForm.phone" @blur="setDraftData"></el-input>
          <el-button type="primary" @click="vifiPhoneCode">验证信息</el-button>
        </el-form-item>
      </div>
    </section>
    <el-dialog title="验证手机" :visible.sync="vifiDialogVisible" :before-close="handleClose" width="30%" class="verify-dialog j-dialog" @open="openModel">
      <div class="form-group">
        <label class="pull-left text-right">手机号：</label>
        <div class="form-input pull-left">
          <span class="phone">{{temp_phone}}</span>
          <el-button type="primary" @click="getVerifiCode" :disabled="captchaCountDown>0"> {{ captchaCountDown == 0 ? '发送验证码' : captchaCountDown + '秒后重发'}}</el-button>
        </div>
      </div>
      <div class="form-group">
        <el-form-item label="验证码：" prop="verification_code" class="item-code" ref="verification_code">
          <el-input placeholder="请输入验证码" v-model="ruleForm.verification_code"></el-input>
        </el-form-item>
      </div>
      <div class="btn-group">
        <el-button type="primary" @click="surnBtn">确 定</el-button>
        <el-button @click="vifiDialogVisible=false">取 消</el-button>
      </div>
      </span>
    </el-dialog>
    <el-form-item>
      <el-button @click="backtrack">上一步</el-button>
      <el-button type="primary" @click="submitForm('ruleForm')">提交审核</el-button>
    </el-form-item>
  </el-form>

</div>
</template>

<script>
import ImageUploader from "@/components/upload/ImageUploader"
import validatorMixin from '@/js/mixin/validatorMixin'
import api from '@/js/api/applySettle'
import apiCommon from '@/js/api/common'
import utils from '@/js/utils'
import Validators from '@/js/validator/index'
import CitySelector from '@/components/cascade-select/cascadeCity';

export default {
  components: {
    ImageUploader,
    CitySelector
  },
  mixins: [validatorMixin],
  props: {
    // ifClaimInfo: {
    //   type: Boolean
    // }
  },
  data() {
    return {
      city: '',
      ruleForm: {
        institute_id: '22',
        institution_name: '',
        logo: '',
        main_categories: '',
        type: '2',
        province: '',
        city: '',
        area: '',
        specific_address: '',
        id_image_front: '',
        id_image_back: '',
        business_license: '',
        social_code: '',
        applicant: '',
        phone: ''
      },
      temp_phone: '',
      rules: {
        institution_name: [{
            required: true,
            message: '请输入经营名称',
            trigger: 'blur'
          },
          {
            max: 30,
            message: '经营名称30字以内',
            trigger: 'blur'
          },
          {
            trigger: 'blur',
            validator: (rule, value, callback) => {
              this.checkRepeat();
            }
          }
        ],
        logo: [{
          required: true,
          message: '请上传机构logo',
          trigger: 'change'
        }],
        address: [{
          validator: (rule, value, callback) => {
            if (this.city.trim().split(/\s+/).length < 3) {
              return callback('请选择地址');
            }
            if (!value) {
              return callback('请选择地址')
            }
          },
          message: '请选择地址',
          trigger: 'blur'
        }],
        id_image_front: [{
          required: true,
          message: '请上传经营者身份证正面照',
          trigger: 'change'
        }],
        id_image_back: [{
          required: true,
          message: '请上传经营者身份证背面照',
          trigger: 'change'
        }],
        business_license: [{
          required: true,
          message: '请上传营业执照',
          trigger: 'change'
        }],
        social_code: [{
            required: true,
            message: '请填写统一社会信用代码',
            trigger: 'blur'
          },
          {
            trigger: 'blur',
            validator: (rule, value, callback) => {
              this.checkCodeRepeat();
            }
          }
        ],
        applicant: [{
          required: true,
          message: '请填写申请人',
          trigger: 'blur'
        }, {
          max: 10,
          message: '申请人10字以内',
          trigger: 'blur'
        }],
        phone: [{
          required: true,
          message: '请填写电话号码',
          trigger: 'blur'
        }, {
          validator: Validators.phone,
          trigger: 'blur'
        }],
        verification_code: [{
          required: true,
          validator: (rule, value, callback) => {
            if (this.ruleForm.verification_code.length >= 6) {
              this.checkCaptcha();
            } else if (this.ruleForm.verification_code.length < 6) {
              callback('验证码为6位数字');
            } else if (this.ruleForm.verification_code.length <= 0) {
              callback('请输入验证码');
            }
          },
          trigger: 'blur'
        }],
      },
      vifiDialogVisible: false,
      categorylist: [],
      captchaCountDown: 0
    }
  },
  created() {
    var _self = this;
    bus.$on('transInstitutionID', function(data) {
      _self.ruleForm.institute_id = data;
    });

    this.getCategory(); // 主营类目
    this.getClaimInfo(); //数据回显

    if (_self.ifClaimInfo) {
      this.getClaimInfo();
    }
    this.$watch('city', function() {
      this.$refs.ruleForm.validateField('address');
    })
  },

  methods: {
    handleClose(done) {
      this.$confirm('确认关闭?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
          customClass: 'j-dialog'
        })
        .then(_ => {
          done();
        })
        .catch(_ => {});
    },
    getCategory() { // 主营类目
      api.getCategory().then(res => {
        this.categorylist = res;
        this.ruleForm.main_categories = this.categorylist[0].cat_id;
      })
    },
    onSelected(data) {
      // this.citys = data.province.value + data.city.value
      // this.$emit('city', this.citys + this.cityDetails)
      console.log(data);

    },
    getClaimInfo() { // 数据回显
      // api.getClaimInfo().then(res => {
      //   this.ruleForm = res;
      // })
    },
    changeImage(data) {
      this.dispatchChangeForElItem(data);
      this.setDraftData();
    },
    setDraftData() { //保存到草稿箱
      api.setDraftData(this.ruleForm).then(res => {

      })
    },
    checkRepeat() {
      var params = {
        institution_name: this.ruleForm.institution_name,
        institute_id: this.ruleForm.institute_id
      };
      api.checkName(params).then(res => {
        if (res.status == 200) {
          //this.validPhoneNumber = phone;
        } else {
          this.showFormItemError(this.$refs.institution_name, '经营名称已存在，分店请特殊说明，例:新东方(中关村校区)');
        }
      })
    },
    checkCodeRepeat() {
      var params = {
        social_code: this.ruleForm.social_code,
        institute_id: this.ruleForm.institute_id
      };
      api.checkCode(params).then(res => {
        if (res.status == 200) {

        } else {
          this.showFormItemError(this.$refs.social_code, '信用代码已存在');
        }
      })
    },
    vifiPhoneCode() {
      var _this = this;
      this.$refs.ruleForm.validateField('phone', function(errors) {
        if (!errors) {
          _this.vifiDialogVisible = true;
          _this.temp_phone = _this.ruleForm.phone;
          _this.ruleForm.verification_code = '';
        }
      });
    },
    getVerifiCode() { //获取验证码
      apiCommon.sendCaptcha(this.ruleForm.phone, 1).then(() => {
        this.destroyCountDown = utils.countdown(60, {
          onProgress: (s) => this.captchaCountDown = s
        });
      })
    },
    checkCaptcha() { //验证 验证码
      var params = {
        phone: this.ruleForm.phone,
        captcha: this.ruleForm.verification_code,
        type: 1
      };
      apiCommon.checkCaptcha(params).then(res => {
        if (res.status == 200) {
          this.vifiDialogVisible = false;
        } else {
          this.showFormItemError(this.$refs.verification_code, '验证码错误');
        }
      })
    },
    openModel() {
      this.captchaCountDown = 0;
    },
    showFormItemError(formItem, message) {
      formItem.validateState = 'error';
      formItem.validateMessage = message;
    },
    surnBtn() {
      var _this = this;
      this.$refs.ruleForm.validateField('verification_code', function(errors) {
        if (!errors) {
          _this.vifiDialogVisible = false;
        }
      });
    },
    submitForm(formName) {
      console.log("11", this.ruleForm);

      this.$refs[formName].validate((valid) => {
        if (valid) {
          api.submitform(this.ruleForm).then(res => {
            this.$emit('success');
          })
        } else {
          return false;
        }
      });
    },
    backtrack() {
      //location.href = "apply.html#/apply";
    }
  }
}
</script>


<style lang="stylus">
.item-code
  .el-form-item__label
    width 100px!important
    padding-right 0
  .el-form-item__content
    margin-left 100px!important
    .el-input
      width 215px
.verify-dialog
  .form-group
    overflow hidden
    margin 15px 0
    label
      width 100px
      line-height 40px
    .form-input
      span.phone
        line-height 40px
        margin-right 15px
      .input-block
        width 217px

  .btn-group
    margin-left 100px
    button
      width 100px
      margin-right 3px




.form-grp
    .s-hd
        font-size 16px
        color #333
        font-weight bold
        border-bottom 1px solid #f5f5f5
        padding-bottom 20px
        margin-bottom 20px
      .s-bd
        .address-group
          .el-input
            margin-top 10px
        .el-input
          width 400px
        .main-categories
          width 163px
          .el-input
            width 163px
        .img-logo
          padding-top 25px
        .img-identity
          padding-top 15px
        .phone-input
          width 297px
        .see-example
          padding 0
          margin-top 10px
        .distpicker-address-wrapper
            width 400px
            .el-select
              width 123px
              color #666
              font-size 14px

    .form-line
        margin-bottom 22px
    .el-form-item .el-form-item
        margin-top 20px
</style>
