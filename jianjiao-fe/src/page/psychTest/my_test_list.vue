<template>
    <div>
        <jui-header type="back">
            我的测试列表
            <div slot="right">
                <a href="/" class="icon icon-home"></a>
            </div>
        </jui-header>

        <div class="content has-header">
            <div class="no_test_data" v-if="tplData.list.length===0">
                 <p>您还未有任何测试，赶快去测试吧</p>
                <a href="/quiz/list" class="btn  btn-test go_test">
                    去测试
                </a>
            </div>
            <div class="test-list">
                <ul class="">
                    <li class="clearfix" v-for="item in tplData.list">
                        <a :href="'/quiz/result/' + item.id">
                            <div class="test_img"><img class="" :src="item.cover_pic" alt="course"></div>
                            <div class="test_intro">
                                <h3>{{ item.title }}</h3>
                                <div class="test_count">{{ item.time }}测过</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<style lang="stylus">
    .no_test_data
        font-size 34px
        color #333
        text-align center
        margin-top 150px

    .go_test
        color #fff
        font-size 34px
        margin-top 30px
        border-radius 15px
        
    .test_img
        float left
        img 
            float left
            width 250px
            height 160px
            margin-right 20px

    .test-list
        ul
            li
                margin 40px 20px
                padding 0px 20px 0 0
                cursor pointer
                background #fff
                h3
                    font-size 27px
                    font-weight 400
                    margin-top 30px
                    height 39px
                    line-height 39px

    .test_count
        color #a9acb1
        font-size 26px
        margin-top 50px


</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';

    export default {
        components: {
            JuiHeader
        },
        data(){
            console.log($tplData.list)
            return {
                tplData: $tplData
            }
        },
        created () {
        },
        methods: {}
    }
</script>
