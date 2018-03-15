<template>
    <div class="order-query-wrap">
        <div class="search-cont">
            <el-form label-width="80px">
                <el-row :gutter="10">
                    <el-col :span="8">
                        <el-form-item :label="$t('order.filter.order_num')">
                            <el-input class="border-none" v-model="order_query.order_id" :placeholder="$t('order.filter.placeholder.order_id')"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item :label="$t('order.filter.course')">
                            <el-input class="border-none" v-model="order_query.course" :placeholder="$t('order.filter.placeholder.course_name')"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="7">
                        <el-form-item :label="$t('order.filter.order_status.title')">
                            <el-select  class="border-none" v-model="order_query.pay_status" :placeholder="$t('order.filter.placeholder.select')">
                                <el-option
                                        v-for="status in status_list"
                                        :key="status.value"
                                        :label="status.label"
                                        :value="status.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :span="8">
                        <el-form-item :label="$t('order.filter.create_time')">
                            <el-date-picker class="border-none start_time" type="datetime" :editable="false"
                                            @change="(value) => changeHandler(value,'start_time')"
                                            :placeholder="$t('order.filter.placeholder.time')" v-model="order_query.start_time"
                                            :picker-options="startTime"
                                            style="width: 100%;">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item class="label-center" :label="$t('order.filter.time_to')">
                            <el-date-picker class="border-none end_time" type="datetime" :editable="false"
                                            @change="(value) => changeHandler(value,'end_time')"
                                            :placeholder="$t('order.filter.placeholder.time')" v-model="order_query.end_time"
                                            :picker-options="endTime"
                                            style="width: 100%;" >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="4" style="margin-left: 15px">
                        <el-button type="primary" @click="getList">{{$t('common.btn.query')}}</el-button>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        <div class="export-cont">
            <el-row type="flex" justify="end">
                <el-col :span="4"><el-button class="w-button" :disabled="orderlist.length<=0" @click="exportOrder" >     {{$t('order.btn.export')}}</el-button></el-col>
            </el-row>
        </div>

        <div class="list-wrap">
            <ul class="list-heade clearfix">
                <li>{{$t('order.data_list.list_title[0]')}}</li>
                <li>{{$t('order.data_list.list_title[1]')}}</li>
                <li>{{$t('order.data_list.list_title[2]')}}</li>
                <li>{{$t('order.data_list.list_title[3]')}}</li>
                <li>{{$t('order.data_list.list_title[4]')}}</li>
                <li>{{$t('order.data_list.list_title[5]')}}</li>
                <li>{{$t('order.data_list.list_title[6]')}}</li>
                <li>{{$t('order.data_list.list_title[7]')}}</li>
            </ul>
            <ul>
                <li v-for="(item,index) in orderlist" :class="{'cur':showArray.indexOf(index)>=0&&item.refund_detail.length>0}">
                    <div class="list">
                        <ul class="list-cont clearfix" :class="{'cur':showArray.indexOf(index)>=0&&item.refund_detail.length>0}">
                            <li>{{item.order_id}}</li>
                            <li>{{item.account_id}}</li>
                            <li>{{item.course_name}}</li>
                            <li>{{parseFloat(item.real_price/100).toFixed(2)}}</li>
                            <li>{{payType(item.pay_type)}}</li>
                            <li><span v-if="item.balance_status==1">{{$t('order.data_list.order_status[0]')}}</span>
                                <span v-else-if="item.balance_status==2" style="color: #ff1818 ">{{$t('order.data_list.order_status[1]')}}</span>
                                <span v-else-if="item.balance_status==3" style="color: #268fff ">{{$t('order.data_list.order_status[2]')}}</span>
                                <span v-else-if="item.balance_status==4" style="color: #268fff ">{{$t('order.data_list.order_status[3]')}}</span>
                                <span v-else-if="item.balance_status==5" style="color: #268fff ">{{$t('order.data_list.order_status[4]')}}</span>
                                <span v-else-if="item.balance_status==6" style="color: #268fff ">{{$t('order.data_list.order_status[5]')}}</span>
                            </li>
                            <li>{{item.created_at}} </li>
                            <li><span class="info-text" v-if="item.refund_detail!=''" @click="infoType(index)">{{$t('order.btn.info')}}</span>
                                <span v-else>--</span></li>
                        </ul>
                    </div>
                    <div class="info" v-if="showArray.indexOf(index)>=0">
                        <ul class="info-heade clearfix">
                            <li>{{$t('order.data_list.info.title[0]')}}</li>
                            <li>{{$t('order.data_list.info.title[1]')}}</li>
                            <li>{{$t('order.data_list.info.title[2]')}}</li>
                            <li>{{$t('order.data_list.info.title[3]')}}</li>
                            <li>{{$t('order.data_list.info.title[4]')}}</li>
                            <li>{{$t('order.data_list.info.title[5]')}}</li>
                        </ul>
                        <ul v-for="infoList in item.refund_detail" class="info-cont clearfix">
                            <li>{{infoList.refund_no}}</li>
                            <li>{{parseFloat(infoList.refund_money/100).toFixed(2)}}</li>
                            <li>
                                <span v-if="infoList.refund_reason==1">{{$t('order.data_list.info.reason[0]')}}</span>
                                <span v-else-if="infoList.refund_reason==2">{{$t('order.data_list.info.reason[1]')}}</span>
                                <span v-else-if="infoList.refund_reason==3">{{$t('order.data_list.info.reason[2]')}}</span>
                                <span v-else>{{$t('order.data_list.info.reason[3]')}}</span>
                            </li>
                            <li>
                                <p v-if="infoList.refund_reason!=null">
                                <span v-if="infoList.refund_reason.length<=25">{{infoList.refund_reason}}</span>
                                <span v-else>
                                    {{infoList.refund_reason | subString}}
                                    <el-popover
                                                width="200"
                                                trigger="hover"
                                                :content="infoList.refund_reason">
                                        <span slot="reference"><i class="more ion-arrow-down-b"></i></span>
                                    </el-popover>
                                </span>
                                </p>

                            </li>
                            <li>
                                <span v-if="infoList.status==1">{{$t('order.data_list.info.status[0]')}}</span>
                                <span v-else-if="infoList.status==2">{{$t('order.data_list.info.status[1]')}}</span>
                                <span v-else-if="infoList.status==3">{{$t('order.data_list.info.status[2]')}}</span>
                                <span v-else-if="infoList.status==4">{{$t('order.data_list.info.status[3]')}}</span>
                                <span v-else-if="infoList.status==5">{{$t('order.data_list.info.status[4]')}}</span>
                            </li>
                            <li>{{infoList.created_at}}</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div v-if="orderlist.length<=0" class="list">
            <div  class="nodata el-row" style="">
                {{$t('order.nodata')}}
            </div>
        </div>
        <div class="pagination-cont" v-show="total">
            <div class="inline-block">
                <el-pagination class="w-pagination"
                               layout="prev, pager, next"
                               @current-change="handleCurrentChange"
                               :page-size="10"
                               :total="total"
                               :current-page.sync="currentpage">
                </el-pagination>
            </div>
        </div>
    </div>
