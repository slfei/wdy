<template>
    <div class="wrap">
        <div v-for="cat in data">
            <div class="cate-node-header" v-if="cat.child_cat">
                <i class="circle"></i>
                <div class="title">{{ cat.cat_name }}</div>
                <div class="line"></div>
            </div>
            <div class="cate-node-list" v-if="cat.child_cat">
                <a v-for="item in cat.child_cat" :href="item.cat_id | link" class="cate-link">
                    {{ item.cat_name }}
                </a>
            </div>
            <div class="cate-node-list" v-else>
                <a v-for="item in cat" :href="item.cat_id | link" class="cate-link">
                    {{ item.cat_name }}
                </a>
            </div>
        </div>

    </div>
</template>
<style lang="stylus" scoped>
    .cate-node-header
        font-size 28px
        display flex
        height 40px
        line-height 40px
        margin 35px 0 0
        .circle
            display inline-block
            border-radius 50%
            background #E9314A
            width 17px
            height 17px
            margin-top 11px
        .title
            margin 0 15px
        .line
            background #ccc
            height 1px
            flex 1
            margin-top 19px
    .cate-node-list
        margin-top 30px
        display flex
        justify-content space-between
        flex-wrap wrap
    .cate-link
        display inline-block
        height 89px
        line-height 89px
        width 220px
        font-size 30px
        background #fff
        margin 0 0 23px 0
        text-align center
        color #666
        text-decoration none
        &:nth-child(even)
            margin-right 0
</style>
<script>
    export default {
        name: 'cate-nodes',
        props: {
            data: {
                required: true
            }
        },

        filters: {
            link: function(id) {
                return '/institute/category/' + id
            }
        },

        created () {
            console.log(this.data);
        }
    }
</script>
