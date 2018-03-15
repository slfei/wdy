<template>
	<div class="page-institute-course">

        <jui-header type="back">
            全部课程
        </jui-header>

		<div class="content has-header">
			<div class="section institute-courses mt">
				<div class="section-list course-list">
					<ul class="course-item-wrapper">
						<li class="course-items" v-for="item in tplData.course_list">
							<a href="#">
								<img class="cover" :src="item.course_img" alt="course">
								<div class="title no-wrap"><span>{{ item.course_desc }}</span></div>
								<div class="subtitle no-wrap"><span>{{ item.course_desc }}</span></div>
								<div class="price color-red"><span>¥{{ item.course_cur_price }}</span><span class="oriprice">¥{{ item.course_price }}</span></div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</template>

<style lang="stylus">
	.page-institute-course
		color #333333

	.course-list
		.course-item-wrapper
			padding 0
			margin 0
			.course-items
				background-color #FFF
				list-style-type none
				border-bottom solid 1px #F0F0F0
				a
					display block
					position relative
					padding 32px
					overflow auto
					.cover
						display block
						width 160px
						height 160px
						float left
						margin-right 32px
					.title
						font-size 32px
						line-height 1
					.subtitle
						margin-top 10px
						font-size 24px
						line-height 1
						color #999
					.price
						position absolute
						left 222px
						bottom 32px
						font-size 28px
						line-height 1
						.oriprice
							margin-left 10px
							color #999
							text-decoration line-through

	.color-red
		color #e9314a

	.color-green
		color #3cc382

	.color-orange
		color #ffa759

	.color-grey
		color #999

	.color-white
		color #FFF

	.icon
		vertical-align middle
		font-size 28px
		line-height 28px

	.icon.hd
		margin-right 16px

	.icon.hd:before
		transform scale(1.4)

	.icon.ft
		margin-left 10px

	.middle
		text-align center

	.no-border
		border none

	.no-wrap
		white-space nowrap
		text-overflow ellipsis
		overflow hidden
		font-size initial

</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';

    export default {
        components: {
            JuiHeader
        },
        data(){
            return {
                tplData: $tplData
            }
        },
        created () {
        },
        methods: {
        }
    }
</script>
