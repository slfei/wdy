<template>
	<div id="mangeMember">
		<select-layer
			 @hideSelect="hideSelect(0)"
			 v-if="showtype"
			 :dialog-visible="showtype"
			:data-val="dataVal"
			 @addRole="addRole">
		</select-layer>
		<header>
			<router-link to="/privilegset">
			    <div  @click="back">
			    	<span class="el-icon-arrow-left "></span>{{$t('common.btn.return')}}
			    </div>
		   </router-link>
		   <el-button v-if="isAdmin!=1" @click="showtype=true" class="w-button" style="height: 32px;width: 88px;line-height: 0;">{{$t('privilege.btn.add')}}</el-button>
		</header>
		<div v-if="isAdmin==1" class="title">{{$t('privilege.manage.tips')}}</div>
    	<section class="rolelist">
    		<el-table :data="memberData" style="width:100%;" class="w-table" :empty-text="$t('common.btn.noData')">
    		      <el-table-column prop="account_name" :label="$t('privilege.manage.name')" align="left">
    			        <template scope="scope">
    				        <img :src="scope.row.avatar" class="headerimg"/>
    				        <span style="margin-left: 10px">{{scope.row.account_name }}</span>
    			        </template>
    		      </el-table-column>
    		       <el-table-column  :label="$t('privilege.manage.edit')" align="center" >
    				    <template scope="scope">
    				        <el-button @click="deleMember(scope.row)" type="text" size="small" v-if="checkSelf(scope.row.account_id)">{{$t('common.btn.delete')}}</el-button>
    				    </template>
    		    </el-table-column>
    	    </el-table>
        </section>

        <!--  分页器start-->
		<div class="pagination">
		  <el-pagination
		  	  class="w-pagination"
	          @current-change="handleCurrentChange"
	          :current-page="currentPage"
	          :page-sizes="[10, 20, 30, 40]"
	          :page-size="pageSize"
		      layout="prev, pager, next"
		      :total="total">
		  </el-pagination>
		</div>
	    <!--  分页器end-->
	</div>
</template>

<script>
 import * as api from '@/js/api'
 import selectLayer from "./selectLayer"
 export default {
		name:"manageMember",
		data(){

			return {
				keywords:"",
				dataListAll:"",
				dataVal:[],
				showtype:false,
				memberData:[],
				currentPage: 1,//默认显示第一页
		        total:0,//总数据量，初始化为0
		        pageSize: 10,//每页默认展示10条数据
		        roleId:'',
		        isAdmin:0,
		        currentRole:'',
		    	currentAccount:'',
			}
		},
		created(){
			this.initData()
		},
		methods:{
			 initData(){
			 	this.roleId=this.$route.params.role_id
			 	this.isAdmin=this.$route.params.is_admin
			 	//console.log(this.isAdmin)
			 	api.roleSet.roleaccount({
			 		role_id:this.roleId,
			        page_num:this.currentPage,
			        page_size:this.pageSize
			 	}).then(res=>{
			 		if(res.status==200){
				 		this.memberData=res.data.data
	 			 		this.total=res.data.total
	 			 		this.currentRole=res.data.user_info.role_id;
		  	            this.currentAccount=res.data.user_info.account_id;

			 		}else{
			 			this.$message.error(res.msg);
			 		}

			 	});
			 	api.roleSet.addRoleMember({role_id:this.roleId}).then(res=>{
			 		//console.log(res)
			 		if(res.status==200){
			 			this.dataVal=res.data.account_list
			 		}

			 	})
			 },
			 deleMember(row){
			    api.roleSet.delRoleaccount({role_id:this.roleId,account_id:row.account_id}).then(res=>{
                    this.initData()
		 	     })
			 },
			 addRole(data){
			 	this.dataListAll=data;
			 	if(this.dataListAll.length){
			 	api.roleSet.addRoleMemberSuc({
			 		role_id:this.roleId,
			 		account_ids:this.dataListAll
			 	}).then(res=>{
			 		this.initData()
			 	})
			 	}

			 },
		     handleCurrentChange(val) {
		        this.currentPage=val
		        this.initData()
			 },
			 hideSelect(type){
  			    this.showtype=type
  		     },
  		     back(){
  		     	this.$router.go(-1)
  		     },
  		     checkSelf(accountId){
  		     	if(accountId==this.currentAccount){
  		     		return false;
  		     	}else if(this.isAdmin==1){
  		     		return false
  		     	}else{
  		     		return true
  		     	}
  		     }

		  },
		  components:{
  		      selectLayer
     	  }

	}
</script>

<style lang="scss">
#mangeMember{
	width: 1004px;
	overflow: hidden;
	.headerimg{
 	width: 25px;
 	height: 25px;
 	border-radius: 50%;
 	vertical-align: middle;
 }
  a{
  	text-decoration: none;
  	color:#268FFF;
   }
   .title{
   	font-size: 14px;
   	margin-bottom: 10px;

   }
	header{
		color: #268fff;
		display: flex;
		justify-content: space-between;
		font-size: 14px;
		align-items: center;
		margin-bottom: 20px;
		margin-top: 20px;
		div{
			display:flex;
		    justify-content: flex-start;
			align-items:center;
			vertical-align: middle;
		  }
		span.el-icon-arrow-left{
			font-size: 18px !important;
			transform: scale(0.6);
			color:#268FFF;
			vertical-align: middle;
		}
	}
	.el-table.w-table .el-table__header-wrapper th:last-child .cell{
		padding: 0 !important;
	}
	.pagination{
   	   width: 1004px;
   	   text-align: center;
   	   margin-top: 20px;
   	 .el-pagination{
   	 	display: inline-block;
   	 }
   }
	}
</style>
