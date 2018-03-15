<template>
	<div class="header">
		<div class="logo">
		</div>
		<div class="action">
			<span class="info">欢迎你 聂笠~</span>
			<span class="exit">退出</span>
			<span class="front">前台页面</span>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return{

			}
		}
	}
</script>
<style lang="stylus" scoped>
.header
	padding 0
	height 60px
	line-height 60px
	font-size 14px
	color #268fff
	width 100%
	float left
	.logo
		height 60px
		width 12.5%
		min-width 210px
		display inline-block
		background url('../assets/images/logo.png') no-repeat
		background-position center center
.action
	float right
	width 25%
	height 60px
	display inline-block !important
.info
	color #333
	margin-right 40px
	font-weight 600
	font-size 20px
	display inline-block
.exit
	margin-right 60px
	background url('../assets/images/logout.png') no-repeat
	background-position left
	padding-left 20px
	display inline-block
.front
	margin-right 60px
	background url('../assets/images/front.png') no-repeat
	background-position left
	padding-left 20px
	display inline-block


</style>