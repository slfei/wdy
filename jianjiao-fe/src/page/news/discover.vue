<template>
    <div class="page-discover">
        <discovery-header>
        </discovery-header>
        <div class="page-bd has-header has-footer">
            <jui-showcase :data="tplData.list"
                          :page="tplData.page"
                          loadMoreUrl="/api/news/discoverylist"
                          :loadMoreParams="{'catid': tplData.news_cat.cat_id}"
            ></jui-showcase>
        </div>

        <jui-footer></jui-footer>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiShowcase from '../../components/Showcase.vue';
    import JuiFooter from '@/components/Footer.vue';
    import discoveryHeader from "../../components/discoverHeader.vue";
        export default {
            components: {
                JuiShowcase,
                JuiFooter,
                discoveryHeader
            },
            data: function () {
                return {
                    tplData: $tplData,
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
</style>
