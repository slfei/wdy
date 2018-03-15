<template>
    <div class="consultation-wrap">
        <div class="cont">
            <div class="search-cont">
                <el-form :model="student" label-width="95px" class="w-demo-form">
                        <el-row :gutter="20">
                            <el-col :span="7" class="en-small">
                                <el-form-item class="m-b-0" :label="$t('marketing.student.filter.student_information.title')">
                                    <el-input  class="border-none w-input" v-model="student.student_name" :placeholder="$t('marketing.student.filter.student_information.placeholder')"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="7" class="en-small">
                                <el-form-item class="m-b-0" :label="$t('marketing.student.filter.student_id.title')">
                                    <el-input class="border-none w-input" v-model="student.student_id" :placeholder="$t('marketing.student.filter.student_id.placeholder')"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="7" class="en-small">
                                <el-form-item class="m-b-0" :label="$t('marketing.student.filter.course_name.title')">
                                    <el-input class="border-none w-input" v-model="student.course" :placeholder="$t('marketing.student.filter.course_name.placeholder')"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="2">
                                <el-button type="primary" @click="queryData">&nbsp;{{$t('common.btn.query')}}&nbsp;</el-button>
                            </el-col>
                        </el-row>
                </el-form>
            </div>
            <div class="text-layout">
                <ul class="clearfix">
                    <li>
                        <div class="text-center text-cont">
                            <div>{{$t('marketing.student.details.details_list[0]')}}</div>
                            <p>{{studentData.total.all_student}}</p>
                            <em></em>
                        </div>
                    </li>
                    <li>
                        <div class="text-center text-cont">
                            <div>{{$t('marketing.student.details.details_list[1]')}}</div>
                            <p>{{studentData.total.pay_student}}/{{studentData.total.percent}}</p>
                            <em></em>
                        </div>
                    </li>
                    <li>
                        <div class="text-center text-cont">
                            <div>{{$t('marketing.student.details.details_list[2]')}}</div>
                            <p>{{studentData.total.all_money}}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tips">{{$t('marketing.student.details.tips')}}</div>
            <div class="search-pay"><el-checkbox class="w-checkbox-group" v-model="student.pay_type" @change="payType">{{$t('marketing.student.list.pay_type')}}</el-checkbox></div>

            <el-table class="w-table"
                :data="studentData.list"
                style="width: 100%"
                :empty-text="$t('common.btn.noData')"
                >
                <el-table-column
                    prop="id"
                    :label="$t('marketing.student.list.list_title[0]')"
                    width="100">
                </el-table-column>
                <el-table-column
                    prop="nick_name"
                    width="120"
                    :label="$t('marketing.student.list.list_title[1]')">
                </el-table-column>
                <el-table-column
                    prop="duration"
                    width="130"
                    :label="$t('marketing.student.list.list_title[2]')">
                </el-table-column>
                <el-table-column
                    prop="study_count"
                    width="135"
                    :label="$t('marketing.student.list.list_title[3]')">
                </el-table-column>
                <el-table-column
                    prop="course_count"
                    width="120"
                    :label="$t('marketing.student.list.list_title[4]')">
                </el-table-column>
                <el-table-column
                    prop="last_view_time"

                    :label="$t('marketing.student.list.list_title[5]')">
                </el-table-column>
                <el-table-column
                    prop="money"
                    :label="$t('marketing.student.list.list_title[6]')"
                    width="120">
                    <template scope="scope">
                        <span v-if="scope.row.money>=0">{{parseFloat(scope.row.money).toFixed(2)}}</span>
                    </template>
                </el-table-column>
            </el-table>
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
    </div>
</template>
<script type="es6">
    import * as api from '@/js/api'
    export default {
        name: 'consultation',
        data(){
            return {
                student:{//查询参数
                    student_name:"",
                    student_id:"",
                    course:"",
                    pay_type:false,//是否付费 true为已付费 false为全部人员
                    page_num:1,
                    page_size:10
                },
                studentData: {
                    list: [{//表格数据
                        id: "",
                        name: "",
                        classes_time: "",
                        classes_total: "",
                        classes_count: "",
                        last_time: "",
                        total_money: ""
                    }],
                    total:{//中间部分数据
                        all_money:"",
                        all_student:"",
                        pay_student:"",
                        percent:""
                    }
                },
                total:0,
                currentpage:1,
                queryType:false//查询状态
            }
        },
        created(){
            this.getData({page_num:1,page_size:10});
        },
        methods:{
            handleCurrentChange(val) {
                this.currentpage=val;
                var params=""
                if(this.queryType){
                    this.student.page_num=val;
                    params=JSON.stringify(this.student)
                }else{
                    params=JSON.stringify({page_num:val,page_size:10})
                }
                this.getData(params);
            },
            getData(params){
                api.personSetting.getStudent(params).then(res=>{
                    if(res.status==200){
                        this.studentData.list=res.data.list
                        this.studentData.total=res.data.total
                        this.total=res.data.list_total
                    }else{
                        this.$message(res.msg)
                    }
                })
            },
            queryData(){
                api.personSetting.getStudent(this.student).then(res=>{
                    if(res.status==200){
                        this.currentpage=1
                        this.studentData.list=res.data.list
                        this.studentData.total=res.data.total;
                        this.total=res.data.list_total;
                        this.queryType=true;
                    }else{
                        this.$message(res.msg)
                    }
                })
            },
            payType(){//只查看付费学员
                if(this.queryType){
                    this.queryData(this.student);
                }else{
                    this.queryData({page_num:this.currentpage,page_size:10,pay_type:this.student.pay_type,student_id:'',student_name:"",course:''})
                }

            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .locale-en{
        .en-small:nth-of-type(1){
            width: 310px;
        }
        .en-small:nth-of-type(2){
            width: 260px;
        }
        .en-small:nth-of-type(3){
            width: 310px;
        }
    }

    .tips{
        color: #999;
        font-size: 12px;
        margin-bottom: 20px;
        float: left;
    }
    .text-center{
        text-align: center;
    }
    .search-pay{
        float: right;
        margin-bottom:10px ;
        font-size: 12px;
        color: #333;
    }
    .consultation-wrap{
        width: 1000px;
        .search-cont{
            min-height: 72px;
            background-color: #f5f5f5;
            padding: 18px 0px;
            border-radius: 4px;
            margin-bottom: 20px;
            .m-b-0{
                margin-bottom: 0
            }
        }
        .text-layout {
            margin:40px 0 30px;
            li{
                float: left;
                width: 64px;
                padding-right: 18px;
                box-sizing: content-box;

            }
            li:nth-child(2){
                width: 112px;
                padding: 0 18px;
            }
            li:nth-child(3){
                width: 120px;
                padding-left: 18px;
            }
            .text-cont {
                position: relative;
                div {
                    font-size: 16px;
                    color: #333;
                    padding-bottom: 5px;

                }
                p {
                    color: #ff1818;
                    font-size: 14px;
                    margin-top: 5px;
                }
                em {
                    position: absolute;
                    right: -18px;
                    top: 7px;
                    bottom: 7px;
                    width: 1px;
                    background-color: #d9d9d9;
                }
            }
        }
        .pagination-cont{
            text-align: center;
            padding: 20px 0;
        }
    }

</style>
