<template>
    <div class="discount-add-wrap">
        <el-form :model="discountAddForm" :rules="discountAddRules" ref="discountAddForm" label-width="100px" class="w-demo-form">
            <div class="cont">
                <el-dialog
                    :title="title"
                    custom-class="w-dialog w-dialog-regular"
                    :close-on-click-modal="false"
                    :visible.sync="dialogVisible"
                    :before-close="closeSelect">
                    <div class="main-cont">
                        <el-form-item  v-if="discountAddForm.course_name==''" :label="$t('marketing.discount.new_list_title[0]')" prop="course_id" required>
                            <el-select class="w-select" v-model="discountAddForm.course_id" :placeholder="$t('marketing.discount.placeholder[0]')" style="width:73%">
                                <el-option v-for="item in class_name_list" :label="item.name" :value="item.id" :key="item.id" ></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item v-else  :label="$t('marketing.discount.new_list_title[0]')" prop="course_id" required>
                            <el-select class="w-select" disabled v-model="discountAddForm.course_id" :placeholder="$t('marketing.discount.placeholder[0]')" style="width:73%">
                                <el-option :label="discountAddForm.course_name" :value="discountAddForm.course_id" :key="discountAddForm.course_id" ></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.discount.new_list_title[1]')" >
                            <p v-if="!discountAddForm.price">{{price?parseFloat(price).toFixed(2): parseFloat(0).toFixed(2) }}{{$t('marketing.globle.unit.yuan')}}</p>
                            <p v-else>{{parseFloat(discountAddForm.price).toFixed(2)}}</p>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.discount.new_list_title[2]')" prop="cur_price" required>
                            <el-col :span="8">
                                <el-input class="w-input"  v-model="discountAddForm.cur_price"  :placeholder="$t('marketing.discount.placeholder[1]')" ></el-input>
                            </el-col><el-col :span="1">&nbsp;{{$t('marketing.globle.unit.yuan')}}</el-col>
                            <el-col :span="12" :offset="1" >
                                <span class="gray-text">{{$t('marketing.discount.tips[0]')}}</span>
                            </el-col>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.discount.new_list_title[3]')" prop="all_num" :required="!discountAddForm.is_infinite" :show-message="!discountAddForm.is_infinite">
                            <el-col :span="8">
                                <el-input class="w-input" :disabled="discountAddForm.is_infinite" :placeholder="$t('marketing.discount.placeholder[2]')"  v-model.number="discountAddForm.all_num"></el-input>
                            </el-col><el-col v-if="env" :span="2">&nbsp;{{$t('marketing.globle.unit.person')}}</el-col>
                            <el-col v-else :span="1">&nbsp;{{$t('marketing.globle.unit.person')}}</el-col>
                            <el-col :span="3" :offset="1">
                                <el-checkbox class="w-checkbox-group" v-model="discountAddForm.is_infinite" @change="isInfinite"><span>{{$t('marketing.discount.person_num')}}</span></el-checkbox>
                            </el-col>
                            <span class="tips ml-5" :class="{'fl':env}">{{$t('marketing.discount.tips[1]')}}</span>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.discount.new_list_title[4]')" required>
                            <el-row :gutter="10">
                                <el-col :span="8" class="pl-0">
                                    <el-form-item prop="start_dayVal">
                                        <el-date-picker class="w-time-picker" style="width: 100%;"
                                            v-model="discountAddForm.start_dayVal"
                                            type="date"
                                            :placeholder="$t('marketing.discount.placeholder[3]')"
                                            :picker-options="startTime"
                                            :editable="false"
                                            popper-class="w-date-picker-popper"
                                            format="yyyy-MM-dd"
                                            @change="(value) => changeDateFormat(value,'start_dayVal')">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item prop="start_timeVal">
                                        <el-time-select class="w-time-picker" style="width: 100%"
                                            v-model="discountAddForm.start_timeVal"
                                            :picker-options="{
                                                start: '00:00',
                                                step: '00:30',
                                                end: '23:30',
                                                minTime:minStartTime,
                                                maxTime:maxStartTime
                                            }"
                                            :editable="false"
                                            :placeholder="$t('marketing.discount.placeholder[5]')"
                                            @change="(value) => changeDateFormat(value,'start_timeVal')"
                                            popper-class="w-date-picker-popper">
                                        </el-time-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form-item>
                        <el-form-item :label="$t('marketing.discount.new_list_title[1]')" required>
                            <el-row :gutter="10">
                                <el-col :span="8" class="pl-0">
                                    <el-form-item  prop="end_dayVal">
                                        <el-date-picker class="w-time-picker"  style="width: 100%"
                                            v-model="discountAddForm.end_dayVal"
                                            type="date"
                                            :placeholder="$t('marketing.discount.placeholder[4]')"
                                            :picker-options="endTime"
                                            :editable="false"
                                            format="yyyy-MM-dd"
                                            @change="(value) => changeDateFormat(value,'end_dayVal')"
                                            popper-class="w-date-picker-popper"
                                            >
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item prop="end_timeVal" >
                                        <el-time-select class="w-time-picker"  style="width: 100%"
                                            v-model="discountAddForm.end_timeVal"
                                            :picker-options="{
                                                start: '00:00',
                                                step: '00:30',
                                                end: '23:30',
                                                minTime:minEndTime
                                            }"
                                            :editable="false"
                                            :placeholder="$t('marketing.discount.placeholder[5]')"
                                            @change="(value) => changeDateFormat(value,'end_timeVal')"
                                            popper-class="w-date-picker-popper">
                                        </el-time-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form-item>
                        <span class="tips"><i class=" el-icon-information"></i>{{$t('marketing.discount.tips[2]')}}</span>
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button type="primary" @click="discounttData('discountAddForm')">{{$t('common.btn.issue')}}</el-button>
                        <el-button @click="closeSelect('discountAddForm',1)">{{$t('common.btn.cancel')}}</el-button>
                  </span>
                </el-dialog>
            </div>
        </el-form>
    </div>
