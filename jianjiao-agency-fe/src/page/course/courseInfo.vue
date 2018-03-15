<template>
<div class="main">
	<div class="head">
		<h3 @click="back">< 返回课程列表</h3>
	</div>
	<div class="content">
		<h4 class="title">创建课程</h4>
		<el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="130px" class="ruleForm">
			<el-form-item label="课程名称" prop="course_name">
			 	<el-input v-model="ruleForm.course_name"  placeholder="请填写课程名称，30字以内" :maxlength="30"></el-input>
			</el-form-item>
			<el-form-item label="一句话营销" prop="sentence">
			 	<el-input v-model="ruleForm.sentence"  placeholder="一句话说明课程特色，30字以内" :maxlength="30"></el-input>
			</el-form-item>
			<el-form-item label="课程图片" prop="course_img">
			 	<image-uploader v-model="ruleForm.course_img">
            <div slot="desc" style="font-size: 12px;color:#999999;" >建议尺寸为120*120 建议宽高比为1比1<br>支持jpg,gif,png或者bmp格式的图片
            </div>
        </image-uploader>
			</el-form-item>
			<el-form-item label="课程价格" prop="price">
			 	<el-input v-model="ruleForm.price"  placeholder="请输入课程价格，保留小数点后两位" style="width: 400px;margin-right: 10px"></el-input>元
			</el-form-item>
			<el-form-item class="buttons">
				<el-button @click="cancel">取消</el-button>
				<el-button @click="save">保存</el-button>
				<el-button @click="submit" type="primary">提交</el-button>
			</el-form-item>
		</el-form>
	</div>
</div>
</template>
<script>
import ImageUploader from '@/components/upload/ImageUploader'
import api from '@/js/api/course'
export default{
  components: {
    ImageUploader
  },
	data() {
		return{
			ruleForm:{
				course_name: null,
				sentence: null,
				course_img: null,
				price: null,
			},
			rules: {
        course_name: [
            { required: true , message: '请输入课程名称' , trigger: 'blur'},
        ],
        sentence: [
            { required: false , trigger: 'blur'},
        ],
        course_img: [
            { required: true , message:  '请上传课程图片' , trigger: 'change'},
        ],
        price: [
          {
          	required:true,
            validator: (rule, value, callback) => {
              if (value != parseFloat(value)){
                  callback('请输入正确的价格');
              } else if (value <= 0){
                  callback('请输入正确的价格');
              } else if (value == parseFloat(value) && (parseFloat(value).toFixed(2) - value) != 0){
                  callback('价格保留小数点后两位');
              } else{
                  callback();
              }
          },
            trigger: 'blur'
          },
        ],
			}
		}
	},
	mounted() {
		if(this.$route.params.id) {
			this.getInfo(this.$route.params.id);
		}
	},
	methods:{
		cancel() {
			this.$router.push({path:'/course'})
		},
		save() {
			let data = Object.assign(this.ruleForm,{status:0,course_id:this.$route.params.id})
			console.log(data)
			return new Promise((resolve, reject) => {
        this.$refs['ruleForm'].validate(valid => {
            if (valid) {
                return api.saveCourse(data).then(this.back(), reject);
            }
            return reject();
        })
     	})
		},
		submit() {
			let data = Object.assign(this.ruleForm,{status:1,course_id:this.$route.params.id})
			return new Promise((resolve, reject) => {
          this.$refs['ruleForm'].validate(valid => {
              if (valid) {
                  return api.saveCourse(data).then(this.back(), reject);
              }
              return reject();
          })
       	})
			},
		back() {
			this.$router.push({path:'/course'})
		},
		getInfo(id) {
			api.courseInfo({course_id:id}).then((res)=>{
				this.ruleForm={
					course_name: res.course_name,
					sentence: res.sentence,
					course_img: res.course_img,
					price: res.price,
				}
			})
		}
	}
}
</script>
<style lang="stylus" scoped>
.main
	background #f5f5f5
	padding 20px
	.head
		height 80px
		line-height 80px
		background #fff
		padding-left 40px
		h3
			cursor pointer
	.content
		margin-top 1px
		background #fff
		padding 20px
		.title
			margin-left 40px
		.ruleForm
			width 600px
			.buttons
				text-align center

</style>