</template>
<script type="es6">
    import api from '@/js/api/refund.server';
    export default {
        name: 'orderquery',
        data() {
            let that=this;
            return {
                infoIndex:null,
                showArray:[],
                showId:null,
                list:[
                    {id:111},
                    {id:222},
                    {id:333},
                    {id:444}
                ],
                orderlist:[
                    {
                        order_id:"",
                        account_id:"",
                        course_name:"",
                        real_price:"",
                        balance_status:"",
                        created_at:""
                    },
                ],
                status_list:[{//查询下拉框
                    value: "",
                    label: this.$t('order.filter.order_status.options[0]')
                },{
                    value: 1,
                    label: this.$t('order.filter.order_status.options[1]')
                },{
                    value: 2,
                    label: this.$t('order.filter.order_status.options[2]')
                },{
                    value: 3,
                    label: this.$t('order.filter.order_status.options[3]')
                },{
                    value: 4,
                    label: this.$t('order.filter.order_status.options[4]')
                },{
                    value: 5,
                    label: this.$t('order.filter.order_status.options[5]')
                },{
                    value: 6,
                    label: this.$t('order.filter.order_status.options[6]')
                }],
                order_query:{//查询参数
                    order_id:"",
                    course:"",
                    pay_status:"",
                    start_time:"",
                    end_time:"",
                    page_num:1,
                    page_size:10
                },
                filter:{
                    order_id:"",
                    course:"",
                    pay_status:"",
                    start_time:"",
                    end_time:"",
                },
                total:0,
                currentpage:1,//当前页 默认为首页
                queryType:false,
                startTime:{
                    disabledDate(time) {
                        let end_dayVal =that.order_query.end_time
                        if(end_dayVal){
                            return time.getTime() >  new Date(end_dayVal)
                        }
                    }
                },
                endTime:{
                    disabledDate(time) {
                        let start_dayVal = that.order_query.start_time
                        if (start_dayVal) {
                            return time.getTime() < new Date(start_dayVal)- 8.64e7;
                        }
                    }
                },
            }
        },
        created(){
            this.getData();
        },
        methods:{
            payType(type) {
                if (type == 1 || type == 4 ||type == 5 ||type == 6 ) return this.$t('order.Method.Wechat')
                if (type == 2 || type == 3 ||type == 7 ) return this.$t('order.Method.Alipay')
                if (type == 11) return this.$t('order.Method.iOS')
            },
            infoType(index){
                if(this.showArray.indexOf(index)<=-1){
                    this.showArray.push(index)
                    if(this.showArray.indexOf(index)>=0){
                        this.showId=index;
                    }
                }else{
                    var i = this.showArray.indexOf(index);
                    if (i > -1) {
                        this.showArray.splice(i, 1);
                    }
                    this.showId=null;
                }
            },
            changeHandler(val,el){//选择时间后的回调 转换数据格式将
                this.order_query[el]=val;
                let dateNode=this.$el.getElementsByClassName(el)[0];
                dateNode.className = dateNode.className.replace( new RegExp( "(\\s|^)clear-icon(\\s|$)" )," ")
                if(val){
                    dateNode.className +=' clear-icon'
                }else{
                    dateNode.className = dateNode.className.replace( new RegExp( "(\\s|^)clear-icon(\\s|$)" )," ")
                }
            },
            getData(){//数据列表
                api.getOrderList({page_num:1,page_size:10}).then(res => {
                    if (res.status==200) {
                        this.orderlist = res.data.data;
                        this.total=res.data.total;
                    }
                })
            },
            getList(){//查询列表
                api.getOrderList(this.order_query).then(res => {
                    if (res.status==200) {
                        this.currentpage=1;
                        this.orderlist = res.data.data;
                        this.total=res.data.total;
                        this.queryType=true
                        this.filter=res.data.filter
                    }
                })
            },
            handleCurrentChange(val) {//分页
                this.currentpage=val;
                var params=""
                if(this.queryType){
                    this.order_query.page_num=val;
                    params=JSON.stringify(this.order_query)
                }else{
                    params=JSON.stringify({page_num:val,page_size:10})
                }
                api.getOrderList(params).then(res=>{
                    if(res.status==200){
                        this.orderlist = res.data.data;
                        this.total=res.data.total;
                        this.showArray=[];
                    }else{
                        this.$message(res.msg)
                    }
                })
            },
            exportOrder(){
                let filter=this.filter;
                location.href=`/api/excel/orderlist?course=${filter.course}&pay_status=${filter.pay_status}&start_time=${filter.start_time}&end_time=${filter.end_time}&order_id=${filter.order_id}`
            }
        },
        filters:{
            subString(value){
                if(value !=null){
                    if(value.length>25){
                        return `${value.substring(0,25)}...`
                    }else{
                        return value
                    }
                }else{
                    return value
                }
            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .order-query-wrap {
        width: 1004px;
        .list-wrap{
            border-radius: 4px 4px 0 0;
            border:1px solid #d9d9d9;
            border-bottom:0 none;
            li.cur{
                border-bottom: 1px solid #dfe4ec;
                background-color: #f5f5f5;
            }
            .info{
                background-color: #fff;
                border: 1px solid #dfe4ec;
                border-radius: 4px;
                margin: 5px 20px 30px;
            }
            .info-heade,.list-heade,.list-cont,.info-cont{
                li{
                    float: left;
                    width: 13%;
                    word-break: break-all;
                    padding-right: 15px;
                    padding: 10px 10px 10px 0;
                }
            }
            .list-cont,.list-heade{
               li:nth-of-type(1){
                    width: 160px;
                    margin-right: 20px;
                }
                li:nth-of-type(2){
                    width: 80px;
                }
                li:nth-of-type(3){
                    width: 170px;
                }
                li:nth-of-type(4){
                    width: 115px;
                }
                li:nth-of-type(5){
                    width: 120px;
                }
                li:nth-of-type(6){
                    width: 110px;
                }
                li:nth-of-type(7){
                    width: 90px;
                }
                li:nth-of-type(8){
                    width: 100px;
                    padding-left: 35px;
                }
            }

            .list-heade,.info-heade{
                border-bottom:1px solid #d9d9d9;
                padding: 12px 18px;
                height: 55px;
                color: #333;
                font-size: 14px;
                li{
                    height: 30px;
                    line-height: 30px;
                    padding: 0;
                }
            }
            .list-heade{
                background-color: #f5f5f5;
            }
            .info-heade{
                color: #333;
                font-size:14px;
            }
            .list-cont{
                border-bottom:1px solid #d9d9d9;
                padding: 12px 18px;
                &.cur{
                    background-color: #f5f5f5;
                    border-bottom: 0 none;
                }
            }
            .info-cont{
                padding: 12px 28px;
                color: #999;
            }
            .list-cont{
                &:hover{
                     background-color: #f5f5f5;
                 }
            }
            .info-cont,.info-heade{
                padding:12px 40px;
                li{
                    padding-right: 20px;
                    border-bottom: 0 none;
                    word-break: break-all;
                    .more{
                        cursor: pointer;
                        color: #268fff;
                    }
                }
                li:nth-of-type(1){
                    width: 190px;
                }
                li:nth-of-type(2){
                    width: 135px;
                }
                li:nth-of-type(3){
                    width: 140px;
                }
                li:nth-of-type(4){
                    width: 190px;
                }
                li:nth-of-type(5){
                    width: 105px;
                }
                li:nth-of-type(6){
                    width: 120px;
                }
            }
        }
    .search-cont {
        min-height: 125px;
        background-color: #f5f5f5;
        padding: 16px 0px 0;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .info-text{
        color: #268fff;
        cursor: pointer;
    }
    .export-cont{
        margin: 40px 0 10px;
        button{
            float: right
        }
    }
    .pagination-cont{
        text-align: center;
        padding: 20px 0;
    }
    .info-cont{
    dl{
        border-bottom:1px solid #eee;
    dd{
        width: 20%;
        float: left;
        margin: 0;
        padding: 10px 0;

    }
    }
    }
    }

.nodata{
    height: 60px;
    width: 100%;
    color: #999999;
    line-height: 60px;
    border: 1px solid #d9d9d9;
    border-top:0 none ;
    text-align: center;
}

</style>
<style lang="scss" type="text/css">
    .label-center{
    .el-form-item__label{
        text-align: center;
    }
    }
</style>