</template>
<script type="es6">
    import * as api from '@/js/api'
    export default {
        name: 'selectLayer',
        props:{
            title:{
                type:String,
                default(){
                    return this.$t('marketing.discount.new_discount_title[2]')
                }
            },
            changeData:{
                type:Object,
                default(){
                    return {}
                }
            },
            dialogVisible:{
                type:Boolean,
                default:false
            },
            env: {
                type: Boolean
            }
        },
        data() {
            let that = this;
            var minVal = (rule, value, callback) => {
                if(!that.discountAddForm.is_infinite){
                    if(value==""){
                        callback(new Error(this.$t('marketing.discount.filter.num[0]')));
                    }else{
                        if (value==0||value<1||value%1!=0||isNaN(value)) {
                            callback(new Error(this.$t('marketing.discount.filter.num[1]')));
                        }else{
                            callback()
                        }
                    }
                }else{
                    callback()
                }
            };
            var minPriceVal = (rule, value, callback) => {
                if(value==""){
                    callback(new Error(this.$t('marketing.discount.filter.price[0]')));
                }else{
                    if (value==0||value<rule.num||isNaN(value)) {
                        callback(new Error(this.$t('marketing.discount.filter.price[1]')));
                    } else if(value>=this.price){
                        callback(new Error(this.$t('marketing.discount.filter.price[2]')));
                    }else{
                        var dot = value.toString().indexOf(".");
                        if(dot  >-1){
                            var dotCnt = value.toString().substring(dot+1,value.length);
                            if(dotCnt.length > 2){
                                callback(new Error(this.$t('marketing.discount.filter.price[3]')));
                            }else{
                                callback()
                            }
                        }else{
                            callback()
                        }
                    }
                }
            };
            var selectVal = (rule, value, callback) => {
                if (value=="") {
                    callback(new Error(this.$t('marketing.discount.filter.course')));
                } else {
                    callback()
                }
            };
            return {
                showDiscountType:false,
                class_name_list:[],
                discountAddForm:{
                    id:"",
                    course_id:"",
                    course_name:'',
                    cur_price:"",
                    all_num:"",
                    is_infinite:false,
                    start_dayVal:"",
                    start_timeVal:"",
                    end_dayVal:"",
                    end_timeVal:"",
                    activity_id:"",
                    price:""
                },
                formData:{
                    id:"",
                    course_id:"",
                    course_name:'',
                    cur_price:"",
                    all_num:"",
                    is_infinite:false,
                    start_dayVal:"",
                    start_timeVal:"",
                    end_dayVal:"",
                    end_timeVal:"",
                    activity_id:""
                },
                discountAddRules:{
                     course_id:{validator:selectVal, trigger: 'change' },
                     cur_price:{ validator:minPriceVal, trigger: 'blur',num:0.02  },
                     all_num:[{ validator:minVal, trigger: 'blur' }],
                     start_dayVal:{ required: true, message: this.$t('marketing.discount.filter.dete[0]'), trigger: 'change' },
                     start_timeVal:{ required: true, message: this.$t('marketing.discount.filter.dete[1]'), trigger: 'blur' },
                     end_dayVal:{ required: true, message: this.$t('marketing.discount.filter.dete[0]'), trigger: 'change' },
                     end_timeVal:{ required: true, message: this.$t('marketing.discount.filter.dete[1]'), trigger: 'blur' }
                },
                errorMessage:true,
                //限制时间选择 开始时间>昨天&&开始时间<结束时间  结束时间>开始时间  如果先选择结束时间那么 结束时间>昨天
                startTime:{
                    disabledDate(time) {
                        let end_dayVal =that.discountAddForm.end_dayVal
                        if(end_dayVal){
                            return time.getTime() >  new Date(end_dayVal)||time.getTime() < Date.now() - 8.64e7;
                        }else{
                            return time.getTime() < Date.now() - 8.64e7;
                        }
                    }
                },
                endTime:{
                    disabledDate(time) {
                        let start_dayVal = that.discountAddForm.start_dayVal
                        if (start_dayVal) {
                            return time.getTime() < new Date(that.setDate(start_dayVal))- 8.64e7;
                        }else{
                            return time.getTime() < Date.now() - 8.64e7;
                        }
                    }
                },
                minStartTime:"",
                maxStartTime:"",
                minStartTime:"",
                minEndTime:"",
                today:""
            }
        } ,
        created(){
            this.getData()
        },
        computed:{
            price(){
                let obj=this.class_name_list,
                    index=this.discountAddForm.course_id;
                for( let i in obj ){
                    if(obj[i].id==index){
                        return obj[i].price
                    }
                }
            }
        },
        methods:{
            closeSelect(formName,type){//取消添加提示
                if(type==1){
                    this.$confirm(this.$t('marketing.globle.confirm.cont.cancel'),this.$t('marketing.globle.confirm.title'),{customClass:"w-dialog"},{
                        confirmButtonText: this.$t('common.btn.ok'),
                        cancelButtonText: this.$t('common.btn.cancel')
                    }).then(_ => {
                        this.resetFrom(formName)
                    })
                    .catch(_ => {});
                }else{
                    this.resetFrom('discountAddForm');
                }
            },
            resetFrom(formName){//关闭取消时重置表单并关闭弹框
                this.$refs[formName].resetFields();
                for (let key in this.changeData ){
                    if(key!="is_infinite"){
                        this.changeData[key]=''
                    }else{
                        this.changeData[key]=false
                    }

                }
                this.$emit('hideSelect',this.showDiscountType)
            },
            discounttData(formName){//验证 保存数据
                this.setDate(this.discountAddForm)
                 this.$refs[formName].validate((valid) => {
                    if (valid) {
                        for(let list in this.discountAddForm){
                            for(let key in this.formData){//去掉不需要的数据
                                if(key==list){
                                    this.formData[key]=this.discountAddForm[list];
                                }
                            }
                        }
                        var now =this.nowTime('date')+' '+this.nowTime('time');
                        var startTime=this.formData.start_dayVal+' '+this.formData.start_timeVal;
                        if(startTime<=now){
                            this.$message.error(this.$t('marketing.discount.tips[4]'));
                            return false;
                        }
                        this.saveDiscountData(this.formData)
                    } else {
                        return false;
                    }
                 });
            },
            setDate(datelist){
                if(typeof datelist=="object"){
                    if(!(datelist instanceof Date)){
                        for(let key in datelist){
                            var type=''
                            if(key=='start_dayVal'){
                                type="start_dayVal"
                            }else if(key=='end_dayVal'){
                                type="end_dayVal"
                            }
                            var d = new Date(this.discountAddForm[type]);
                                var month= d.getMonth()>=10?(d.getMonth() + 1):'0'+(d.getMonth() + 1)
                                var day=d.getDate()>=10?d.getDate():'0'+d.getDate();
                            this.discountAddForm[type]=d.getFullYear() + '-' + month+ '-' +day
                        }
                    }else{
                        var d = new Date(datelist);
                                var month= d.getMonth()>=10?(d.getMonth() + 1):'0'+(d.getMonth() + 1)
                                var day=d.getDate()>=10?d.getDate():'0'+d.getDate();
                            return d.getFullYear() + '-' + month+ '-' +day
                    }
                }else{
                    return datelist
                }
            },
            getData(){//获取付费课程
                api.personSetting.getClass({type:2,action:'activity'}).then(res =>{
                    if(res.status==200){
                        this.class_name_list=res.data.list;
                    }else{
                        this.$message.error(res.msg)
                    }
                })
            },
            nowTime(type){
                var myDate = new Date(),
                year=myDate.getFullYear(),
                month=myDate.getMonth()+1,
                day=myDate.getDate(),
                hours=myDate.getHours(),
                minutes=myDate.getMinutes();
                if(type=="time"){
                    return `${hours}:${minutes>=10?minutes:'0'+minutes}`
                }else{
                    return `${year}-${month>=10?month:'0'+month}-${day>=10?day:'0'+day}`;
                }
            },
            changeDateFormat(val,el){//修改日期格式
                this.discountAddForm[el]=val;
                var start_dayVal=this.setDate(this.discountAddForm.start_dayVal),
                    start_timeVal=this.discountAddForm.start_timeVal,
                    end_dayVal=this.setDate(this.discountAddForm.end_dayVal),
                    end_timeVal=this.discountAddForm.end_timeVal,
                    hm=this.nowTime('time');
                this.today=this.nowTime('dete');
                if(el=='start_dayVal'){
                    this.maxStartTime=""
                    if(start_dayVal==this.today){
                        this.minStartTime=hm;
                        if(start_timeVal<=hm){
                            this.discountAddForm.start_timeVal=''
                        }
                    }else{
                       this.minStartTime="";
                    }
                    if(end_dayVal){
                        if(end_timeVal){
                            if(end_dayVal==start_dayVal){
                                this.maxStartTime=end_timeVal;
                                if(start_timeVal){
                                    this.minEndTime=this.getEndTime(start_timeVal);
                                    if(end_timeVal<=start_timeVal){
                                        this.discountAddForm.start_timeVal=''
                                    }
                                }else{
                                    this.minEndTime="00:00"
                                }
                            }
                        }
                    }
                }else if(el=='end_dayVal'){
                    this.minEndTime=""
                    if(end_dayVal==this.today){
                        this.minStartTime=hm;
                        this.minEndTime=this.getEndTime(hm);
                        if(end_timeVal&&end_timeVal<=hm){
                            this.discountAddForm.end_timeVal=''
                        }
                    }else{
                        this.minEndTime="";
                    }
                    if(start_dayVal){
                        if(start_timeVal){
                            if(start_dayVal==end_dayVal){
                                this.minEndTime=this.getEndTime(start_timeVal);
                                if(end_timeVal){
                                    this.maxStartTime=end_timeVal;
                                    this.minEndTime=this.getEndTime(start_timeVal);
                                    if(end_timeVal<=start_timeVal){
                                        this.discountAddForm.end_timeVal=''
                                    }
                                }else{
                                    this.maxStartTime=""
                                }
                            }else{
                                this.maxStartTime=""
                            }
                        }else{
                            if(start_dayVal==end_dayVal){
                                this.minEndTime='00:00';
                            }
                        }
                    }
                }else if(el=='start_timeVal'){
                    if(start_dayVal){
                        if(start_dayVal==end_dayVal){
                            if(start_timeVal){
                                this.minEndTime=this.getEndTime(start_timeVal)
                            }else{
                                this.minEndTime=this.getEndTime('00:00');
                            }
                        }else{
                            this.minEndTime=""
                        }
                    }else{
                        if(end_dayVal==this.today){
                            this.minEndTime=this.getEndTime(hm)
                        }else{
                            this.minEndTime=""
                        }
                    }

                }else if(el=='end_timeVal'){
                    if(end_dayVal){
                        if(end_dayVal==start_dayVal){
                            if(end_dayVal==this.today){
                                this.minStartTime=hm;
                            }else{
                                this.minStartTime="";
                            }
                            this.maxStartTime=end_timeVal
                        }else{
                            if(start_dayVal==this.today){
                                this.minStartTime=hm;
                            }else{
                                this.minStartTime=""
                            }
                        }
                    }else{
                        if(start_dayVal==this.today){
                            this.minStartTime=hm;
                            this.maxStartTime=""
                        }else{
                            this.minEndTime="";
                            this.minStartTime="";
                            this.maxStartTime="";
                        }
                    }
                }
            },
            getEndTime(hm){
                var myDate = new Date(),
                    year=myDate.getFullYear(),
                    myear=this.discountAddForm.start_dayVal?this.setDate(this.discountAddForm.start_dayVal):''||year;
                var x =myear+' '+hm; // 取得的TextBox中的时间
                    var time = new Date(x.replace("-","/"));
                    var b = 29; //分钟数
                    time.setMinutes(time.getMinutes() + b);
                    var d = new Date(time);
                return d.getHours()+':'+d.getMinutes();
            },
            isInfinite(){//不限选择框控制人数是否显示和人数输入框验证
                let formName="discountAddForm";
                if(this.discountAddForm.is_infinite){
                    this.discountAddForm.all_num=''
                    this.errorMessage=false
                }else{
                    this.errorMessage=true
                }
            },
            saveDiscountData(formData){//保存接口
                api.personSetting.saveDiscount(formData).then(res=>{
                    if(res.status==200){
                        this.closeSelect('discountAddForm',0);
                        this.$message({
                            message: this.$t('marketing.globle.tips.success'),
                            type: 'success'
                        });
                        this.getData();
                        this.$emit('getData');
                    }else{
                        this.$message.error(res.msg)
                    }
                })
            }
        },
        watch:{
            changeData:{
                handler: function (val) {
                    [val.start_dayVal,val.start_timeVal]=val.begin_time.split(" ");
                    [val.end_dayVal,val.end_timeVal]=val.end_time.split(" ");
                    var hm=this.nowTime('time'),
                        today=this.nowTime('dete');
                    for(let key in val){
                        this.discountAddForm[key]=val[key];
                        //判断人数不限是否选中 false为未选中 true为选中
                        if(val.all_num==""){
                            this.discountAddForm.is_infinite=false;
                        }else{
                            if(val.all_num==0){
                                this.discountAddForm.is_infinite=true;
                            }
                        }
                    };
                    if(this.discountAddForm.start_dayVal==today){
                        this.minStartTime=hm;
                        if(this.discountAddForm.end_timeVal){
                            this.maxStartTime=this.discountAddForm.end_timeVal;
                        }else{
                            this.maxStartTime="";
                        }
                    }else{
                        if(this.discountAddForm.start_dayVal==this.discountAddForm.end_dayVal){
                             this.maxStartTime=this.discountAddForm.end_timeVal;
                        }
                    }
                    if(this.discountAddForm.end_dayVal==today){
                        if(this.discountAddForm.start_timeVal){
                            this.minEndTime=this.getEndTime(this.discountAddForm.start_timeVal);
                        }else{
                            this.minEndTime=this.getEndTime(hm);
                        }
                    }else{
                        if(this.discountAddForm.start_dayVal==this.discountAddForm.end_dayVal){
                            this.minEndTime=this.getEndTime(this.discountAddForm.start_timeVal);
                        }
                    }
                    if(this.discountAddForm.start_dayVal==today){
                        this.minStartTime=hm;
                        if(this.discountAddForm.end_timeVal){
                            this.maxStartTime=this.discountAddForm.end_timeVal;
                        }else{
                            this.maxStartTime="";
                        }
                    }else{
                        if(this.discountAddForm.start_dayVal==this.discountAddForm.end_dayVal){
                             this.maxStartTime=this.discountAddForm.end_timeVal;
                        }
                    }
                    if(this.discountAddForm.end_dayVal==today){
                        if(this.discountAddForm.start_timeVal){
                            this.minEndTime=this.getEndTime(this.discountAddForm.start_timeVal);
                        }else{
                            this.minEndTime=this.getEndTime(hm);
                        }
                    }else{
                        if(this.discountAddForm.start_dayVal==this.discountAddForm.end_dayVal){
                            this.minEndTime=this.getEndTime(this.discountAddForm.start_timeVal);
                        }
                    }
                },
                deep: true
            }
        }
    }
</script>
<style lang="scss" scoped="" type="text/css">
    .gray-text{
        color: #333;
    }
    .fl{
        float: left;
    }
    .ml-5{
        margin-left: 5px!important;
    }
    .pl-0{
        padding-left: 0px!important;
    }
    .tips{
        color: #999;
        margin-left:10px;
        font-size:12px;
        i{
            color: #20a0ff;
            padding-right: 5px;
        }
    }
    .discount-add-wrap{
        p{margin:0}
        .cont{
            .main-cont{
                margin:20px 10px 0px;
            }
        }
    }
</style>
