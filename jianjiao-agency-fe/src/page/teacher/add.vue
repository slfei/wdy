
<template>
  <div class="page page-add-teacher">
    <div class="header">
      <router-link :to="{path: '/teacher'}" tag="span" class="back-btn">
        <i class="el-icon-arrow-left"/>
      </router-link>
      {{ pageTitle }}
    </div>
    <div class="form">
      <el-form ref="form"
        label-position="right"
        label-width="100px"
        class="add-teacher-form"
        :model="form"
        :rules="rules"
      >
        <el-form-item label="姓名" prop="name">
          <el-input v-model="form.name" placeholder="请输入老师姓名，30字以内" :maxlength="30"/>
        </el-form-item>
        <el-form-item label="头像" prop="avatar">
          <image-uploader v-model="form.avatar" @error="onImageError"/>
          <div class="desc">
            建议尺寸为120*120，宽高比为1：1<br/>
            支持jpg,gif,png或bmp格式的图片
          </div>
        </el-form-item>
        <el-form-item label="教龄" prop="school_age">
          <el-input v-model="form.school_age" class="small-input"/> 年
        </el-form-item>
        <el-form-item label="授课科目" prop="course">
          <el-input v-model="form.course" placeholder="多个科目间用逗号隔开，30字以内" :maxlength="30"/>
        </el-form-item>
        <el-form-item label="老师学历" prop="degrees">
          <el-radio-group v-model="form.degrees">
            <el-radio v-for="(v, k) in degreeMap" :label="k" :key="k">{{ v }}</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="职称" prop="titles">
          <el-radio-group v-model="form.titles">
            <el-radio v-for="(v, k) in titleMap" :label="k" :key="k">{{ v }}</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div class="btn-group">
        <router-link :to="{ path: '/teacher' }">
          <el-button plian>取消</el-button>
        </router-link>
        <el-button type="primary" @click="save" :loading="savingData">保存</el-button>
      </div>
    </div>
  </div>
</template>
<script>
  import api from '@/js/api/teacher'
  import ImageUploader from '@/components/upload/ImageUploader'
  import constants from './constants'

  export default {
    components: {
      ImageUploader
    },
    data () {
      return {
        ...constants,
        pageTitle: '添加老师',
        savingData: false,
        form: {
          name: '',
          avatar: '',
          school_age: '',
          course: '',
          degrees: '',
          titles: ''
        },
        rules: {
          name: { required: true, trigger: 'change', message: '请输入老师姓名'},
          avatar: { required: true, trigger: 'change', message: '请上传头像'},
          school_age: { required: true, trigger: 'change', message: '请输入教龄'},
          course: { required: true, trigger: 'change', message: '请输入教学科目'},
          degrees: { required: true, trigger: 'change', message: '请选择学历'},
          titles: { required: true, trigger: 'change', message: '请选择职称'},
        }
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => vm.setTitle(to.params.id == undefined ? 'add' : 'save'));
    },
    created () {
      this.getInfo();
    },
    watch: {
      '$route': 'getInfo',
    },
    methods: {
      setTitle (type) {
        console.log(type);
        if (type == 'add') {
          this.pageTitle = '添加老师';
        } else {
          this.pageTitle = '编辑老师信息';
        }
        this.type = type;
      },

      getInfo () {
        if (this.$route.params.id) {
          api.getTeacherInfo(this.$route.params.id).then((data) =>{
            data.degrees = '' + data.degrees;
            data.titles = '' + data.titles;
            this.form = data;
          })
        }
      },

      onImageError (e) {
        console.log(e.message);
      },

      save () {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.savingData = true;
            var params = Object.assign({}, this.form);
            if (this.type !== 'add') {
              params.teacher_id = params.id;
            }
            api.saveTeacher(params).then(() => {
              this.savingData = false;
              this.$router.push('/teacher');
            }).catch(() => this.savingData = false);
          }
        });
      }
    }
  }
</script>

<style lang="styl">
  .add-teacher-form
    width 500px
    .small-input
      width 160px
    .el-fomr-item__label
      padding-left 18px
  .page-add-teacher
    .header
      height 77px
      line-height 77px
      padding-left 40px
      font-size 24px
      color #333
      .back-btn
        cursor pointer
    .desc
      color #999
      font-size 12px
      line-height 1.4
      padding-top 30px
    .btn-group
      padding-left 100px

</style>
