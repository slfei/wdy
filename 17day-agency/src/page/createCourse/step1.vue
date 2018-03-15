<template>
    <div>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="130px" class="demo-ruleForm">
            <section class="form-grp">
                <div class="s-hd">
                   {{$t('createCourse.basicInfo')}}
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('createCourse.courseName')" prop="course_name">
                        <el-input v-model="ruleForm.course_name"  :placeholder="$t('createCourse.courseName_PH')" :maxlength="50"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.sentence')" prop="sentence">
                        <el-input v-model="ruleForm.sentence" :placeholder="$t('createCourse.sentence_PH')" :maxlength="50"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.courseImg')" prop="course_img">
                        <image-uploader v-model="ruleForm.course_img" @error="onImageSelectError" @change="dispatchChangeForElItem">
                            <div slot="desc" style="font-size: 12px;color:#999999;" v-html="$t('createCourse.uploadRule')" >
                            </div>
                        </image-uploader>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.catalog')" prop="category">
                        <el-select v-model="typeone" :placeholder="$t('createCourse.catagory_PH')" class="select" value-key="category_id" @change="changeone">
                            <el-option :label="item.name" :value="item" v-for="(item, key) in typedata[0]" :key="key"></el-option>
                        </el-select>
                        <el-select v-model="typetwo" :placeholder="$t('createCourse.catagory_PH')" class="select" v-if="typeone && typeone._child" value-key="category_id" @change="changetwo">
                            <el-option :label="item.name" :value="item" v-for="(item, key) in typeone._child" :key="key"></el-option>
                        </el-select>
                        <el-select v-model="typethree" :placeholder="$t('createCourse.catagory_PH')" class="select" v-if="typetwo && typetwo._child" value-key="category_id" @change="changethree">
                            <el-option :label="item.name" :value="item" v-for="(item, key) in typetwo._child" :key="key"></el-option>
                        </el-select>
                        <el-select v-model="typefour" :placeholder="$t('createCourse.catagory_PH')" class="select" v-if="typethree && typethree._child" value-key="category_id">
                            <el-option :label="item.name" :value="item" v-for="(item, key) in typethree._child" :key="key"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.courseIntro')" prop="intro"  >
                        <span class="expound">{{$t('createCourse.introRule')}}</span>
                        <div id='editorelm' style="width: 700px"></div>
                    </el-form-item>
                </div>
            </section>
        </el-form>
    </div>
</template>
<script>
import ImageUploader from "@/components/upload/ImageUploader"
import E from 'wangeditor'
import api from '@/js/api/createCourse'
import validatorMixin from '@/js/mixin/validatorMixin';

