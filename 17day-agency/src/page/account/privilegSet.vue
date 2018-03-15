<template>
	<div id="privilegeSet">
		<router-link to="privilege/addnewrole">
		<el-button  class="w-button" style="height:32px;width: 88px; line-height: 0;">{{$t('privilege.btn.add')}}</el-button>
		</router-link>
		<span class="state">{{$t('privilege.tips.only')}}</span>
	<!--权限列表开始-->
    	<section class="rolelist">
    	<el-table
    		class="descript setting-table-style w-table"
    	    :data="tableData"
    	    style="width:1004px;"
            :empty-text="$t('common.btn.noData')">
    	    <el-table-column
    	        prop="role_name"
    	        :label="$t('privilege.data_list.role_list[0]')"
    	        width="175">
    	    </el-table-column>
    	    <el-table-column
    	        prop="role_desc"
    	        :label="$t('privilege.data_list.role_list[1]')"
    	        width="478">
    	    </el-table-column>
    	    <el-table-column
    	        prop="people_num"
    	        :label="$t('privilege.data_list.role_list[2]')"
    	        width="175"
    	        style="text-align: center;">
    	    </el-table-column>
    	    <el-table-column
    	        :label="$t('privilege.data_list.role_list[3]')"
    	        width="175" >
    	        <template scope="scope">

    		        <el-button type="text" size="small" v-if="check(scope.row.role_id)"  @click="connect(scope.row.role_id,scope.row.is_admin)">
    		        	                        {{$t('privilege.btn.manage')}}
    		        </el-button>
    		        <el-button type="text" size="small"  v-if="scope.row.is_default!==1"  @click="changePermission(scope.row.role_id)">
    		        	                       {{$t('privilege.btn.modify')}}
    		        </el-button>
    	        </template>
    	    </el-table-column>
        </el-table>
        </section>
        <!--权限列表结束-->
        <!--角色权限说明-->
         <section class="roleDes">
         	<header>
         		<h4>{{$t('privilege.title')}}</h4> <span>{{$t('privilege.tips.permission')}}</span>
         	</header>
         	<div id="tableWraper">
         	<table  border='1' bordercolor="#dadada" cellspacing="0" >
         		<tr>
         			<td>{{$t('privilege.data_list.role_explain[0]')}}</td>
         			<td></td>
         			<td>{{$t('privilege.data_list.role_explain[1]')}}</td>
         			<td>{{$t('privilege.data_list.role_explain[2]')}}</td>
         			<td>{{$t('privilege.data_list.role_explain[3]')}}</td>
         			<td>{{$t('privilege.data_list.role_explain[4]')}}</td>
         			<td>{{$t('privilege.data_list.role_explain[5]')}}</td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.course_manage.title')}}</td>
         			<td>{{$t('privilege.data_list.course_manage.list[0]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td rowspan="4"></td>
         			<td>{{$t('privilege.data_list.course_manage.list[1]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.course_manage.list[2]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.course_manage.list[3]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.course_manage.list[4]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.marketing_manage.title')}}</td>
         			<td>{{$t('privilege.data_list.marketing_manage.list[0]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td rowspan="3"></td>
         			<td>{{$t('privilege.data_list.marketing_manage.list[1]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.marketing_manage.list[2]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.marketing_manage.list[3]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.finacial_manage.title')}}</td>
         			<td>{{$t('privilege.data_list.finacial_manage.list[0]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td  rowspan="2"></td>
         			<td>{{$t('privilege.data_list.finacial_manage.list[1]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.finacial_manage.list[2]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.account_manage.title')}}</td>
         			<td>{{$t('privilege.data_list.account_manage.list[0]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td rowspan="3"></td>
         			<td>{{$t('privilege.data_list.account_manage.list[1]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>

         			<td>{{$t('privilege.data_list.account_manage.list[2]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td></td>
         			<td></td>
         			<td></td>
         		</tr>
         		<tr>
         			<td>{{$t('privilege.data_list.marketing_manage.list[3]')}}</td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         			<td><i class="el-icon-circle-check"></i></td>
         		</tr>

         	</table>
         	</div>
        </section>
	</div>

</template>

<script>
import * as api from '@/js/api'
import bus from "@/js/eventBus"
export default {
		name:"privilegeSet",
		data(){
            return {
            	tableData:[],
            	currentRole:'',
            	currentAccount:'',
            }
		},
		created(){
			this.initData()
		},
		methods:{
		    initData(){
			    api.roleSet.getrolelist().then(res=>{
			    	//console.log(res)
				  	if(res.status==200){
				  		this.tableData=res.data.data
				  	    this.currentRole=res.data.user_info.role_id
				  	    this.currentAccount=res.data.user_info.account_id
				  	}
			  })
			},
			connect(roleId,isAdmin){ //管理成员

			    this.$router.push({path:'privilege/manage/'+roleId+'/'+isAdmin})
			},
			changePermission(roleId){//修改权限
			   this.$router.push({path:'privilege/change/'+roleId})
			},
			check(role_id){
	        	switch (this.currentRole) {
		            case 1:
		            return true;
		            break;
		            default:
		                switch (role_id) {
		                    case 1:
		                        return false;
		                        break;
		                    case 2:
		                        return false;
		                        break;
		                    default:
		                        return true;
		                        break;
		                }
		                break;
	            }
            }
		},

	}
</script>

<style lang="scss" >
#privilegeSet{
	.descript{
		border-radius: 3px;
	}
	width: 1004px;
	.state{
		display: inline-block;
		margin-left:20px;
		color: #a9a9a9;
		font-size: 12px;
	}
	.rolelist{
		margin-top: 20px;
		width: 1004px;
		.el-button--small{
			font-size: 14px;
		}
		th,td{
			height: 52px;
		}
		td.el-table_1_column_47{
			text-align: center;

		}
		th.el-table_1_column_47{
			text-align: center;
		}
		td.el-table_1_column_3,th.el-table_1_column_3{
			text-align: center;
	    }

	}
	.roleDes{
		margin-top:37px;
		header{
			height: 20px;
		    display: flex;
		    align-items: center;
		    margin-bottom: 20px;

			h4{
				font-size: 20px;
				margin-right: 20px;
			}
			span{
				font-size: 12px;
			}
		}

		table{
	        font-size: 14px;
	        border-collapse: collapse;
	        border-radius: 10px !important;
		    td{
				width: 143px;
				height: 42px;
				text-align: center;
				font-size: 14px;
		    }
			i{
			  color:#30ce6b;
			}

	    }

	}
}
</style>
