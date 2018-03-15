<template>
    <div>
        <el-form :model="ruleForm" ref="ruleForm" :rules="rules" label-width="130px" class="demo-ruleForm">

            <section class="form-grp">
                <div class="s-hd">
                    {{$t('createCourse.marketSet')}}
                </div>
                <div class="s-bd">
                    <el-form-item :label="$t('createCourse.relateData')">
                        <el-input readonly v-model="showdata[0]"></el-input><el-button class="margin blue" @click="choosefile">{{$t('createCourse.chooseData')}}</el-button>
                        <p class="expound">{{$t('createCourse.dataTip')}}</p>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.relateCourse')">
                        <el-input readonly v-model="showdata[1]"></el-input><el-button class="margin blue" @click="choosecourse">{{$t('createCourse.chooseCourse')}}</el-button>
                        <p class="expound">{{$t('createCourse.courseTip')}}</p>
                    </el-form-item>
                </div>
                <div class="s-hd">
                    {{$t('createCourse.consultService')}}
                </div>
                    <el-form-item label-width="0">
                        <el-checkbox v-model="ruleForm.consult_service" style="float: left">{{$t('createCourse.provideService')}}</el-checkbox>
                        <span class="expound margin" style="float: left;width: 600px;line-height: 20px;margin-top: 10px;display: inline-block">{{$t('createCourse.consultRule')}}</span>
                    </el-form-item>
                    <el-form-item v-if="ruleForm.consult_service" :label="$t('createCourse.serviceAccount')" prop="course_isfree">
                        <el-input :placeholder="$t('createCourse.serviceAccount_PH')" v-model="postdata.service_no" style="width: 480px;"></el-input>
                        <br><p class="expound" style="line-height: 20px;width: 500px;">{{$t('createCourse.serviceAccountTip')}}</p>
                    </el-form-item>
                    <el-dialog
                          :title="title[which]"
                          :visible.sync="ruleForm.ismodalshow"
                          size="tiny"
                          custom-class="w-dialog-regular w-dialog"
                          >
                          <el-transfer
                            class="margin  w-transfer"
                            filterable
                            :titles="titles[which]"
                            :filter-placeholder="$t('createCourse.filter')"
                            :button-texts="[ $t('createCourse.delete'),$t('createCourse.add')]"
                            v-model="choosedata[which]"
                            :data="data[which]">
                          </el-transfer>
                          <div class="warning">
                              <i class="el-icon-warning" style="color:#268fff"></i>
                              {{warning_word[which]}}
                          </div>
                          <span slot="footer" class="dialog-footer">
                            <el-button @click="cancel(which)">{{$t('createCourse.cancel')}}</el-button>
                            <el-button type="primary" @click="sure(which)">{{$t('createCourse.confirm')}}</el-button>
                          </span>
                    </el-dialog>
            </section>
        </el-form>
    </div>
