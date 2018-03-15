<template>
    <div>
        <el-form :model="ruleForm" ref="ruleForm" label-width="130px" class="demo-ruleForm">

            <section class="form-grp">
                <div class="s-bd">
                    <el-form-item :label="$t('createCourse.chooseTeacher')" class="marginBottom">
                        <el-input readonly v-model="showdata" /><el-button class="margin blue" @click="chooseteacher">{{$t('createCourse.teacher')}}</el-button>
                        <br>
                        <span class="expound">{{$t('createCourse.teacherTip')}}</span>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.isListen')" class="marginBottom">
                        <el-checkbox v-model="is_listen" @change="listenChange">{{$t('createCourse.listen')}}</el-checkbox>
                        <span class="expound" style="margin-left:10px;">{{$t('createCourse.listenRule')}}</span>
                    </el-form-item>
                    <el-form-item :label="$t('createCourse.catalog')" required>
                        <span class="expound">{{$t('createCourse.catalogRule[0]')}}</span>
                        <p class="expound" style="margin-top: 0px">{{$t('createCourse.catalogRule[1]')}}</p><br>
                    </el-form-item>
                    <div label-width="40px" class="coursecatalog" >
                        <div v-for="item,index in catalog">
                            <!-- 每个章节的头部 -->
                            <div class="f5 listheader" style="font-size: 16px; position:relative">
                                <span style="position: absolute;left: 20px">{{$t('createCourse.whichSection',{msg:(index+1)})}}</span>
                                <span style="position: absolute;left: 100px">{{item.title}}</span>
                                <div v-show="catalog[index].state">
                                    <el-input v-model="catalog[index].editItem.title" :maxlength="40"/>
                                    <span @click="savesectionname(index)" style="margin-left:120px" class="cursor">{{$t('createCourse.save')}}</span>
                                    <span @click="cancelsectionname(index)" class="cursor">{{$t('createCourse.cancel')}}</span>
                                </div>
                                <div v-show="!catalog[index].state" :class="{disable:item.disable}">
                                    <span @click="changesectionname(index,item.disable)" class="cursor">{{$t('createCourse.modify')}}</span>
                                    <span @click="deletesection(index,item.disable)" class="cursor">{{$t('createCourse.delete')}}</span>
                                </div>
                                <span>{{$t('createCourse.totalCourse',{msg:(item._child.length)})}}</span>
                            </div>
                            <!-- 每个章节里面的课时 -->
                            <ul class="listcontent">
                                <li v-for="items,indexs in item._child" style="vertical-align: middle" >
                                    <span :class="items.class_type-1?'liveitem':'courseitem'">{{ course_type[items.class_type-1] + items.title }}</span>
                                    <div :class="{disable:items.disable}" style="height: 16px;">
                                        <span  class="time" v-show="items.class_type == 2" >{{showTime(items.live_dt,1)}}</span>
                                        <span  class="time" v-show="items.class_type == 2" >{{items.fake_start}}</span>
                                        <span  class="time" v-show="typeof items.fake_start == 'string' && items.fake_start !== ''">~</span>
                                        <span  class="time" v-show="items.class_type == 2" >{{items.fake_end}}</span>
                                        <span  class="time" v-show="items.class_type == 2" >{{findteacher(items.teacher_id)}}</span>
                                        <span @click="up(index,indexs,items.disable,item)" class="cursor hide" v-show="item._child.length-1 == indexs">{{$t('createCourse.up')}}</span>
                                        <span @click="down(index,indexs,items.disable)" class="cursor hide" v-show="!(item._child.length-1 == indexs)">{{$t('createCourse.down')}}</span>
                                        <span @click="changecoursename(index,indexs,items.disable)" class="cursor hide">{{$t('createCourse.modify')}}</span>
                                        <span @click="deletecourse(index,indexs,items.disable)" class="cursor hide">{{$t('createCourse.delete')}}</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="newitem">
                                <span class="largemargin cursor"  @click="newcourse(index)">{{$t('createCourse.addCourse')}}</span>
                            </div>
                        </div>
                        <!-- 新建章节 -->
                        <div class="newitem f5">
                            <div v-show="isnewsection">
                                <span style="margin-left: 20px">{{$t('createCourse.whichSection',{msg:(catalog.length+1)})}}</span>
                                <el-input v-model="newsection_name"/>
                                <span @click="addnewsection" style="margin-left: 20px" class="cursor">{{$t('createCourse.save')}}</span>
                                <span @click="canceladdsection" style="margin-left: 20px" class="cursor">{{$t('createCourse.cancel')}}</span>
                            </div>
                            <span class="margin cursor" @click="newsection">{{$t('createCourse.addSection')}}</span>
                        </div>
                    </div>
                    <div v-if="showLive">
                    <el-form-item :label="$t('createCourse.liveTimeSet')" class="marginTop" required>
                        <span class="expound">{{$t('createCourse.liveTip')}}</span>
                    </el-form-item>
                    <div label-width="40px" class="coursecatalog" >
                        <div class="f5 listheader" style="font-size: 16px; position:relative">
                            <span style="position: absolute;left: 20px">{{$t('createCourse.liveList')}}</span>
                            <span style="position: absolute;left: 210px">{{$t('createCourse.liveTime')}}</span>
                            <span style="position: absolute;left: 640px;color: #333">{{$t('createCourse.liveTeacher')}}</span>
                        </div>
                        <ul v-for="item , index in catalog">
                            <li v-for="items ,indexs in item._child" v-if="items.class_type == 2" :class="[serial(index,indexs) % 2 == 1?'':'linecolor','line60']">
                                <span class="live-title">{{serial(index,indexs) +'. '+items.title}}</span>
                                <el-date-picker
                                  style="width: 125px;position: absolute;left: 270px;"
                                  :disabled="items.disable"
                                  v-model="items.live_dt"
                                  type="date"
                                  :placeholder="$t('createCourse.deadline_PH')"
                                  :picker-options="pickerOptions">
                                </el-date-picker>
                                <el-time-select
                                    style="width: 105px;position: absolute;left: 400px;"
                                    :placeholder="$t('createCourse.startTime')"
                                    :editable="false"
                                    :disabled="items.disable"
                                    v-model="items.fake_start"
                                    @change="change_start(index,indexs)"
                                    :picker-options="{
                                      start: '09:00',
                                      step: '00:30',
                                      end: '22:30'
                                    }">
                                  </el-time-select>
                                  <span style="position: absolute;left: 510px;">{{$t('createCourse.to')}}</span>
                                  <el-time-select
                                    style="width: 105px;position: absolute;left: 525px;"
                                    :editable="false"
                                    :disabled="items.disable"
                                    :readonly="!items.fake_start"
                                    :placeholder="$t('createCourse.endTime')"
                                    v-model="items.fake_end"
                                    :picker-options="{
                                      start: items.fake_start,
                                      step: '00:30',
                                      end: endDate(items.fake_start),
                                      minTime: items.fake_start,
                                      maxTime: '23:30'
                                    }">
                                  </el-time-select>
                                <el-select clearable v-model="items.teacher_id" :placeholder="$t('createCourse.catagory_PH')"  value-key="items.teacher_id" style="width: 105px;position: absolute;left: 700px;" :disabled="items.disable">
                                    <el-option :label="item.name" :value="item.id" v-for="item in teacher_Live" :key="item.id"></el-option>
                                </el-select>
                            </li>
                        </ul>
                    </div>
                    </div>
                    <!-- 新增视频的弹出modal框 通过which来判断是选择的是老师还是视频 -->
                    <el-dialog
                          :title="title[which]"
                          :visible.sync="ismodalshow"
                           custom-class="w-dialog w-dialog-regular"
                           size="tiny"
                           :show-close="false"
                           :close-on-click-modal="false"
                           :close-on-press-escape="false">
                          <el-transfer
                            v-show="istransfershow"
                            class="margin w-transfer "
                            filterable
                            :titles="titles"
                            :filter-placeholder="$t('createCourse.filter')"
                            :button-texts="[ this.$t('createCourse.delete'),this.$t('createCourse.add')]"
                            v-model="choosedata"
                            :data="teacherdata">
                          </el-transfer>
                          <!-- 选择视频的时候 弹出级联框 -->
                          <div v-show="!istransfershow">
                                <el-form-item :label="$t('createCourse.periodType')" style="line-height: 60px" required>
                                    <el-select v-model="isLiving" :placeholder="$t('createCourse.catagory_PH')">
                                        <el-option :value="0" :label="$t('createCourse.courseType[0]')">{{$t('createCourse.courseType[0]')}}</el-option>
                                        <el-option :value="1" :label="$t('createCourse.courseType[1]')">{{$t('createCourse.courseType[1]')}}</el-option>
                                    </el-select>
                                </el-form-item>
                                <el-form-item :label="$t('createCourse.periodName')" style="line-height: 60px;margin-top: 30px;" required>
                                    <el-input class="width220" v-model="course_name" :placeholder="$t('createCourse.periodName_PH')" :maxlength="20"/>
                                </el-form-item>
                                <el-form-item :label="$t('createCourse.chooseVideo')" style="line-height: 60px;margin-top: 30px;" required v-show="isLiving">
                                    <el-cascader
                                    filterable
                                    :options="videodata"
                                    v-model="selectedOptions"
                                    class="width220"
                                    :placeholder="$t('createCourse.chooseVideo_PH')"
                                    >
                                    </el-cascader>
                                    <div style="float: right;margin-right: 30px;margin-top: 5px; line-height:20px;">
                                        {{$t('createCourse.linkToVideo[0]')}}<span class="Upload" @click="upload">{{$t('createCourse.linkToVideo[1]')}}</span>
                                    </div>
                                </el-form-item>
                          </div>
                          <span slot="footer" class="dialog-footer">
                            <el-button @click="cancel(which)">{{$t('createCourse.cancel')}}</el-button>
                            <el-button type="primary" @click="sure(which)">{{$t('createCourse.confirm')}}</el-button>
                          </span>
                    </el-dialog>
                </div>

            </section>
        </el-form>
    </div>
