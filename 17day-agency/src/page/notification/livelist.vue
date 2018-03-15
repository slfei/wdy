<template>
    <div class="page-noti" v-if="!isLoading">
        <el-breadcrumb separator=">">
            <el-breadcrumb-item :to="{ path: '/' }">{{$t('notification.mainPage')}}</el-breadcrumb-item>
            <el-breadcrumb-item>{{$t('notification.todayWork')}}</el-breadcrumb-item>

        </el-breadcrumb>
        <div class="title">{{$t('notification.todayWork')}}</div>
        <div class="noti-box">
            <div v-for="item in list">
                <div class="clearfix">
                    <div class="pull-left">
                        {{ item.content }}
                    </div>
                    <div class="pull-right item-desc">
                        {{ item.create_time }}
                    </div>
                </div>
            </div>
        </div>

        <div class="ft-wrapper">
            <el-pagination
                layout="prev, pager, next"
                :total="total"
                :page-size="page_size"
                :current-page="page_num"
                @current-change="onPageChange">
            </el-pagination>
        </div>

    </div>
</template>

<script>
import * as api from "@/js/api"
import { Breadcrumb, BreadcrumbItem } from 'element-ui'

export default {
    components: {
        Breadcrumb,
        BreadcrumbItem
    },
    data(){
        return {
            list: [],
            total: 0,
            isLoading: true,
            page_size: 10,
            page_num: 1
        }
    },
    created(){
        this.getData()
    },
    methods: {
        getData(){
            this.isLoading = true;
            return api.notification.livelist({
                page_size: this.page_size,
                page_num: this.page_num
            }).then((data)=>{
                this.list = data.data;
                this.total = data.total;
                this.isLoading = false;
            })
        },
        onPageChange(i){
            // console.log(i);
            this.page_num = i;
            this.getData();
        }
    }
}
</script>

<style lang="stylus">
.page-noti
    .el-breadcrumb
        margin 40px 0

    .title
        font-size 20px
        color #333
        text-align center

    .noti-box
        color #333
        padding 20px
        width 840px
        margin auto
        border 1px solid #d9d9d9
        margin-top 20px
        margin-bottom 40px
        border-radius 3px
        line-height 40px

    .ft-wrapper
        text-align center
        margin-bottom 80px

    .item-desc
        color #999
</style>
