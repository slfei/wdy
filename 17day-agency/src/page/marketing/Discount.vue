<template>
    <div class="discount-wrap">
        <div class="cont">
            <div class="add-btn">
                <el-button class="w-button" @click="newDiscount">{{$t('marketing.discount.btn')}}</el-button>
            </div>
            <el-table class="w-table"
                :data="tableData"
                style="width: 100%"
                :empty-text="$t('common.btn.noData')">
                <el-table-column
                    prop="activity_id"
                    :label="$t('marketing.discount.data_list_title[0]')"
                    width="100">
                </el-table-column>
                <el-table-column
                    prop="course_name"
                    :label="$t('marketing.discount.data_list_title[1]')" width="120" >
                </el-table-column>
                <el-table-column
                    prop="price"
                    :label="$t('marketing.discount.data_list_title[2]')"
                    width="110">
                    <template scope="scope">
                        <span>{{parseFloat(scope.row.price).toFixed(2)}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="cur_price"
                    :label="$t('marketing.discount.data_list_title[3]')">
                    <template scope="scope">
                        <span>{{parseFloat(scope.row.cur_price).toFixed(2)}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="all_num"
                    :label="$t('marketing.discount.data_list_title[4]')"
                    width="85">
                    <template scope="scope">
                        <span v-if="scope.row.is_infinite==true">{{$t('marketing.discount.data_num_status')}}</span>
                        <span v-else>{{scope.row.all_num}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="use_num"
                    :label="$t('marketing.discount.data_list_title[5]')"
                    width="90">
                </el-table-column>
                <el-table-column
                    :label="$t('marketing.discount.data_list_title[6]')" width="140">
                    <template scope="scope">
                        <span>{{scope.row.begin_time+'--'+scope.row.end_time}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="status"
                    :label="$t('marketing.discount.data_list_title[7]')"
                    width="120">
                    <template scope="scope">
                        <span v-if="scope.row.status_id==0">{{$t('marketing.discount.status[0]')}}</span>
                        <span v-else-if="scope.row.status_id==1">{{$t('marketing.discount.status[1]')}} </span>
                        <span v-else-if="scope.row.status_id==2">{{$t('marketing.discount.status[2]')}}</span>
                        <span v-else>{{$t('marketing.discount.status[0]')}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    :label="$t('marketing.discount.data_list_title[8]')"
                    width="100">
                    <template scope="scope" >
                        <div v-if="scope.row.status_id==1">
                            <el-button @click="updateClick(scope.$index)" type="text" size="small">{{$t('common.btn.modify')}}</el-button>
                            <el-button type="text" size="small" @click="deleteDialog(tableData[scope.$index].activity_id)">{{$t('common.btn.delete')}}</el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <div class="pagination-cont" v-show="total">
                <div class="inline-block">
                    <el-pagination class="w-pagination"
                        layout="prev, pager, next"
                        @current-change="handleCurrentChange"
                        :page-size="10"
                        :current-page.sync="currentpage"
                        :total="total"
                        >
                    </el-pagination>
                </div>
            </div>
            <discount-add v-show="showType" :env="ifEnlishVersion" :dialogVisible="showType" :title="title" @getData="getData(pagination)" :changeData="changeDataList" @hideSelect ="Selectfn"></discount-add>
        </div>
    </div>
</template>
<script type="es6">
    import discountAdd from './DiscountAdd.vue'
    import * as api from '@/js/api'
    export default {
        name: 'consultation',
        data(){
            return {
                tableData: [],
                total:0,
                changeDataList:{
                    activity_id:"",
                    all_num:"",
                    begin_time:"",
                    course_name:"",
                    cur_price: "",
                    end_time:"",
                    is_infinite:false,
                    id:"",
                    price:"",
                    status:"",
                    status_id:"",
                    use_num:""
                },
                showType:false,//弹框显示状态 false为不显示 true为显示
                title:this.$t('marketing.discount.btn'),
                currentpage:1,
                pagination:{
                    page_num:1,
                    page_size:10
                }
            }
        },
        mounted(){
            this.getData(this.pagination);
        },
        methods:{
            handleCurrentChange(val) {
                this.currentpage=val;
                this.pagination.page_num=val;
                this.getData(this.pagination)
            },
            updateClick(i) {//修改
                this.showType=true;
                this.title=this.$t('marketing.discount.new_discount_title[1]');
                for( let key in this.tableData[i]){
                    this.changeDataList[key]=this.tableData[i][key];//将数据传给子组件
                }
            },
            newDiscount(){//发布新优惠
                this.showType=true;
                this.title=this.$t('marketing.discount.new_discount_title[0]');
                for( let key in this.tableData[0]){
                    this.changeDataList[key]=""
                }
            },
            Selectfn(type){
                this.showType=type;
            },
            getData(pagination){
                pagination.page_num=this.currentpage;
                api.personSetting.getDiscount(pagination).then(res =>{
                    if(res.status==200){
                        this.tableData=res.data.list.concat();
                        this.total=res.data.total;
                    }else{
                        this.$message.error(res.msg)
                    }
                })
            },
            deleteDialog(index){
                this.$confirm(this.$t('marketing.globle.confirm.cont.cancel'),this.$t('marketing.globle.confirm.title'),{customClass:"w-dialog"},{
                    cancelButtonText: this.$t('common.btn.cancel'),
                    confirmButtonText: this.$t('common.btn.ok')
                }).then(_ => {
                    this.deleteList(index)
                    done();
                })
                .catch(_ => {});
            },
            deleteList(id){
                api.personSetting.deleteDiscount({activity_id:id}).then(res => {
                    if (res.status == 200) {
                        this.$message({
                          message: this.$t('marketing.globle.tips.delete'),
                          type: 'success'
                        });
                        this.getData(this.pagination);
                    } else {
                        this.$message.error(res.msg)
                    }
                })
            }
        },
        components:{
            discountAdd
        },
        computed: {
            ifEnlishVersion() {
                return (window.LOCALE == 'en');
            }
        }
    }
</script>
<style lang="scss" scoped type="text/css">
    .discount-wrap{
        width: 1004px;
        margin-top:-15px;
        .cont{
            .add-btn{
                margin: 18px 0 20px 0;
            }
            .pagination-cont{
                text-align: center;
                padding: 20px 0;
            }

        }
    }

</style>
