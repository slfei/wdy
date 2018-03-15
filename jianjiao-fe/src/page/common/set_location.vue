<template>
    <div>
        <jui-header type="back">选择地区</jui-header>
        <div class="has-header">

            <div class="section section-gray">
                <div class="sec-hd">定位城市</div>
                <div class="sec-bd">
                    <a @click="setArea(tplData.cur_city.cityid)"
                       class="btn btn-large" v-if="tplData.cur_city">
                        {{ tplData.cur_city.name }}
                    </a>
                    <div v-else class="no-result">
                        <span class="ion-sad-outline"></span>未能获取到您的位置，请手动选择您所在的城市
                    </div>
                </div>
            </div>

            <!--<div class="section section-gray">-->
                <!--<div class="sec-hd">常用城市</div>-->
                <!--<div class="sec-bd">-->

                <!--</div>-->
            <!--</div>-->


            <div class="section section-gray hot-city">
                <div class="sec-hd">热门城市</div>
                <div class="sec-bd">
                    <a @click="setArea(item.cityid)"
                       class="btn btn-large" v-for="(item, k) in tplData.hot">
                        {{ item.name }}
                    </a>
                </div>
            </div>


            <div class="section" v-for="(item, k) in tplData.list">
                <div class="sec-hd">{{ k }}</div>
                <div class="sec-bd">
                    <mt-cell @click.native="setArea(_item.cityid)"
                             :title="_item.name" v-for="(_item, _k) in item"></mt-cell>
                </div>
            </div>
        </div>
    </div>
</template>


<style lang="stylus">
    .section
        .no-result
            font-size 24px
            color #999
            margin 6px 0 15px
            text-align left

        &.section-gray

            .ion-sad-outline
                color #E9314A
                margin-right 10px
                font-size 40px
                position relative
                top 4px

            .sec-hd
                color #999

            .sec-bd
                padding 0 30px

                .btn
                    margin-right 30px
                    margin-bottom 20px

                .btn-large
                    line-height 75px
                    height 75px
                    width 200px
                    box-sizing border-box

                &.hot-city
                    margin-right -30px

        .sec-hd
            font-size 32px
            line-height 70px
            padding 0 30px




        .mint-cell-wrapper

            padding 0 30px
            font-size 32px
</style>

<script>
    import JuiHeader from '../../components/Header.vue';
    import utils from '../../js/utils';

    export default {
        components: {
            JuiHeader
        },
        data: function () {
            return {
                tplData: $tplData
            }
        },
        methods: {
            setArea: function (id) {
                // alert(id)
                window.location.href = ( utils.getParameterByName('ref') || '/' ) + '?cid=' + id;
            }
        }
    }
</script>
