<template>
<div class="store-main">
  <p class="top-link">
    <el-button type="primary">查看主页</el-button>
  </p>
  <div class="info-content">
    <div class="info-block base-main">
      <div class="title-block">
        <span class="base-title">基本信息</span>
      </div>
      <div class="form-block">
        <el-form label-width="90px" class="demo-ruleForm">
          <section class="form-grp">
            <div class="s-bd">
              <el-form-item label="经营名称：">
                <el-input v-model="baseInfoForm.institute_name" placeholder="显示在网站上的名字，请认真填写，30字以内" :maxlength="30" v-if="!baseInfoEditable"></el-input>
                <span class="info-text" v-if="baseInfoEditable">{{baseInfoForm.institute_name}}</span>
              </el-form-item>
              <el-form-item label="logo：">
                <image-uploader v-if="!baseInfoEditable" v-model="baseInfoForm.logo">
                </image-uploader>
                <img :src="baseInfoForm.logo" v-if="baseInfoEditable">
              </el-form-item>
              <el-form-item label="主营类目：" class="cate-select">
                <!-- <el-select placeholder="请选择" v-if="!baseInfoEditable" v-model="baseInfoForm.category[0].cat_id" @change="changeA">
                  <el-option v-for="item in categoryList" :key="item.cat_id" :label="item.cat_name" :value="item.cat_id">
                  </el-option>
                </el-select>
                <el-select placeholder="请选择" v-if="!baseInfoEditable" v-model="baseInfoForm.category[1]" @change="changeB">
                  <el-option v-for="item in categoryListTwo" :key="item.cat_id" :label="item.cat_name" :value="item.cat_id">
                  </el-option>
                </el-select>
                <el-select placeholder="请选择" v-if="!baseInfoEditable" v-model="baseInfoForm.category[2]" @change="changeC">
                  <el-option v-for="item in categoryListThree" :key="item.cat_id" :label="item.cat_name" :value="item.cat_id">
                  </el-option>
                </el-select> -->
                <select class="el-select">
                  <option :value="item.cat_id" v-for="item in categoryList">{{item.cat_name}}</option>
                </select>
                <select class="el-select">
                  <option :value="item.cat_id" v-for="item in categoryList">{{item.cat_name}}</option>
                </select>
                <span class="info-text" v-if="baseInfoEditable">{{baseInfoForm.category}}</span>
              </el-form-item>
              <el-form-item label="机构类型：">
                <el-radio-group v-if="!baseInfoEditable" v-model="baseInfoForm.institute_type">
                  <el-radio label="1">公司</el-radio>
                  <el-radio label="2">工作室</el-radio>
                  <el-radio label="3">学校</el-radio>
                </el-radio-group>
                <span class="info-text" v-if="baseInfoEditable">{{baseInfoForm.institute_type}}</span>
              </el-form-item>
              <el-form-item label="地址：">
                <el-input placeholder="地址" v-if="!baseInfoEditable" v-model="baseInfoForm.address"></el-input>
                <span class="info-text" v-if="baseInfoEditable">{{baseInfoForm.address}}</span>
              </el-form-item>
              <el-form-item label="电话：">
                <el-input placeholder="电话" v-if="!baseInfoEditable" v-model="baseInfoForm.phone_number"></el-input>
                <span class="info-text" v-if="baseInfoEditable">{{baseInfoForm.phone_number}}</span>
              </el-form-item>
            </div>
          </section>
          <el-form-item v-if="!baseInfoEditable">
            <el-button>取消</el-button>
            <el-button type="primary">提交审核</el-button>
          </el-form-item>
        </el-form>
        <div class="edit-btn" v-if="baseInfoEditable">
          <el-button type="primary" plain @click="changeBaseInfoEditable">编辑</el-button>
        </div>
        <p class="tips">为了确保您的门店信息真实有效，您提交的修改内容将会在审核后再同步到尖椒网。因此会产生短暂的延时，敬请谅解！</p>
      </div>
    </div>
    <div class="info-block base-main">
      <div class="title-block">
        <span class="base-title">招生信息</span>
      </div>
      <div class="form-block">
        <el-form label-width="100px" class="demo-ruleForm">
          <section class="form-grp">
            <div class="s-bd">
              <el-form-item label="开办时间：">
                <el-date-picker v-model="desInfoForm.age_range" type="date" placeholder="选择日期" v-if="!admissionsInfoEditable">
                </el-date-picker>
                <span class="info-text" v-if="admissionsInfoEditable">{{desInfoForm.age_range}}</span>
              </el-form-item>
              <el-form-item label="授课形式：">
                <el-checkbox-group v-if="!admissionsInfoEditable" v-model="desInfoForm.institute_course_type">
                  <el-checkbox label="直播"></el-checkbox>
                  <el-checkbox label="录播"></el-checkbox>
                  <el-checkbox label="面授"></el-checkbox>
                  <el-checkbox label="其他"></el-checkbox>
                </el-checkbox-group>
                <span class="info-text" v-if="admissionsInfoEditable">{{desInfoForm.institute_course_type}}</span>
              </el-form-item>
              <el-form-item label="适学年龄：">
                <el-input placeholder="年龄" v-if="!admissionsInfoEditable" v-model="desInfoForm.age_range"></el-input>
                <span class="info-text" v-if="admissionsInfoEditable">{{desInfoForm.age_range}}</span>
              </el-form-item>
              <el-form-item label="特色：">
                <el-input placeholder="特色" v-if="!admissionsInfoEditable" v-model="desInfoForm.characteristic"></el-input>
                <span class="info-text" v-if="admissionsInfoEditable">{{desInfoForm.characteristic}}</span>
              </el-form-item>
              <el-form-item label="教学科目：">
                <el-input placeholder="教学科目" v-if="!admissionsInfoEditable" v-model="desInfoForm.course_desc"></el-input>
                <span class="info-text" v-if="admissionsInfoEditable">{{desInfoForm.course_desc}}</span>
              </el-form-item>
            </div>
          </section>
          <el-form-item v-if="!admissionsInfoEditable">
            <el-button>取消</el-button>
            <el-button type="primary">提交审核</el-button>
          </el-form-item>
        </el-form>
        <p class="tips">招生信息修改后不需要审核，修改成功后可同步至尖椒网。</p>
      </div>
      <div class="edit-btn" v-if="admissionsInfoEditable">
        <el-button type="primary" plain @click="changeAdmissionsInfoEditable">编辑</el-button>
      </div>
    </div>
    <div class="info-block">
      <div class="title-block">
        <span class="base-title">环境图册</span>
      </div>
      <div class="form-block">
        <el-upload action="/api/universal/uploadimage" list-type="picture-card" :on-preview="handlePictureCardPreview" :on-remove="handleRemove">
          <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
          <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import ImageUploader from "@/components/upload/ImageUploader"
