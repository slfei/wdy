<template>
<div>
    <div class="topic-li" @click="go_detail(item.question_id)">
        <h3 v-html="item.question_content"></h3>
        <div>
            <div v-if="!isEmpty">
                <div class="answer-img" v-if="item.answer_info.img_counts>0">
                    <img :src="item.answer_info.img[0]">
                </div>
            <div class="answer-content" v-html="item.answer_info.answer_part_content"></div>
            </div>

            <div v-if="showlabel" class="topic-label">
                <span v-if='showres'>尖椒圈子 · </span>
                <span>{{ item.views || 0 }}看过 · </span>
                <span>{{ item.answer_info && item.add_time.slice(5) }}</span>
                <a class="border-q">问答</a>
            </div>
        </div>
        <!--<div class="margin-top topic-label" v-else>
            暂无回答
        </div>-->
        <div v-if="question_detail" class="topic-label">
            <span>{{item.answer_count}}回答 · </span> <span>{{item.focus_count}}收藏 · </span> {{item.view_count}}浏览
        </div>
    </div>
</div>
</template>



<script type="text/ecmascript-6">
    export default {
        props: {
            item: {
                required: true,
                type: Object
            },
            showres: {
                type: Boolean
            },
            showlabel: {
                type: Boolean
            },
            question_detail: {
                type: Boolean
            }
        },
        computed:{
            isEmpty() {
                var obj = this.item.answer_info;
                if (obj == null) return true;
                if(Array.isArray(obj)) { return obj.length === 0}
                return Object.keys(obj).length === 0;
            }
        },
        methods: {
            go_detail: function(id){
                window.location.href = '/circle/question/detail/' + id;

            }
        }
    }
</script>


<style lang="stylus">
        .topic-li
            border-bottom 1px solid #f5f5f5
            padding 30px 20px
            background #fff
            h3
                font-size 32px  
                line-height 45px 
                color #333
                font-weight 500
            .answer-img
                width 100%
                height 330px
                overflow hidden
                margin 15px 0px 20px 0px
                img
                    width 100%
                    margin 0px
            .answer-content
                font-size 28px
                color rgba(69, 69, 69, 0.93)
                line-height 43px
                margin 15px 0px 20px 
            .topic-label
                display flex
                font-size 27px
                color #999
                align-items center
                .border-q
                    color #268fff
                    padding 6px 9px
                    border 1px solid #268fff
                    border-radius 10px
                    margin-left 10px
            .margin-top
                margin-top 30px
</style>