</template>
<script>
import api from '@/js/api/createCourse'
export default {
    props:{
         initData: {}
    },
    mounted(){
        this.getFile();
        this.getCourse();
    },
    activated(){
            this.sendMsg();
    },
    data() {
        var form = {
                ismodalshow: false,//modal框是否显示
                consult_service: false,//是否提供咨询服务  提供服务时 展现服务账号关联栏
            };
        return {
            count:0,
            ruleForm: form,
            isfirst:true,
            which:0,//目前弹出框显示的内容是哪一个
            postdata:{
                material:[] ,//选中的资料的ID
                course:[] ,//选中的课程的ID
                service_no:'' ,//服务账号的链接
            } ,
            rules:{
                course_isfree:[
                    {   required:true,
                        validator:(rule,value,callback)=>{
                            if(value){

                            }else{
                                callback(this.$t('createCourse.serviceAccount_WA'))
                            }
                        },
                        trigger:'blur'}
                ]
            },
            data:[],//存储获取到的数据
            choosedata:[[],[]],//存储选取到的数据
            showdata:['',''],//存储显现的字符串,
            cache:[[],[]],//用户在选择时点取消，则调用缓存里面的数据
            title:[this.$t('createCourse.chooseData'),this.$t('createCourse.chooseCourse')],
            warning_word:[this.$t('createCourse.limitAmount[0]'),this.$t('createCourse.limitAmount[1]')],
            limit:[50,5],
            titles:[[this.$t('createCourse.transferTitle[0]'),this.$t('createCourse.transferTitle[1]')],[this.$t('createCourse.transferTitle[2]'), this.$t('createCourse.transferTitle[3]')]]
        }
    },
    methods: {
        sendMsg(){
            if(this.initData){
                let copy = {};
                if(this.isfirst){
                    copy.material = this.initData.material;
                    copy.course = this.initData.course;
                }else{
                    copy.material = this.choosedata[0];
                    copy.course = this.choosedata[1];
                }
                if(!this.ruleForm.consult_service){
                    copy.service_no = '' ;
                }else{
                    copy.service_no = this.postdata.service_no.trim()
                }
                this.$emit('listenChild',copy)
                this.isfirst = false;
            }
            
        },
        getFile() { //获取上传资料列表数据
                api.getFile().then(res => {
                        this.data[0] = res.data.data.list
                }).then(()=>{
                    if(this.initData){
                        this.initData.material.forEach((val)=>{
                            this.choosedata[0].push(parseFloat(val))
                        });
                        this.sure(0);
                        if(this.initData.service_no){
                             console.log(2)
                            this.ruleForm.consult_service = true;
                            this.postdata.service_no = this.initData.service_no;
                        }
                    }
                }).then(()=>{
                    this.count++;console.log(1)
                    if(this.count ==2){
                        this.sendMsg();
                    }
                })
        },
        getCourse() { //获取上传资料列表数据
                api.getCourse().then(res => {
                    this.data[1] = res.data.data.list
                }).then(()=>{
                    if(this.initData){
                        this.initData.course.forEach((val)=>{
                            this.choosedata[1].push(parseFloat(val))
                        });;
                        this.sure(1);
                    }
                }).then(()=>{
                    this.count++;
                    if(this.count ==2){
                        this.sendMsg();
                    }
                })
        },
        choosefile(){
            this.ruleForm.ismodalshow = true;
            this.which = 0 ;
        },
        choosecourse(){
            this.ruleForm.ismodalshow = true;
            this.which = 1;
        },
        cancel(which){
            this.ruleForm.ismodalshow = false;
            this.choosedata[which] = this.cache[which];
        },
        sure(which){
            if(this.choosedata[which].length>this.limit[which]){
                console.log(which)
                this.$message.error(this.$t(createCourse.overRange));
            }else{
                this.ruleForm.ismodalshow = false;
                var str = '';
                this.cache[which] = this.choosedata[which].map(value=>value);
                str = this.data[which].filter((item) =>{
                    if (this.choosedata[which].indexOf(item.key) > -1) {
                        return true;
                    }
                }).map(item => item.label).join(',');
                this.showdata[which] = str;
            }
        },
        submitForm(courseid){
            if(courseid){
                this.postdata.courseid = courseid;
            };
            this.choosedata[0].forEach(value=>{
                this.postdata.material.push(value);
            });
            this.choosedata[1].forEach(value=>{
                this.postdata.course.push(value);
            });
            if(!this.ruleForm.consult_service){
                this.postdata.service_no = '' ;
                    return api.step3_mes(this.postdata);
            }else{
                if(this.postdata.service_no.trim()){
                    return api.step3_mes(this.postdata);
                }else{
                    this.$message.error(this.$t(createCourse.serviceAccount_WA))
                }
            }
        },
    }
}
</script>
<style scoped>
*{
    margin:0;
}
.select{
    width: 180px;
    margin-right: 10px;
}
.blue{
    color:#4098ff;
    cursor: pointer;
    border-color: #4098ff;
}
.s-hd{
    font-size:16px;
    color:#333;
    font-weight:bold;
    border-bottom:1px solid #f5f5f5;
    padding-bottom:20px;
    margin-bottom:20px;
}
.expound{
    color:#999999;
    font-size: 12px;
}
.el-input{
    width:400px;
}

.form-line{
    margin-bottom:22px;
}
.margin{
    margin: 0 20px;
}
.expoundbackgroud{
    background:#f5f5f5;
}
.warning{
    margin-top: 10px;
    margin-left: 40px;
    line-height: 14px;
    font-size: 12px;
    text-align: left;
}

</style>