import validatorMixin from '@/js/mixin/validatorMixin'
import api from '@/js/api/store'
//import apiCommon from '@/js/api/common'
import utils from '@/js/utils'
//import Validators from '@/js/validator/index'

export default {
  components: {
    ImageUploader
  },
  mixins: [validatorMixin],
  data() {
    return {
      baseInfoForm: {
        institute_name: '',
        logo: '',
        category: [],
        institute_type: '',
        province: '',
        city: '',
        district: '',
        address: '',
        phone_number: ''
      },
      desInfoForm: {
        age_range: '',
        characteristic: '',
        found_time: '',
        institute_course_type: ''

      },


      baseInfoEditable: true,
      admissionsInfoEditable: true,
      dialogImageUrl: '',
      dialogVisible: false,
      categoryList: [],
      categoryListTwo: [],
      categoryListThree: [],

    }
  },
  created() {
    this.getBaseInfo(); //基本信息
    this.getDesInfo(); //招生信息
    this.getCategoryList(); // 主营类目
  },
  methods: {
    getBaseInfo() { //基本信息
      api.getBaseInfo().then(res => {
        this.baseInfoForm = res;
      })
    },
    getDesInfo() { //招生信息
      api.getDesInfo().then(res => {

        this.desInfoForm = res;
      })
    },
    getCategoryList() {
      api.getCategoryList().then(res => {

        this.categoryList = res;

      })
    },
    changeA(val) {
      var obj = {};
      obj = this.categoryList.find(function(item) {
        return item.cat_id === val;
      });
      this.categoryListTwo = obj.child_cat;
    },
    changeB(val) {
      var obj = {};
      obj = this.categoryListTwo.find(function(item) {
        return item.cat_id === val;
      });
      this.categoryListThree = obj.child_cat;
      console.log("111", this.categoryListThree);
    },
    changeC(val) {
      console.log(this.baseInfoForm.category);
    },
    changeBaseInfoEditable() {
      this.baseInfoEditable = false;
    },
    changeAdmissionsInfoEditable() {
      this.admissionsInfoEditable = false;
    },
    handleRemove(file, fileList) {

    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    }

  }
}
</script>
<style lang="stylus">
  .store-main

    margin 20px auto
    height 500px
    .top-link
      background-color #fff
      padding 10px 20px
    .info-content
      overflow hidden
      .info-block
        float left
        width 380px
        background-color #fff
        padding 15px 0
        margin 15px 0
        .tips
          background-color #fef7ec
          padding 10px
          color #f6b349
          font-size 12px
        .title-block
          overflow hidden
          border-bottom 1px solid #e5e5e5
          padding 0 15px 8px 15px
          margin-bottom 20px
          span
            float right
            font-size 12px
            color #999
            line-height 24px
          span.base-title
              float left
              margin 0
              padding 0
              font-size 18px
              color #333
              font-weight bold
        .form-block
          padding 15px
          .info-text
            color #999
          .cate-select
            .el-select
              width 75px
          .el-form-item__label
            padding-right 0
        .edit-btn
          text-align center
      .info-block.base-main
        margin-right 10px









</style>
