<template>
<div class="main">
	<div class="head">
		<el-button class="add-course" type="primary" @click="addCourse">创建课程</el-button>
	</div>
	<div class="content">
		<el-tabs v-model="activeName" @tab-click="handleClick">
	    <el-tab-pane :label="'全部课程' + num.all_course" name="1"></el-tab-pane>
	    <el-tab-pane :label="'编辑中' + num.offline_num" name="2"></el-tab-pane>
	    <el-tab-pane :label="'审核中' + num.pending_num" name="3"></el-tab-pane>
	    <el-tab-pane :label="'审核通过在线' + num.offline_num" name="4"></el-tab-pane>
	    <el-tab-pane :label="'审核不通过' + num.offline_num" name="5"></el-tab-pane>
	    <el-tab-pane :label="'已下线' + num.adopt_num" name="6"></el-tab-pane>
  	</el-tabs>

  	<div class="list">
			<el-table
      :data="courseList"
      style="width: 100%">
      <el-table-column
        label="课程信息"
        width="500">
        <template slot-scope="scope">
          <div class="course-info">
            <img :src="scope.row.course_img" class="avatar"/>
            <div class="right">
              <div class="name">{{ scope.row.course_name }}</div>
            </div>
          </div>
       </template>
      </el-table-column>
      <el-table-column
        label="价格"
        prop="price">
      </el-table-column>
      <el-table-column
        label="审核状态">
        <template slot-scope="scope">
          <div class="status">
          	<div v-if="scope.row.is_delete == 1" class="offline">已下架</div>
						<div v-else-if="scope.row.audit_status == 0" class="edit">编辑中</div>
						<div v-else-if="scope.row.audit_status == 1" class="review">审核中</div>
						<div v-else-if="scope.row.audit_status == 2" class="pass">审核通过在线</div>
						<div v-else-if="scope.row.audit_status == 3" class="fail">审核不通过<el-button type="primary" style="margin-left: 10px">查看原因</el-button></div>
          </div>
       </template>
      </el-table-column>
      <el-table-column
        label="最近更新时间"
        prop="updated_at">
      </el-table-column>
      <el-table-column
        label="操作"
      >
        <template slot-scope="scope">
          <el-button type="text" @click="offLine(scope.row.course_id)" v-if="scope.row.audit_status == 2 ">下线</el-button>
          <el-button type="text" @click="editCourse(scope.row.course_id)" v-if="scope.row.audit_status != 0 ">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>
		<el-pagination
			v-show="total"
			style="text-align: center;margin-top: 40px;"
    	layout="prev, pager, next"
    	class="w-pagination"
    	:total="total"
    	:page-size="page_size"
    	:current-page="page_num"
    	@current-change="changepage">
  	</el-pagination>
  	</div>
	</div>
</div>
</template>
<script>
import api from '@/js/api/course'
export default{
	data(){
		return{
			activeName:'1',
			total:1,
			page_num:1,
			page_size:10,
			courseList:[],
			num:{	adopt_num:0,
						all_course:0,
						edit_num:0,
						offline_num:0,
						pending_num:0,
				},
		}
	},
	mounted(){
		this.getNum();
		this.getList();
	},
	methods:{
		addCourse() {
			this.$router.push({path:'/courseInfo'});
		},
		handleClick() {
			console.log(this.activeName)
			if(this.activeName == 1) {
				this.getList();
			} else if (this.activeName <= 5 ) {
				this.getList({
					page_num:this.page_num,
					page_size:this.page_size,
					audit_status:Number(this.activeName) - 2,
				});
			} else if ( this.activeName == 6) {
				this.getList({
					page_num:this.page_num,
					page_size:this.page_size,
					is_show:1,
				});
			}
		},
		changepage(page) {
			this.page_num = page;
			console.log(pege)
			this.handleClick();
		},
		getList(params) {
			api.getList({page_size:10}).then((res)=>{
				console.log(res)
				this.courseList = res.list;
				this.total = res.total;
			})
		},
		offLine(id) {
			api.offLine({course_id:id}).then((res)=>{
				console.log(res)
				this.$router.push({path:'/course'});
			})
		},
		editCourse(id) {
			this.$router.push({name:'courseInfo',params:{id}});
		},
		getNum() {
			api.getNum().then((res)=>{
				console.log(res)
				this.num = res;
			})
		}
 	}
}
</script>
<style lang="styl" scoped>
.main
	background #f5f5f5
	.head
		height 80px
		line-height 80px
		background #fff
		.add-course
			margin-left 40px
	.content
		margin-top 20px
		background #fff
		padding 10px
		.course-info
			font-size 14px
			.avatar
				float left
				height 60px
				width 100px
			.right
				float left
				.name
					margin 10px 0 0 10px
					width 300px
					word-warp break-word
.pass
	color #47d98c
</style>