<template>
    <ul v-if="data.length > 0">
        <mt-cell-swipe
            @click.native="clickItem(item)"
            v-for="(item, i) in data" class="org-item" :right="operable ? [{
                content: '删除',
                style: { background: '#E9314A', color: '#fff' },
                handler:  function() {
                    deleteItem(item, i);
                }
            }]: []">
                <div class="logo-container">
                    <div class="logo-main">
                        <div>
                            <img :src="item.cover_pic"/>
                        </div>
                    </div>
                </div>
                <div class="info-container">
                    <div class="title">{{ item.institute_name }}</div>
                    <p class="sub-title">
                        {{ item.teacher_num }}位老师/{{ item.comment_num }}条评论
                    </p>

                    <span class="tag"> {{ item.shopping_district_name }}</span>
                    <span class="tag"> {{ item.label }}</span>
                </div>
                <div class="score-container">
                    <em class="score">{{ item.rank }}分</em>
                    <p class="distance">{{ item.distance }}</p>
                </div>
        </mt-cell-swipe>
    </ul>
    <div v-else class="no-result">
        <slot name="empty">
            <i class="icon icon-no-result"></i>
            <div class="text">空空如也</div>
        </slot>
    </div>
</template>
<style lang="stylus">
    ul, li
        margin 0
        padding 0
    .org-item
        background #fff
        display flex
        padding 30px
        border-top 2px solid #f0f0f0
        .logo-main
            width 160px
            height 160px
            padding 0 23px 0 0
            img
                width 100%
                height 100%

        .title
            color #333
            font-size 32px
            line-height 48px
        .sub-title
            margin 0
            line-height 48px
            font-size 24px
            color #999
            margin-bottom 30px

        .tag
            display inline-block
            padding 0 16px
            background #fff
            color #999
            border 1px solid #ccc/*no*/
            margin-top 2px
            border-radius 20px
            margin-right 9px
            height 41px
            line-height 41px
            font-size 24px
        .score
            display block
            margin-top 100px
            font-style normal
            font-size 32px
            color #E9314A
            text-align right
        .distance
            line-height 48px
            font-size 22px
            text-align right
            color #999
            margin 0
        &:last-child
            border-bottom none


    .info-container
        flex 1
    .score-container
        width 1.8rem
        text-align center


    .mint-cell-title
        display none
    .mint-cell-value
        display flex
        width 100%

    .mint-cell-wrapper
        padding 0
        background none!important

    .mint-navbar .mint-tab-item.is-selected
        border-bottom 4px solid #26a2ff
</style>
<script type="text/ecmascript-6">
    import { CellSwipe as MtCellSwipe, Toast } from 'mint-ui';
    import api from '@/js/api';

    export default {
        name: 'institute-list',
        components: {
            MtCellSwipe
        },
        props: {
            data: {
                type: Array,
                required: true
            },
            operable: {
                type: Boolean
            }
        },
        data: function () {
            return {
                swipeRightOpt: [
                    {
                        content: '删除',
                        style: { background: '#E9314A', color: '#fff' },
                        handler: (e) => {
                            //console.log(e)
                            //this.$emit('deleteInstitute', )
                        }
                    }
                ]
            }
        },

        methods: {
            deleteItem: function (item, i) {
                var self = this;
                api.removeCollection('institute', item.institute_id).then(function () {
                    self.data.splice(i, 1);
                }, function (err) {
                    Toast(err);
                });
            },
            clickItem (item) {

                console.log(item.institute_id)
                window.location.href = '/institute/detail/' + item.institute_id;
            }
        }
    }
</script>
