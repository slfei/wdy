<template>
    <div class="page-institute-course">
        <discovery-header>
        </discovery-header>
        <div class="quiz-content has-header clearfix">
            <quiz-list :data='tplData.list'  :page="tplData.page" loadMoreUrl="/api/quiz/list"></quiz-list>
        </div>
        <jui-footer></jui-footer>

    </div>
</template>
<style lang="stylus">
    .quiz-content
        margin-bottom 120px
    
</style>
<script type="text/ecmascript-6">
    import Vue from 'vue';
    import discoveryHeader from "../../components/discoverHeader.vue";
    import quizList from "../../components/quizList.vue";
    import JuiFooter from '@/components/Footer.vue';
    export default {
        components: {
            discoveryHeader,
            quizList,
            JuiFooter
        },
        data(){
            console.log($tplData.list);
            $tplData["news_cat"] = {cat_id: 9,cat_name: "心理测试"};
            console.log($tplData)
            return {
                tplData: $tplData
            }
        },
        created () {
        },
        methods: {}
    }
</script>
