<template>
	<div class="homepage">
		<el-row :gutter="50" class="top">
			<el-col :span="15" >
				<div class="part-left">
					<h3 class="title">待办事项</h3>
					<div>
						<ul class="task">
							<li v-if="todoData.info_finished < 1">
								<div>门店信息完整度：<span class="red">30%</span></div>
								<el-button type="primary" @click="">完善门店信息</el-button>
							</li>
							<li v-if="todoData.no_course">
								<div>还没有上传课程 <i class="el-icon-warning"></i></div>
								<el-button type="primary" @click="">添加课程</el-button>
							</li>
							<li v-if="todoData.has_notice">
								<div class="blue">有新的评价信息</div>
								<el-button type="primary" @click="">马上回复</el-button>
							</li>
						</ul>
					</div>
				</div>
			</el-col>
			<el-col :span="8" >
				<div class="part-right">
					<div class="info">
						<div class="first">
							<img :src="insData.institute_img">
							<ul>
								<li>{{insData.institute_name}}</li>
								<li>主营类目:<span>{{insData.category}}</span></li>
								<li>电话:<span>{{insData.phone}}</span></li>
								<li>地址:<span>{{insData.address}}</span></li>
							</ul>
						</div>
						<div class="second">
							<div>
								<div class="red-col"></div>
								<span class="num red-color">{{insData.teacher_num}}</span>
								<span class="word">位老师</span>
							</div>
							<div>
								<div class="blue-col"></div>
								<span class="num blue-color">{{insData.course_num}}</span>
								<span class="word">个课程</span>
							</div>
						</div>
						<el-button type="primary" class="check-mainpage" @click="checkMainPage">查看主页</el-button>
					</div>
				</div>
			</el-col>
		</el-row>
		<el-row :gutter="50" class="bottom">
			<el-col :span="15" >
				<div class="part-left">
					<h3 class="title">关键数据展示</h3>
					<div class="center">
						该功能正在快马加鞭研发中，敬请期待~
					</div>
				</div>
			</el-col>
			<el-col :span="8" >
				<div class="part-right">
					<div>
						<h3 class="title">公告</h3>
						<span class="all" @click="checkall">查看全部 ></span>
					</div>
					<ul>
						<li v-for="item in announceData">
							<span>{{item.title}}</span>
							<i class="el-icon-arrow-right icon"></i>
						</li>
					</ul>

				</div>
			</el-col>
		</el-row>

	</div>
</template>
<script>
import api from '@/js/api/homepage'

export default {
	mounted(){
		this.init();
	},
	data(){
		return{
			insData:{},
			todoData:{},
			announceData:{},
		}
	},
	methods:{
		init() {
			api.insInfo().then((res)=>{
				console.log(res)
				this.insData = res;
			})
			api.announce().then((res)=>{
				console.log(res)
				this.announceData = res;
			})
			api.todo().then((res)=>{
				console.log(res)
				this.todoData = res;
			})
		},
		checkall() {

		},
		checkMainPage() {

		},
	}
}
</script>
<style lang="stylus" scoped>
.red-color
	color #e9314a
.blue-color
	color #268fff
.homepage
	background-color #f5f5f5
	.top
		.part-left
			height 400px
			background-color #fff
			.title
				height 80px
				line-height 80px
				padding 0 0 0 30px
				margin-top 0
				border-bottom 3px solid #f5f5f5
			.task
				padding-left 20px
				li
					line-height 70px
					div
						display inline-block
						width 240px
						font-size 16px
						font-weight 500
						.red
							color #e9314a
							font-size 24px
							margin-left 5px
						i
							color #ff983c
					.blue
						color #268fff
		.part-right
			height 400px
			background-color #fff
			padding 0 40px
			.info
				height 125px
				.first
					padding-top 40px
					img
						height 120px
						width 120px
						display inline-block
					ul
						margin-left 20px
						display inline-block
						li
							line-height 30px
							height 30px
							font-weight bold
							span
								color #999
								margin-left 10px
								font-weight normal
						li:nth-of-type(1)
							line-height 30px
							font-size 22px
							margin-bottom 10px
				.second
					margin-top 20px
					div
						display inline-block
						height 45px
						width 100px
						.red-col
							display inline-block
							width 10px
							background-color #e9314a
							float left
						.num
							font-size 22px
							float left
							margin-left 10px
							display inline-block
						.word
							display inline-block
							font-size 14px
							height 18px
							width 60px
							color #999
							float left
							margin-left 10px
						.blue-col
							display inline-block
							width 10px
							background-color #268fff
							float left
				.check-mainpage
					margin-top 30px



	.bottom
		margin-top 20px
		.part-left
			height 400px
			background-color #fff
			.title
				height 80px
				line-height 80px
				padding-left 30px
				margin-top 0
				border-bottom 3px solid #f5f5f5
			.center
				line-height 300px
				text-align center
				color #999
				vertical-align middle
		.part-right
			height 400px
			background-color #fff
			div
				height 80px
				line-height 80px
				border-bottom 3px solid #f5f5f5
				.title
					display inline-block
					padding 0 0 0 30px
					margin-top 0
				.all
					display inline-block
					float right
					margin-right 30px
					font-size 16px
					font-weight 600
			ul
				line-height 50px
				padding 0 20px
				li
					height 50px
					span
						width 90%
						height 50px
						display inline-block
						overflow hidden
						text-overflow ellipsis
					.icon
						color #fff
						background-color #268fff
						border-radius 50%
						float right
						margin-top 18px
</style>