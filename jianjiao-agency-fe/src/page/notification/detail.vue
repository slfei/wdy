<template>
<div v-if="!isLoading" class="noti-detail">
    <el-breadcrumb separator=">">
        <el-breadcrumb-item :to="{ path: '/' }">{{$t('notification.mainPage')}}</el-breadcrumb-item>
        <el-breadcrumb-item to="/notification">{{$t('notification.notice')}}</el-breadcrumb-item>
        <el-breadcrumb-item>{{$t('notification.noticeDetail')}}</el-breadcrumb-item>
    </el-breadcrumb>
    <div class="noti-box">
        <router-link class="link" to="/notification">{{$t('notification.backToList')}}</router-link>
        <div class="title">
            {{ data.title }}
        </div>
        <div class="time">
            {{ data.updated_at }}
        </div>
        <div class="content" v-html="data.content">
        </div>
    </div>
</div>
</template>

<script>
import * as api from "@/js/api"
import {
    Breadcrumb,
    BreadcrumbItem
} from 'element-ui'

export default {
    components: {
        Breadcrumb,
        BreadcrumbItem
    },
    data() {
        return {
            data: {},
            isLoading: true
        }
    },
    created() {

        this.getData()
    },
    watch: {
        '$route' () {
            this.getData()
        }
    },
    methods: {
        getData() {
            var id = this.$route.params.id;
            return api.notification.detail(id).then((data) => {
                this.data = data;
                this.isLoading = false;
            })
        }
    }
}
</script>

<style lang="stylus">
    img
        max-width 800px

    .noti-detail
        .el-breadcrumb
            margin 40px 0

    .noti-box
        border 1px solid #d9d9d9
        border-radius 3px
        width 840px
        padding 20px
        margin 40px auto 80px

        .link
            color #008aff
            margin-bottom 10px

        .title
            font-size 20px
            text-align center
            margin 10px 0 20px

        .time
            font-size 12px
            text-align center
            color #999
            margin-bottom 40px

        .content
            font-size 14px
            color #333
            img
                width 100%

</style>
