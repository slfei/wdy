<template>
<div class="refund-page">
    <div class="tip-box">
        <p>{{$t('refund.text.refund-title')}}</p>
        <div class="refund-info">{{$t('refund.text.refund-description-step1')}}
            <br>{{$t('refund.text.refund-description-step2')}}
            <br>{{$t('refund.text.refund-description-step3')}}
        </div>
    </div>
    <el-tabs v-model="activeName" @tab-click="handleClick" class="w-tabs">
        <el-tab-pane :label="$t('refund.tabs.el-noconfirm')" name="first">
        </el-tab-pane>
        <el-tab-pane :label="$t('refund.tabs.el-processing')" name="second">
        </el-tab-pane>
        <el-tab-pane :label="$t('refund.tabs.el-completed')" name="third">
        </el-tab-pane>
    </el-tabs>
    <div class="table-con">
        <table cellspacing="0" cellpadding="0" border="0" class="table-refund" width="100%">
            <tr>
                <th>{{$t('refund.table.title.refund-number')}}</th>
                <th>{{$t('refund.table.title.course-name')}}</th>
                <th width="7%">{{$t('refund.table.title.memberID')}}</th>
                <th width="9%">{{$t('refund.table.title.refund-amount')}}</th>
                <th width="9%" v-if="status02==1">{{$t('refund.table.title.transaction-amount')}}</th>
                <th>{{$t('refund.table.title.apply-time')}}</th>
                <th v-if="status02==2">{{$t('refund.table.title.confirm-time')}}</th>
                <th v-if="status02==1">{{$t('refund.table.title.reason')}}</th>
                <th v-if="status02==1">{{$t('refund.table.title.description')}}</th>
                <th>{{$t('refund.table.title.operation')}}</th>
            </tr>
            <tr v-for="item in tableData">
                <td>
                    <div class="num-refund">{{item.refund_num}}</div>
                </td>
                <td :class="{coursewidth:(status02==1)}">{{item.course_name}}</td>
                <td>{{item.account_id}}</td>
                <td>{{item.refund_money}}</td>
                <td v-if="status02==1">{{item.real_price}}</td>
                <td>{{item.created_at}}</td>
                <td v-if="status02==2">{{item.updated_at}}</td>
                <td v-if="status02==1">{{item.reason}}</td>
                <td v-if="status02==1">
                    <div class="explain-reason">
                        <span>{{item.refund_reason}}</span>
                        <i class="ion-arrow-down-b" @mouseenter="showExplainReason(item)" @mouseleave="hideExplainReason(item)" v-if="item.reasonFullFlag"></i>
                        <div class="el-popover" x-placement="bottom" v-if="item.showFlag">
                            {{item.refund_reason}}
                            <div x-arrow="" class="popper__arrow" style="left: 103.5px;"></div>
                        </div>
                    </div>
                </td>
                <td>
                    <div v-if="status02==1">
                        <el-button type="text" @click="confirmRefund(item)">{{$t('refund.btn.confirm-refund')}}</el-button>
                        <div class="time-surplus">
                            <img src="../../assets/images/icon-clock.png">
                            <counter :applyTime='item.created_at'></counter>
                        </div>
                    </div>
                    <div v-if="status02!=1">--</div>
                </td>

            </tr>
        </table>
        <div v-if="tableData.length==0" class="no-data">{{$t('refund.tips.no-data')}}</div>
    </div>
    <div class="block" v-if="tableData.length>0">
        <el-pagination @current-change="handleCurrentChange" :current-page.sync="filter.page_num" :page-size="10" layout="prev, pager, next" :total="total" class="w-pagination">
        </el-pagination>
    </div>