</template>
<script>
import api from '@/js/api/createCourse'
export default {
    mounted(){
        this.getTeacher();
        this.getVideo();
    },
    activated(){
        if(this.initData && !this.isfirst){
            this.sendMsg(this.catalog);
        }
    },
    props:{
         initData: {}
    },
    data() {
        return {
            ruleForm: {
                teacher:[],//老师的id
                is_listen:false,//有无试听课 1为有 2为无
                catalog:[],//课程目录
            },
            course_type:this.$t('createCourse.course_type'),
            isLiving: '',
            isfirst:true,
            isnewsection: false,//下方新建一节的按钮是否显示
            ismodalshow: false,//选择modal框显示或隐藏
            newsection_name: '',//新建一节的名称
            istransfershow:true ,//判断当前显示的是选择老师还是选择视频
            which:0,//目前选择的是哪个   如果0则是老师  1就是视频
            title:[this.$t('createCourse.transferTitle2[0]'),this.$t('createCourse.transferTitle2[1]')],
            titles:[this.$t('createCourse.transferTitle2[2]'), this.$t('createCourse.transferTitle2[3]')],
            teacherdata:[] ,//获取到的老师
            choosedata:[] ,//当前选择的老师
            showdata:'' ,//当前显示的老师
            videodata:[] ,//当前获取到的视频
            selectedOptions:[] ,//当前选择的视频
            cache:[] ,//在取消的时候缓存数据
            which_section:'',//点击添加视频按钮时  是在哪一个章节点击的
            ischangecourse:false,
            changewhichcourse:'',//改变的是哪一个课程
            is_listen:false,
            course_name:'',
            course_id:'',
            catalog:[],
            isfree:'',
            pickerOptions: {
              disabledDate(time) {
                return time.getTime() < Date.now() - 8.64e7;
              }
            },
        }
    },
    computed:{
        teacher_Live() {//下方直播的老师为当前选中的老师
            let arrId = [];
            this.choosedata.forEach((id)=>{
                this.teacherdata.find((item) => {
                    if(item.id == id) {
                        arrId.push(item)
                    }
                })
            })
            return arrId;
        },
        showLive() {
            let exist = false;
            this.catalog.forEach((item)=>{
                item._child.forEach((items)=>{
                    if(items.class_type == 2) {
                        exist = true;
                    }
                })
            });
            return exist;
        },

    },
    watch:{


    },
    methods: {
        serial(index,indexs) {
            let arr = [];
            let serialNum = '';
            this.catalog.forEach((item,a)=>{
                item._child.forEach((items,b)=>{
                    if(items.class_type == 2) arr.push({sec:a,num:b})
                })
            })
            arr.forEach((value,arrindex)=>{
                if(value.sec == index && value.num == indexs ) serialNum = arrindex
            })
            return serialNum+1;
        },
        set_teacher() {
            let arr = [];
            let isDelete = false;
            this.catalog.forEach((item)=>{
                item._child.forEach((items)=>{
                    if(items.class_type == 2 && items.teacher_id != '') arr.push(items.teacher_id)
                })
            })
            let setArr = new Set(arr)
            arr.forEach((item)=>{
                if(!this.choosedata.includes(item)) isDelete = true;
            })
            if (setArr.size == 0) isDelete = false;
            return isDelete;
        },
        change_start(index,indexs) {
            this.catalog[index]._child[indexs].fake_end = '';//开始时间切换的时候 结束时间清空
        },
        showTime(time,type,hours){
            let nowtime = new Date(time)
            if(!time) return
            if (type == 1) return nowtime.getFullYear() + this.$t('createCourse.year') + (nowtime.getMonth()+1) + this.$t('createCourse.month') + nowtime.getDate() +this.$t('createCourse.day');
            if (type == 2) return nowtime.getFullYear() + '-' + (nowtime.getMonth()+1) + '-' + nowtime.getDate() ;
        },
        endDate(time) {
            if(!time) return
            return Number(time.split(':')[0]) >= 21 && Number(time.split(':')[1]) >= 30 ? '23:30' :Number(time.split(':')[0]) + 2 + ':' + time.split(':')[1];
        },
        sendMsg(data){
            this.$emit('listenChild',{teacher:this.choosedata,is_listen:this.is_listen == false? 2:1,catalog:data||this.catalog});
            this.isfirst = false;
        },
        getTeacher(){
            api.getTeacher().then(res =>{
                this.teacherdata = res.data.data;
            }).then(()=>{
                if(this.initData){
                    if(this.initData.is_listen != 2){
                        this.is_listen = true ;
                    }
                    if(this.initData.teacher.length){
                        this.initData.teacher.forEach((val)=>{
                            this.choosedata.push(parseFloat(val));
                            this.sure(0);
                        })
                    }
                    if(this.initData.catalog.length){
                        this.initData.catalog.forEach((item)=>{
                            if(item.state == 0){
                                item.state = false;
                            }else{
                                item.state = true;
                            }
                            item._child.forEach((items)=>{
                                if(items.class_type == 2){
                                    items.teacher_id = Number(items.teacher_id);
                                }
                            })
                        })
                        this.catalog = this.initData.catalog;
                        console.log(this.catalog)
                    }
                    if(this.isfirst){
                            this.sendMsg(this.initData.catalog);
                    }
                }
            });
        },
        getVideo(){
            api.getVideo().then(res =>{
                this.videodata = res.data.data;
            });
        },
        chooseteacher(){
            // 选择老师
            this.istransfershow = true ;
            this.ismodalshow = true ;
            this.which = 0 ;
        },
        cancel(which){
            this.ismodalshow = false ;
            if(which == 0){
                this.choosedata = this.cache;
            }else if(which == 1){
                // 当在添加课时的时候取消
                this.selectedOptions = [];
                this.course_name = '';
                this.isLiving = '';
            }

        },
        sure(which){
            if(which == 0){
                //选择老师
                if(this.set_teacher()) {
                    this.$message.error(this.$t('createCourse.errorTeacher'))
                } else{
                    var str = '';
                    this.cache = this.choosedata.map(value=>value);
                    str = this.teacherdata.filter((item) =>{
                        if (this.choosedata.indexOf(item.key) > -1) {
                            return true;
                        }
                    }).map(item => item.label).join(',');
                    this.showdata = str;
                    this.ismodalshow = false ;
                }

            }else if(which == 1 ){
                // 创建或者修改课时
                if(!this.selectedOptions[1] && this.isLiving){
                    this.$message.error(this.$t('createCourse.errorPeriod[0]'))
                }else if(!this.course_name || /^\s+$/.test(this.course_name)){
                    this.$message.error(this.$t('createCourse.errorPeriod[1]'))
                }else if ( this.isLiving === '') {
                    this.$message.error(this.$t('createCourse.errorPeriod[2]'))
                }else if ( this.isFirst() ) {
                    this.$message.error(this.$t('createCourse.errorPeriod[3]'))
                }else{
                    this.course_id = this.selectedOptions[1];
                    if(this.ischangecourse){
                        if(this.isLiving) {
                            this.catalog[this.changewhichcourse[0]]._child.splice(this.changewhichcourse[1],1,{
                                title:this.course_name,
                                media_id:this.course_id,
                                class_type:1
                            });
                        } else {//直播课程
                            let now = this.catalog[this.changewhichcourse[0]]._child[this.changewhichcourse[1]];
                            if(now.class_type == 2 ) {
                                this.catalog[this.changewhichcourse[0]]._child[this.changewhichcourse[1]].title = this.course_name;
                            }else {
                                this.catalog[this.changewhichcourse[0]]._child.splice(this.changewhichcourse[1],1,{
                                    title: this.course_name,
                                    class_type: 2,
                                    fake_start: '',
                                    fake_end: '',
                                    start_time: '',
                                    end_time: '',
                                    teacher_id: '',
                                    live_dt: '',
                                });
                            }
                        }

                    }else{
                        if(this.isLiving){
                            this.catalog[this.which_section]._child.push({
                                title:this.course_name,
                                media_id:this.course_id,
                                class_type:1
                            })
                        } else {//直播课程
                            this.catalog[this.which_section]._child.push({
                                title: this.course_name,
                                class_type: 2,
                                fake_start: '',
                                fake_end: '',
                                start_time: '',
                                end_time: '',
                                teacher_id: '',
                                live_dt: '',
                            });
                        }
                    }
                    this.course_name = '';
                    this.selectedOptions = [];
                    this.isLiving = '';
                    this.course_id = '';
                    this.ismodalshow = false ;
                }
            }
        },
        findname(id){
            let a ;
            this.videodata.forEach((item)=>{
                item.children.filter((item1)=>{
                    if(item1.value == id){
                        a = item.value ;
                    }
                })
            })
            return a;
        },
        findteacher(id){
            let a ;
            this.teacherdata.forEach((item)=>{
                if(item.id == id){
                    a = item.name;
                }
            })
            return a;
        },
        newsection(){
            // 新建一节
            this.isnewsection = true;
        },
        canceladdsection(){
            // 取消新建一节
            this.isnewsection = false;
            this.newsection_name='';
        },
        addnewsection(){
            // 确认新建一节
            if(/^\s+$/.test(this.newsection_name) || !this.newsection_name){
                this.$message.error(this.$t('createCourse.errorPeriod[4]'))
            } else {
                this.isnewsection = false;
                let title = this.newsection_name;
                this.catalog.push({
                    title,
                    state:false,
                    _child:[],
                    editItem:{
                        title,
                    }
                })
                this.newsection_name='';
            }
        },
        newcourse(index,disable){
                if(this.catalog[index]._child.length >= 50){
                    this.$message.error(this.$t('createCourse.errorPeriod[7]'))
                }else{
                    this.ismodalshow = true;
                    this.istransfershow = false;
                    this.ischangecourse =false;
                    this.which = 1;
                    this.which_section = index;
                }
        },
        up(index,indexs,disable,item){
            if(item._child[indexs-1] && (!!disable == false && item._child[indexs-1].disable != true)){
                this.catalog[index]._child.splice(indexs-1,2,this.catalog[index]._child[indexs],this.catalog[index]._child[indexs-1]);
            }
        },
        down(index,indexs,disable){
            if(!disable){
                if(indexs != this.catalog[index]._child.length-1){
                    this.catalog[index]._child.splice(indexs,2,this.catalog[index]._child[indexs+1],this.catalog[index]._child[indexs]);
                }
            }
        },
        deletecourse(index,indexs,disable){
            if(!disable){
                let type = this.catalog[index]._child[indexs].class_type;
                this.catalog[index]._child.splice(indexs,1,);
            }
        },
        deletesection(index,disable){
            if(!disable){
                this.catalog.splice(index,1,)
            }
        },
        changecoursename(index,indexs,disable){
            if(!disable){
                this.ismodalshow = true;
                this.which = 1;
                this.istransfershow = false;
                this.ischangecourse = true;
                this.changewhichcourse = [index,indexs] ;
                this.course_name = this.catalog[this.changewhichcourse[0]]._child[this.changewhichcourse[1]].title;
                this.course_id = this.catalog[this.changewhichcourse[0]]._child[this.changewhichcourse[1]].media_id || '';
                this.selectedOptions = [this.findname(this.course_id),parseInt(this.course_id)];
                this.catalog[this.changewhichcourse[0]]._child[this.changewhichcourse[1]].class_type == 1 ?this.isLiving = 1: this.isLiving = 0;
            }
        },
        changesectionname(id,disable){
            if(!disable){
                this.catalog[id].state = true ;
            }
        },
        savesectionname(id){
            if(/^\s+$/.test(this.catalog[id].editItem.title) || !this.catalog[id].editItem.title){
                this.$message.error(this.$t('createCourse.errorPeriod[4]'))
            } else {
                this.catalog[id].state = false ;
                this.catalog[id].title = this.catalog[id].editItem.title ;
            }
        },
        cancelsectionname(id){
            this.catalog[id].state = false ;
            this.catalog[id].editItem.title = this.catalog[id].title;
        },
        submitForm(courseid){
            if(courseid){
                this.ruleForm.courseid = courseid;
            }
            let isSaved = true;
            this.ruleForm.teacher = this.choosedata ;
            this.ruleForm.is_listen = this.is_listen == false? 2:1 ;
            this.catalog.forEach((item)=>{
                item._child.forEach((items)=>{
                    if(items.class_type == 2){
                        items.live_dt = this.showTime(items.live_dt,2);
                        items.start_time = items.live_dt + ' ' + items.fake_start;
                        items.end_time = items.live_dt + ' ' + items.fake_end;
                    }
                })
            })
            this.ruleForm.catalog = this.catalog ;
            this.catalog.forEach((item)=>{
                if(item.state) isSaved = false
            })

            if(this.catalog.length != 0 && isSaved){
                return new Promise((resolve, reject) => {
                    this.$refs['ruleForm'].validate(valid => {
                        if (valid) {
                            return api.step4_mes(this.ruleForm).then(resolve, reject);
                        }
                        return reject();
                    })
                 })
            } else if (!isSaved){
                this.$message.error(this.$t('createCourse.errorPeriod[5]'));
            } else {
                this.$message.error(this.$t('createCourse.errorPeriod[6]'));
            }
        },
        upload(){
            var upload = window.open('');
            upload.location = window.location.pathname+'#/course/video';
        },
        isFirst() {
            if (this.is_listen &&((!this.catalog[0]._child[0] && !this.isLiving)|| (this.changewhichcourse[0] == 0 && this.changewhichcourse[1] == 0 && !this.isLiving))) {
                return true
            }
        },
        listenChange() {
            if(this.catalog[0]) {
                if(this.catalog[0]._child[0]) {
                    if(this.catalog[0]._child[0].class_type == 2 ) {
                        this.$message.error(this.$t('createCourse.errorPeriod[3]'))
                        this.is_listen = false;
                    }
                }
            }

        }
    },
}
</script>
<style scoped>
*{
    margin:0;
}
ul{
    list-style: none;
}
li{
    font-size: 12px;
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
.live-title{
    line-height: 24px;
    padding-top: 5px;
    margin-left: 20px;
    width: 160px;
    word-wrap: break-word;
    display: inline-block;
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
    line-height:12px
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
.marginright{
    margin-right: 20px;
}
.marginBottom{
    margin-bottom: 30px;
}
.marginTop{
    margin-top: 50px;
}
.largemargin{
    margin-left:100px;
}
.expoundbackgroud{
    background:#f5f5f5;
}
.coursecatalog{
    width: 758px;
    border:1px solid #d9d9d9;
    border-radius: 3px ;
    margin-left: 60px;
}
.listheader{
    height: 50px;
    line-height: 50px;
}
.listheader::after{
    clear:both;
    content:'';
    display:block;
}
.listheader div:nth-of-type(1){
    left: 100px;
    float: left;
}
.listheader div span{
    margin-right: 15px;
    color:#4098ff;
}
.listheader div:nth-of-type(2){
    position: absolute;
    display: none;
    left: 570px;
    top: 0;
}
.listcontent div {
    float: right;
    margin-right: 20px;
}
.listcontent div .time{
    color:#999;
    margin-right: 10px;
}
.listcontent div .hide{
    display: none;
}
.listheader:hover>div,.listcontent>li:hover div .hide{
    display: inline-block;
}
.listcontent>li:hover div .time{
    display: none;
}
.listheader>span:last-of-type{
    float: right;
    margin-right: 10px;
    color:#999999;
}
.listcontent{
    margin: 0 0 0 100px ;
    line-height:30px;
}
.listcontent span{
    margin-right: 20px;
    color:#268fff;
}
.newitem{
    font-size: 16px;
    color: #268fff;
    line-height: 50px;
}
.f5{
    background-color: #f5f5f5;
}
.shadow{
    position: absolute;
    width: 160px;
    height: 90px;
    background:rgba(0,0,0,.7);
    left: 0;top: 0;
    text-align: center;
    line-height:90px;
    display: none;
    color: #fff;
}
.shadow span{
    cursor: pointer;
}
.width220{
    width: 220px;
}
.courseitem{
    background: url('../../assets/images/videoIcon03.png') no-repeat;
    background-position:left center ;
    padding-left:14px;
    font-size: 14px;
    color: #333333 !important;
}
.liveitem{
    background: url('../../assets/images/videoIcon04.png') no-repeat;
    background-position:left center ;
    padding-left:14px;
    font-size: 14px;
    color: #333333 !important;
}
.cursor{
    cursor: pointer;
}
.disable span{
    color:#999999 !important;
    cursor: not-allowed;
}
.addVideo{
    position: absolute;
    left: 131px;
    top: 313px;
    color:#999999;
    font-size: 14px;
    background: #fff;
    z-index: 20000;
    height: 50px;
    width: 161px;
    line-height: 18px;
    padding: 5px  ;
    text-align: left;
}
.Upload{
    color:#268fff;
    cursor: pointer;
}
.line60{
    line-height: 60px;
    height: 60px;
    overflow: hidden;
}
.linecolor{
    background-color: #f9f9f9;
}
</style>
