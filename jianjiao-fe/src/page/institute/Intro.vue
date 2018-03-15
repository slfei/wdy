<template>
	<div class="page-institute-intro">

		<jui-header type="back">
            {{ tplData.title }}
        </jui-header>

		<div class="content has-header">
			<div class="section institute-intro">
				<div class="intro-text" v-html="tplData.intro">
				</div>
			</div>
		</div>

	</div>
</template>

<style lang="stylus">
	.page-institute-intro
		color #333333

	.intro-text
		padding 32px
		font-size 32px
		line-height 1.5
		text-align justify
		p
			margin-top 0
			margin-bottom 48px

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
