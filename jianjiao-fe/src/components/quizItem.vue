<template>

<div class="clearfix quiz-item">
    <a :href="'/quiz/detail/' + item.id">
        <div class="quiz-title">
            <h3>{{ item.title }}</h3>
        </div>
        <div class="test_img"><img class="" :src="item.cover_pic" alt="course"></div>
        <div class="test_intro">
            <div class="test_count">尖椒心理测试 · {{ item.total_test }}人测过 ·  {{ item.created_at.split(' ')[0].slice(5) }}</div>
        </div>
    </a>
</div>
</template>

<style lang="stylus">
    .quiz-item
        padding 30px 20px
        border-bottom 1px solid #f0f0f0
        .test_img
            width 100%
            margin-top 15px
            img
                width 100%

        .quiz-title
            h3
                font-size 32px
                font-weight 500
                margin-bottom 30px

        .test_intro
            color #999
            font-size 27px
            margin-top 30px
</style>
<script>

    export default {
        name: 'quiz-item',
        props: ['item']
    }
</script>