</div>
</template>
<script>
import Vue from 'vue'
import counter from './counter.vue'
import api from '@/js/api/refund.server';
export default {
    components: {
        counter: counter
    },
    data() {
        return {
            activeName: 'first',
            tableData: [],
            status02: 1,
            total: 0,
            reasonList: [{
                id: '1',
                name: this.$t('refund.reasonList.name1')
            }, {
                id: '2',
                name: this.$t('refund.reasonList.name2')
            }, {
                id: '3',
                name: this.$t('refund.reasonList.name3')
            }, {
                id: '4',
                name: this.$t('refund.reasonList.name4')
            }],
            filter: {
                status: '1',
                page_size: 10,
                page_num: 1
            }
        };
    },
    mounted() {
        this.getRefundList();
    },
    methods: {
        getRefundList() { // 退款列表
            api.getRefundList(this.filter).then(res => {
                this.total = res.total;
                this.tableData = res.data;
                var _this = this;
                this.tableData.map(function(item) {
                    item.real_price = (item.real_price / 100).toFixed(2);
                    item.refund_money = (item.refund_money / 100).toFixed(2);
                    Vue.set(item, 'showFlag', false);
                    Vue.set(item, 'reasonFullFlag', false);
                    let obj = {};
                    obj = _this.reasonList.find(function(v) {
                        return v.id == item.reason;
                    });
                    item.reason = obj.name;
                });
                this.tableData.forEach(function(item) {
                    if (item.refund_reason && item.refund_reason.length > 20) {
                        item.reasonFullFlag = true;
                    }
                });
            })
        },
        handleClick(tab, event) {
            if (this.activeName == 'first') { //退款待确认
                this.filter.status = '1';
                this.status02 = 1;
                this.getRefundList();
            }
            if (this.activeName == 'second') { //退款处理中
                this.filter.status = '2';
                this.status02 = 2;
                this.getRefundList();
            }
            if (this.activeName == 'third') { // 退款完成
                this.filter.status = '4';
                this.status02 = 3;
                this.getRefundList();
            }
        },
        confirmRefund(item) { // 确认退款
            api.confirmRefund({
                order_id: item.order_id
            }).then(res => {
                if (res.errorcode == 0) {
                    this.$message({
                        type: 'success',
                        message: res.msg
                    });
                    this.getRefundList();
                } else {
                    this.$message({
                        type: 'error',
                        message: res.msg
                    });
                }
            })
        },
        handleCurrentChange(val) {
            this.filter.page_num = val;
            this.getRefundList();
        },
        showExplainReason(item) {
            item.showFlag = true;
        },
        hideExplainReason(item) {
            item.showFlag = false;
        }
    }
};
</script>
<style>
.refund-page .tip-box {
    margin-bottom: 20px;
    background-color: #f5f5f5;
    padding: 10px 20px 5px 20px;
    border-radius: 4px;
    border: 1px solid #d9d9d9;
}

.refund-page .tip-box p {
    color: #333333;
    margin: 5px 0;
}

.refund-page .refund-info {
    color: #999999;
    line-height: 20px;
    margin: 5px 0;
    font-size: 12px;
}

.refund-page .time-surplus span {
    color: #999;
}

.refund-page .block {
    text-align: center;
    margin: 20px 0;
}

.refund-page .explain-reason {
    position: relative;
    width: 140px;
}

.refund-page .explain-reason span {
    text-overflow: -o-ellipsis-lastline;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.refund-page .explain-reason i {
    position: absolute;
    right: 0;
    bottom: -5px;
    color: #268fff;
    cursor: pointer;
}

.refund-page .el-popover {
    width: 240px;
    position: absolute;
    top: 35px;
    right: -126px;
    transform-origin: center top 0px;
    z-index: 999;
    line-height: 20px;
    padding: 10px;
}

.refund-page .el-table.w-table .cell {
    overflow: visible;
}

.refund-page .table-refund th {
    padding: 15px;
    font-weight: 400;
    background-color: #f5f5f5;
    text-align: left;
    border-bottom: 1px solid #d9d9d9;
}

.refund-page .table-refund td {
    border-bottom: 1px solid #d9d9d9;
    line-height: 24px;
    padding: 10px 15px;
}

.refund-page .table-refund tr:last-child td {
    border-bottom: none;
}

.refund-page .table-refund .number-refund {
    width: 100px;
}

.refund-page .table-refund .num-refund {
    word-wrap: break-word;
    width: 83px;
}

.refund-page .table-con .no-data {
    text-align: center;
    color: #999;
    line-height: 60px;
}

.refund-page .table-con {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
}

.refund-page .coursewidth {
    width: 10%;
}
</style>
