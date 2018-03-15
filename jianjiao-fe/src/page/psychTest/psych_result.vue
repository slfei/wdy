<template>
    <div class="page-institute-course">

        <jui-header type="back">
            {{tplData.result.title}}
            <div slot="right">
                <a href="/" class="icon icon-home"></a>
            </div>
        </jui-header>
        <div class="test_result_img">
        </div>
        <div class="result_description">
            <div v-html="tplData.result.description"></div>
        </div>
        <div><a :href="'/quiz/detail/' + tplData.quiz_id" class="btn btn-block btn-test more_test" >再测一次</a></div>
    </div>
</template>

<style lang="stylus">    
    .result_description
        font-size 33px
        font-weight 300
        line-height 54px
        color #333
        background #fff
        border-radius 8px
        padding 30px
        margin 20px
    .more_test
        width 92%
        color #fff
        font-size 34px
        padding 30px 0
        margin 50px auto

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
