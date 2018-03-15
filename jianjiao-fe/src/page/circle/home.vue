<template>
    <div class="page-institute-course">
        <discovery-header>
        </discovery-header>
        <div class="circle_content has-header">
            <jui-topic :data="circle_hot_question" :showres='false' :showlabel='true' :page="tplData.page" loadMoreUrl="/api/circle/home">
            </jui-topic>
        </div>
        <jui-footer></jui-footer>
    </div>
</template>



<script type="text/ecmascript-6">
    import JuiTopic from '../../components/TopicCircle.vue';
    import JuiFooter from '@/components/Footer.vue';
    import discoveryHeader from "../../components/discoverHeader.vue";
        export default {
            components: {
                JuiTopic,
                JuiFooter,
                discoveryHeader
            },
            data: function () {
                $tplData["news_cat"] = {cat_id: 8,cat_name: "话题圈子"};
                return {
                    tplData:$tplData,
                    circle_hot_question: $tplData.list,
                    isDropDownOpen: false
                }
            }
        }
</script>

<style lang="stylus">
    .page-discover
        .no-result
            margin-top 100px

        .page-bd
            margin-top 12px
            background #F0F0F0
    .circle_content
        margin 15px 0px 30px
</style>