export default {
    mixins: [validatorMixin],
    components: {
        ImageUploader
    },
    props: {
        initData: {}
    },
    mounted () {
        this.editor = new E('#editorelm');
        this.initEditorConfig();
        this.editor.customConfig.onchange = (html) => {
          this.ruleForm.intro = html
        }
        this.editor.create();
        this.editor.txt.html(this.ruleForm.intro);
        this.getType();
    },
    activated(){
        if(this.initData){
            this.sendMsg();
        }
    },
    data() {
        let form = {
            course_name:'',//课程名称
            sentence: '',//一句话营销
            intro: '',//课程描述
            category:null,//课程类型
            course_img: '',//课程图片的url
        };
        //草稿箱初始值
        if (this.initData) {
            for (var key in this.initData) {
                if (key in form) {
                    form[key] = this.initData[key];
                }
            }
        };
        return {
            dataInterface: {
                editorUpImgUrl: '/api/universal/uploadimage'  // 编辑器插入的图片上传地址
            },
            typedata:[],
            typeone:null,
            typetwo:null,
            typethree:null,
            typefour:null,
            ruleForm: form,
            search:[],
            is_init:true,
            rules: {
                course_name: [
                    { required: true , message: this.$t('createCourse.courseName_WA') , trigger: 'blur'},
                ],
                sentence: [
                    { required: true , message: this.$t('createCourse.sentence_WA') , trigger: 'blur'},
                ],
                course_img: [
                    { required: true , message:  this.$t('createCourse.courseImg_WA') , trigger: 'change'},
                ],
                intro:[
                    { required: true ,validator: (rule, value, callback) => {
                        let isImg = /<img\ssrc="/.test(this.editor.txt.html());
                        let isBlank = /^\s*(\s*&nbsp;\s*){0,}\s*$/g.test(this.editor.txt.text())
                        console.log(isBlank,isImg)
                        console.log(this.editor.txt.text())
                            if ( isBlank && !isImg) {
                                callback(this.$t('createCourse.courseIntro_WA'));
                            } else {
                                callback();
                            }
                        },  trigger: 'blur'},
                ],
                category: [{
                        required:true,
                        validator: (rule, value, callback) => {
                            if (!this.courseType) {
                                callback(this.$t('createCourse.catagory_WA'));
                            } else {
                                callback();
                            }
                        },
                        trigger: 'change'
                    },
                ]
            }
        }
    },
    methods: {
        sendMsg(){
            this.$emit('listenChild',this.ruleForm)
        },
        getType() { //获取上传资料列表数据
                api.getType().then(res => {
                    this.typedata.push(res.data.data);
                }).then(()=>{
                    if(this.ruleForm.category){
                        this.initType(this.ruleForm.category,this.typedata[0]);
                        if(this.search[0].cat_tree){
                            this.getAllType(this.search[0].cat_tree)
                        };
                        this.search.reverse();
                        this.typeone = this.search[0];
                        this.typetwo = this.search[1];
                        this.typethree = this.search[2];
                        this.typefour = this.search[3];
                    }
                }).then(()=>{
                    this.is_init = false ;
                })
        },
        initType(id,data){
            data.forEach((val)=>{
                if(val.category_id == id) {
                    this.search.push(val);
                }else if(val._child){
                    this.initType(id,val._child)
                }
            })
        },
        getAllType(cat_tree){
            var arr = cat_tree.split('-');
            arr.pop();
            while(arr.length){
                this.initType(arr[arr.length-1],this.typedata[0]);
                arr.pop();
            }
        },
        submitForm(courseid){
            this.ruleForm.category = this.courseType;
            if(courseid){
                this.ruleForm.courseid = courseid;
            }
                return new Promise((resolve, reject) => {
                this.$refs['ruleForm'].validate(valid => {
                    if (valid) {
                        return api.step1_mes(this.ruleForm).then(resolve, reject);
                    }
                    return reject();
                })
             })
        },
        changeone(){
            if(!this.is_init){
                this.typetwo = null ;
                this.typethree = null ;
                this.typefour = null ;
            }
        },
        changetwo(){
            if(!this.is_init){
            this.typethree = null ;
            this.typefour = null ;
            }

        },
        changethree(){
            if(!this.is_init){
                this.typefour = null ;
            }
        },
        initEditorConfig(){
                //this.editor.customConfig.showLinkImg = false//网络图片
                this.editor.customConfig.uploadImgShowBase64 =false;
                this.editor.customConfig.uploadImgServer = this.dataInterface.editorUpImgUrl;
                this.editor.customConfig.uploadFileName = 'image'
                this.editor.customConfig.zIndex=100;
                this.editor.customConfig.uploadImgHooks = {
                    customInsert: function (insertImg, result, editor) {
                        var url = result.data.url
                        insertImg(url)
                    }
                }
            },
    },
    computed:{
        courseType () {
            var type = (this.typefour || this.typethree || this.typetwo || this.typeone);
            return type ? type.category_id :null;
        }
    },
}
</script>
<style scoped>
.expound{
    font-size: 12px;
    color:#999999;
    display: inline-block;
    line-height: 20px;
    margin-top: 10px;
}
.select{
    width: 150px;
    margin-right: 10px;
}

.s-hd{
    font-size:16px;
    color:#333;
    font-weight:bold;
    border-bottom:1px solid #f5f5f5;
    padding-bottom:20px;
    margin-bottom:20px;
}


.el-input{
    width:400px;
}

.form-line{
    margin-bottom:22px;
}

</style>
