<template>
    <div>
        <jui-header type="back">机构校区</jui-header>
        <div class="has-header campus-list">
            <cell
                v-for="item in tplData.campus_list"
                :title="item.address"
                :to="'/institute/address/'+item.id + '?lat=' + item.lat + '&lon=' + item.lon"
                is-link>
                <i class="icon ion-ios-location-outline color-red hd" slot="icon"></i>
            </cell>
        </div>
    </div>
</template>


<style lang="stylus">

    .hd-name, .ft-name
        padding 32px
        padding-right 0
        float left
        color #333
        font-size 28px
        line-height 36px
        max-width 80%


    .hd-more, .ft-more
        padding 32px
        float right
        color #999
        font-size 24px
        line-height 36px

     .icon.hd
         margin-right 16px

    .color-red
        color #e9314a

    .campus-list
        font-size 14px

    .no-wrap,.mint-cell-title
        white-space nowrap
        text-overflow ellipsis
        overflow hidden
</style>


<script>
    import JuiHeader  from '@/components/Header.vue'
    import { Cell } from 'mint-ui'

    export default {
        components: {
            JuiHeader,
            Cell
        },
        data: function () {
            return {
                tplData: $tplData
            }
        }
    }
</script>
