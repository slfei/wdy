<template>
	<div class="page-institute-teacher">

        <jui-header type="back">
            全部老师
        </jui-header>

		<div class="content has-header">
			<div class="section institute-teachers mt">
				<div class="section-list teacher-list">
					<ul class="teacher-item-wrapper clearfix">
						<li class="teacher-items clearfix" v-for="item in tplData.teacher_list">
							<a href="javascript:;">
								<img class="cover" :src="item.teacher_avatar_url" alt="teacher">
								<div class="name"><span>{{ item.teacher_name }}</span></div>
								<div class="subject"><span>{{ item.course_name }}</span></div>
								<div class="label"><span>6年教龄</span><span>教师资格证</span></div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</template>

<style lang="stylus">
	.page-institute-teacher
		color #333333

	.teacher-list
		.teacher-item-wrapper
			padding 0
			margin 0
			.teacher-items
				background-color #FFF
				list-style-type none
				border-bottom solid 1px #F0F0F0
				a
					display block
					position relative
					padding 28px 20px
					overflow auto
					.cover
						display block
						width 116px
						height 116px
						float left
						border-radius 50%
						margin-right 32px
					.name
						font-size 32px
						line-height 1
					.subject
						margin-top 6px
						font-size 24px
						line-height 1.2
						color #999
						padding-bottom 36px
					.label
						position absolute
						left 168px
						bottom 32px
						height 32px
						span
							display inline-block
							margin-right 16px
							padding 3px 8px 0
							color #999
							font-size 20px
							line-height 29px
							border 1px solid #ccc
							border-radius 16px

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
