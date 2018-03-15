<template>
    <div class="consultation-wrap">
        <h2 class="title pt-0">{{ $t('marketing.about.intro.title')}}<span>{{ $t('marketing.about.intro.tips')}}</span></h2>
        <div class="cont">
            <div id="editorElem">
            </div>
            <h2 class="title">{{ $t('marketing.about.history.title')}}</h2>
            <el-form label-width="80px" class="w-demo-form" :model="formdata" ref="formdata">
                <div v-for="(item,index) in formdata.courseList" :key="item.key" class="clearfix p-relative formdatalist" >
                    <div class="introduce">
                        <el-form-item :label="$t('marketing.about.history.dete')">
                            <el-form-item>
                                <el-date-picker
                                    popper-class="w-date-picker-popper"
                                    v-model="item.date_time"
                                    type="month"
                                    :placeholder="$t('marketing.about.history.dete_placeholder')"
                                    :editable="false"
                                    @change="(value) => changeHandler(value,index)">
                                </el-date-picker>
                            </el-form-item>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.about.history.des')" :key="item.key" :prop="'courseList.' + index + '.desc'" :rules="[{ min: 0, max: 50, message: $t('marketing.about.history.filter[0]'), trigger: 'blur' }] ">
                            <el-input class="w-textarea" :placeholder="$t('marketing.about.history.filter[0]')" :rows="3" type="textarea" v-model="item.desc"></el-input>
                        </el-form-item>
                    </div>
                    <div class="edit-cont">
                        <el-button type="text" :disabled="index==0?move_isdisabled:!move_isdisabled" @click="moveUp(index,formdata.courseList)">{{$t('marketing.globle.move[0]')}}</el-button>
                        <el-button type="text" :disabled="index==formdata.courseList.length-1?move_isdisabled:!move_isdisabled" @click="moveDown(index,formdata.courseList)">{{$t('marketing.globle.move[1]')}}</el-button>
                        <el-button type="text" :disabled="formdata.courseList.length==1?move_isdisabled:!move_isdisabled" @click="deleteList(index)">{{$t('marketing.globle.move[2]')}}</el-button>
                    </div>
                </div>
                <el-button @click="addFomart" class="w-button">{{ $t('marketing.about.history.add')}}</el-button>
                <el-row type="flex" class="row-bg" justify="center">
                    <el-col :span="4"><el-button class="fl-r-m15" @click="previewData()">{{$t('common.btn.preview')}}</el-button></el-col>
                    <el-col :span="4"><el-button type="primary" @click="onSubmit()">&nbsp;{{$t('common.btn.submit')}}&nbsp;</el-button></el-col>
                </el-row>
            </el-form>
        </div>
    </div>
</template>
<script type="es6">
    import WangEditor from 'wangeditor';
    import Vue from 'vue'
    import movePosition from '@/js/mixin/movePositionMixin'
    import * as api from '@/js/api'
    export default {
        mixins: [movePosition],
        name: 'aboutus',
        data(){
            return {
                dataInterface: {
                    editorUpImgUrl: '/api/universal/uploadimage'  // 编辑器插入的图片上传地址
                },
                formdata: {
                    editorContent: "",
                    courseList: [{
                        year: "",
                        month: "",
                        date_time: "",
                        desc: "",
                        key: Date.now(),
                    }]
                },
                editor: "",
                move_isdisabled: true,
                add_isdisabled: false,
            }
        },
        methods: {
            getData(){
                api.personSetting.getAboutus().then(res => {
                    let data = res.data;
                    if (res.status == 200) {
                        this.formdata.editorContent = data.editorContent;
                        if (data.courseList.length > 0) {
                            this.formdata.courseList = data.courseList.concat()
                        }
                        this.editor.txt.html(this.formdata.editorContent);
                    } else {
                        this.$message.error(res.msg)
                    }
                })
            },
            changeHandler(val, i){
                let dataArr = [];
                dataArr = val.split("-");
                this.formdata.courseList[i].date_time = val
                this.formdata.courseList[i].year = dataArr[0];
                this.formdata.courseList[i].month = dataArr[1]
            },
            deleteList(id){
                if (this.formdata.courseList.length > 1) {
                    this.formdata.courseList.splice(id, 1)
                }
            },
            defaultData(){
                return {year: "", month: "", desc: "", date_time: "", key: Date.now()};
            },
            addFomart(){
                this.formdata.courseList.push(this.defaultData());
            },
            onSubmit() {
                this.formdata.editorContent = this.editor.txt.html();
                api.personSetting.saveAboutus(this.formdata).then(res=> {

                    if (res.status == 200) {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                    } else {
                        this.$message.error(res.msg)
                    }
                });
            },
            initEditorConfig(){
                //this.editor.customConfig.showLinkImg = false//网络图片
                this.editor.customConfig.uploadImgShowBase64 = false;
                this.editor.customConfig.uploadImgServer = this.dataInterface.editorUpImgUrl;
                this.editor.customConfig.uploadFileName = 'image'
                this.editor.customConfig.zIndex = 100;
                this.editor.customConfig.uploadImgHooks = {
                    customInsert: function (insertImg, result, editor) {
                        var url = result.data.url
                        insertImg(url)
                    }
                }
            },
            previewData(){//预览
                let w = window.open();
                api.personSetting.preview("/api/institute/aboutuspreview", this.formdata).then(res => {
                    if (res.status == 200) {
                        w.location = `http://${res.data.url}`;
                    } else {
                        w.close()
                        this.$message.error(res.msg)
                    }
                })
            }
        },
        mounted() {
            this.editor = new WangEditor('#editorElem');
            this.initEditorConfig();
            this.editor.customConfig.onchange = (html) => {
                this.formdata.editorContent = html
            }
            this.editor.create();
            this.getData();
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .fl-r-m15{
        float: right;
        margin-right: 15px
    }
    .p-relative{
        position: relative;
    }

    .consultation-wrap{
        width: 1000px;
        .title{
            font-size: 16px;
            color: #333;
            font-weight:inherit;
            padding-bottom: 25px;
            padding-top: 20px;
            margin:0;
            span{
                font-size: 12px;
                color: #999;
                display: inline-block;
                padding-left: 20px;
            }
        }
        .pt-0{
            padding-top: 0;
        }
        .cont{
            .formdatalist{
                margin-bottom:20px;
                .introduce{
                    border: 1px solid #dadada ;
                    border-radius: 4px;
                    padding: 20px;
                    width:870px;
                }
                .edit-cont{
                    width: 130px;
                    position: absolute;
                    left:889px ;
                    top: 50%;
                    margin-top: -18px;
                }
            }
        }
    }

</style>
