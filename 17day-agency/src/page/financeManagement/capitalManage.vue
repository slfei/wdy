<template>
	<div class="main">
		<el-tabs v-model="activeName" class="w-tabs">
	    <el-tab-pane :label="$t('capitalManage.tabs[0]')" name="1">
	    	<div class="detailTip" v-show="activeName=='1'" v-html="$t('capitalManage.incomeTip')">
	  		</div>
	  		<div class="captialInfo">
	  			<span class="infoItem">{{$t('capitalManage.netTotalIncome')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.total_funds}}</span>
	  			<span class="infoItem">{{$t('capitalManage.withdrawSum')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.total_be_with}}</span>
	  			<span class="infoItem">{{$t('capitalManage.remainSum')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.can_with}}</span>
	  			<span v-html="$t('capitalManage.blank')" class="blank"></span>
	  			<!-- <span class="tips" v-show="!isTipShow">{{$t('capitalManage.withdrawTip')}}</span> -->
	  			<el-button type="primary" class="extract" disabled @click="dialogVisible=true">{{$t('capitalManage.withdraw')}}</el-button>
	  		</div>
	  		<el-button class="w-button exportIncome" @click="exportIncome(smallActiveName)">{{$t('capitalManage.exportIncomeList')}}</el-button>
	  		<div class="bill">
	  			<p class="title">{{$t('capitalManage.monthlyIncomeList')}}</p>
	  			<el-tabs v-model="smallActiveName" @tab-click="changeType" class="w-tabs m-tabs" type="card">
	    			<el-tab-pane  :label="$t('capitalManage.smallTabs[0]')" name="1"></el-tab-pane>
						<el-tab-pane  :label="$t('capitalManage.smallTabs[1]')" name="2"></el-tab-pane>
	  			</el-tabs>
	  			<div class="list1">
						<el-row class="list-header">
						  <el-col :span="3">&nbsp&nbsp&nbsp&nbsp&nbsp{{$t('capitalManage.time')}}</el-col>
						  <el-col :span="3">{{$t('capitalManage.successAccount')}}
								<el-popover
                  ref="popover1"
                  placement="top"
                  trigger="hover"
                  >
                  <div>{{$t('capitalManage.successAccountTip')}}</div>
                </el-popover>
                <el-button v-popover:popover1 class="guideIcon">?</el-button>
						  </el-col>
						  <el-col :span="4">{{$t('capitalManage.transactionAmount')}}
								<el-popover
                  ref="popover2"
                  placement="top"
                  trigger="hover"
                  >
                  <div>{{$t('capitalManage.transactionAmountTip')}}</div>
                </el-popover>
                <el-button v-popover:popover2 class="guideIcon">?</el-button>
						  </el-col>
						  <el-col :span="4">{{$t('capitalManage.accesscharge')}}
								<el-popover
                  ref="popover3"
                  placement="top"
                  trigger="hover"
                  >
                  <div v-html="isiOStip[smallActiveName-1]"></div>
                </el-popover>
                <el-button v-popover:popover3 class="guideIcon">?</el-button>
						  </el-col>
						  <el-col :span="4">{{$t('capitalManage.transactionPureAmount')}}
								<el-popover
                  ref="popover4"
                  placement="top"
                  trigger="hover"
                  >
                  <div>{{$t('capitalManage.transactionPureAmountTip')}}</div>
                </el-popover>
                <el-button v-popover:popover4 class="guideIcon">?</el-button>
						  </el-col>
						  <el-col :span="3">{{$t('capitalManage.serviceCharge')}}
								<el-popover
                  ref="popover5"
                  placement="top"
                  trigger="hover"
                  >
                  <div>{{text}}</div>
                </el-popover>
                <el-button v-popover:popover5 class="guideIcon">?</el-button>
						  </el-col>
						  <el-col :span="3">{{$t('capitalManage.netIncome')}}
								<el-popover
                  ref="popover6"
                  placement="top"
                  trigger="hover"
                  >
                  <div>{{$t('capitalManage.netIncomeTip')}}</div>
                </el-popover>
                <el-button v-popover:popover6 class="guideIcon">?</el-button>
						  </el-col>
						</el-row>
						<el-row class="list-content" v-for="item,index in incomeData" :key="index" v-show="!IncomeNodata">
							<el-col :span="3">&nbsp&nbsp&nbsp&nbsp&nbsp{{item.dt}}</el-col>
						  <el-col :span="3">{{item.set_no}}</el-col>
						  <el-col :span="4">{{item.amount/100}}</el-col>
						  <el-col :span="4">{{item.service_charge/100}}</el-col>
						  <el-col :span="4">{{item.net_amount/100}}</el-col>
						  <el-col :span="3">{{item.plat_service_fee/100}}</el-col>
						  <el-col :span="3">{{item.net_income/100}}</el-col>
						</el-row>
						<el-row class="nodata" v-show="IncomeNodata">
							{{$t('common.btn.noData')}}
						</el-row>
  				</div>
  				<div class="pagination" v-show="!IncomeNodata">
					  <el-pagination
					  	class="w-pagination"
			        @current-change="incomeChange"
			        :current-page="incomePage"
			        :page-size="pageSize"
					    layout="prev, pager, next"
					    :total="incomeTotal">
					  </el-pagination>
					</div>
	  		</div>
	    </el-tab-pane>
	    <!-- <el-tab-pane :label="$t('capitalManage.tabs[1]')" name="2">
	  		<div class="captialInfo">
	  			<span class="infoItem">{{$t('capitalManage.netTotalIncome')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.total_funds}}</span>
	  			<span class="infoItem">{{$t('capitalManage.withdrawSum')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.total_be_with}}</span>
	  			<span class="infoItem">{{$t('capitalManage.remainSum')}}：</span>
	  			<span class="money">￥</span>
	  			<span class="infoContent">{{capital.can_with}}</span>
	  			<span v-html="$t('capitalManage.blank')" class="blank"></span>
	  			<span class="tips" v-show="!isTipShow">{{$t('capitalManage.withdrawTip')}}</span>
	  			<el-button type="primary" class="extract" :disabled="isTipShow" @click="dialogVisible=true">{{$t('capitalManage.withdraw')}}</el-button>
	  		</div>
	  		<el-button class="w-button exportBill" @click="exportBill">{{$t('capitalManage.exportBill')}}</el-button>
	  		<div class="list2">
					<el-table
				  class="w-table"
			    :data="withdrawData">
				    <el-table-column
				        prop="transaction_no"
				        :label="$t('capitalManage.labels[0]')"
				        width="185">
				    </el-table-column>
				    <el-table-column
				        prop="actual_amount"
				        :label="$t('capitalManage.labels[1]')"
				        width="230">
				    </el-table-column>
				    <el-table-column
				        prop="created_at"
				        :label="$t('capitalManage.labels[2]')"
				        width="230">
				    </el-table-column>
				    <el-table-column
				        prop="status"
				        :label="$t('capitalManage.labels[3]')"
				        width="137">
				    </el-table-column>
				    <el-table-column
				        prop="updated_at"
				        :label="$t('capitalManage.labels[4]')">
				        <span>11111</span>
				    </el-table-column>
          </el-table>
				</div>
				<div class="pagination" v-show="!withdrawNodata">
				  <el-pagination
				  	class="w-pagination"
		        @current-change="withdrawChange"
		        :current-page="withdrawPage"
		        :page-size="pageSize"
				    layout="prev, pager, next"
				    :total="withdrawTotal">
				  </el-pagination>
				</div>
	    </el-tab-pane>
	    <el-tab-pane :label="$t('capitalManage.tabs[2]')" name="3">
				<div class="info">
			    <div class="title">
				 		{{$t('capitalManage.tabs[2]')}}
				 	</div>
			 		<div class="info-left" v-if="Status!=1001">
					 	<div class="item-right">
					 		<p><span>{{$t('capitalManage.bankInfo[0]')}}</span>{{bank_info.name}}</p>
					 	</div>
					 	<div class="item-right">
					 		<p><span>{{$t('capitalManage.bankInfo[1]')}}</span>{{bank_info.bank_name}}</p>
					 	</div>
					 	<div class="item-right">
					 		<p><span>{{$t('capitalManage.bankInfo[2]')}}</span>{{bank_info.province}} &nbsp;&nbsp;{{bank_info.city}}</p>
					 	</div>
					 		<div class="item-right">
					 		<p><span>{{$t('capitalManage.bankInfo[3]')}}</span>{{bank_info.bank_outlets}}</p>
					 	</div>
					 	<div class="item-right">
					 		<p><span>{{$t('capitalManage.bankInfo[4]')}}</span>{{bank_info.bank_account}}</p>
					 	</div>
					</div>
					<div :class="['button-right',Status==1001?'center':'']">
			 			<el-button type="text" class="btns-pre" :class="[(Status==1001 || Status==1003)?'red':'',Status==200?'green':'']" v-text="msg"></el-button>
			 			<el-button class="w-button" v-if="modifyMsg" v-text="modifyMsg"  @click="goModify">{{$t('capitalManage.modifyInfo')}}</el-button>
		 			</div>
			</div>

	    </el-tab-pane> -->
	    <el-tab-pane :label="$t('capitalManage.tabs[3]')" name="4">
	    	<div class="detail">
	    		{{$t('capitalManage.detail[0]')}}<br>

					<h3>{{$t('capitalManage.detail[1]')}}</h3>

					{{$t('capitalManage.detail[2]')}}<br><br>
					{{$t('capitalManage.detail[3]')}}<br><br>
					{{$t('capitalManage.detail[4]')}}<br><br>
					{{$t('capitalManage.detail[5]')}}<br>
					<p class="explain">
						{{$t('capitalManage.detail[6]')}}<br>
						{{$t('capitalManage.detail[7]')}}<br>
						{{$t('capitalManage.detail[8]')}}<br>
						{{$t('capitalManage.detail[9]')}}<br>
					</p>

					{{$t('capitalManage.detail[10]')}}<br>
					{{$t('capitalManage.detail[11]')}}<br>

					<p class="explain">
					{{$t('capitalManage.detail[12]')}}<br>
					</p>
					{{$t('capitalManage.detail[13]')}}<br>
				</div>
	    </el-tab-pane>
	  </el-tabs>
	  <el-dialog
      :title="$t('capitalManage.withdrawRequest')"
      custom-class="w-dialog"
      :visible.sync="dialogVisible">
			<el-form label-position="right" label-width="100px" :rules="rules" :model="formData" ref="form">
				<el-form-item :label="$t('capitalManage.btnLabel[0]')" :inline="true">
				  <span class="Withdraw" >￥{{capital.can_with || 0}}</span>
				</el-form-item>
				<el-form-item :label="$t('capitalManage.btnLabel[1]')" :inline="true" prop="money">
				  <el-input  v-model="formData.money" style="width: 195px;" :placeholder="$t('capitalManage.PH')"></el-input> {{$t('capitalManage.RMB')}} <span class="tips"> {{$t('capitalManage.btnTip')}} </span>
				</el-form-item>
			</el-form>
		    <span slot="footer" class="dialog-footer">
			  	<el-button type="primary" @click="submit">{{$t('capitalManage.btn[0]')}}</el-button>
			    <el-button @click="cancel">{{$t('capitalManage.btn[1]')}}</el-button>
		    </span>
		</el-dialog>
	</div>
</template>
<script>
import * as api from '@/js/api'
export default {
	mounted(){
		this.init();
	},
	data() {
		return {
			isiOStip:[this.$t('capitalManage.accesschargeTip[0]'),this.$t('capitalManage.accesschargeTip[1]')],
			text:'',
			incomeData:[],
			withdrawData:[],
			iscurrentType:'',
			currentType:'',
			activeName:'1',
			smallActiveName:'1',
			isTipShow:true,
			IncomeNodata:false,
			withdrawNodata:false,
			incomePage:1,
			withdrawPage:1,
			pageSize:10,
			incomeTotal:0,
			withdrawTotal:0,
			Status:'',
			capital:{
				total_funds:0,  //总提取金额
				can_with:0,     //可提取金额
				total_be_with:0 //总金额
			},
			bank_info:{},
			modifyMsg:'',
			msg:'',
			dialogVisible:false,
			formData: {
				money:'',
			},
			rules:{
				money:[
					{validator:(rule, value, callback)=>{
						if(value > this.capital.can_with) {
							callback(this.$t('capitalManage.error[0]'))
						} else if(value == parseFloat(value) && (parseFloat(value).toFixed(2) - value) != 0) {
							callback(this.$t('capitalManage.error[1]'))
						} else if(!value){
							callback(this.$t('capitalManage.error[2]'))
						} else if(Number(value)!=value){
							callback(this.$t('capitalManage.error[3]'))
						} else{
							callback()
						}
					},trigger: 'blur'},
				]
			},

		}
	},
	methods: {
		changeType() {
			this.incomePage = 1;
			this.getIncomeList();
		},
		incomeChange(page) {
			this.incomePage = page;
			this.getIncomeList();
		},
		withdrawChange(page) {
			this.withdrawPage = page;
			this.getWithdrawList();
		},
		init() {
			api.capital.getCapital().then((res)=>{
				this.capital=res.data.capital;
			})
			api.capital.getAccountInfo().then((res)=>{
				this.text = res.data.text;
				console.log(res)
			})
			api.capital.getBankInfo().then((res)=>{
				this.bank_info = res.data.bank_info;
				this.Status = res.status;
				this.msg = res.msg
				this.checkStatus(res.status)
			})
			this.getIncomeList();
			this.getWithdrawList();
		},
		checkStatus(val){
			switch(val){
				case 1001: this.msg = this.$t('capitalManage.msg[0]'); this.modifyMsg = this.$t('capitalManage.goTo[0]');break;
				case 1002: this.msg = this.$t('capitalManage.msg[1]'); this.modifyMsg = "" ; break;
				case 1003: this.msg = this.$t('capitalManage.msg[2]'); this.modifyMsg = this.$t('capitalManage.goTo[1]');break;
				case 200:  this.msg = this.$t('capitalManage.msg[3]'); this.modifyMsg = "" ; this.isTipShow = false;break;
			}
		},
		goModify(){
     	api.common.checkCurrenttype().then(res=>{
        this.iscurrentType = res.data.type;
					if(this.iscurrentType==1){
						var isfirst = '';
          	if(this.msg == this.$t('capitalManage.msg[0]')){
          		isfirst = 'create'
          	}else if (this.msg == this.$t('capitalManage.msg[2]')){
          		isfirst = 'modify'
          	}
						this.$router.push({name:'personalAccount', params: { isfirst }})
            } else {
            	var isfirst = '';
            	if(this.msg == this.$t('capitalManage.msg[0]')){
            		isfirst = 'create'
            	}else if(this.msg == this.$t('capitalManage.msg[2]')){
            		isfirst = 'modify'
            	}
						this.$router.push({name:'instituteAccount', params: { isfirst }})
					}
				})
    },
    cancel() {
    	this.dialogVisible = false;
    	this.formData.money = '';
    },
    submit() {
    	this.$refs["form"].validate((valid) => {
    		if(valid) {
    			api.capital.withdraw({money:this.formData.money}).then((res)=>{
						this.dialogVisible = false;
						this.init();
					})
    		}
    	})
    },
    getIncomeList() {
    	api.capital.incomelist({type:this.smallActiveName,page_size:this.pageSize,page_num:this.incomePage}).then((res)=>{
				console.log(res )
				this.incomeData = res.data.data;
				this.incomeTotal = res.data.total;
				res.data.total == 0 ? this.IncomeNodata = true: this.IncomeNodata = false;
			})
    },
    getWithdrawList() {
			api.capital.getWithdrawList({page_size:this.pageSize,page_num:this.withdrawPage}).then((res)=>{
				this.withdrawData = res.data.data;
				this.withdrawTotal = res.data.total;
				res.data.total == 0 ? this.withdrawNodata = true : this.withdrawNodata = false;
				this.withdrawData.forEach((val)=>{
					val.status == 1 ? val.status = this.$t('capitalManage.withdrawStatus[0]'): val.status = this.$t('capitalManage.withdrawStatus[1]');
					val.actual_amount = val.actual_amount/100;
				})
			})
    },
    exportBill() {
    	location.href = '/api/excel/withlist';
    },
    exportIncome(smallActiveName) {
    	location.href = `/api/excel/incomelist?type=${smallActiveName}`
    },
	}

}
</script>
<style scoped>
.guideIcon{
	border:1px solid #333;
	font-size:10px;
	color: #333 !important;
	height: 14px;
	width: 14px;
	vertical-align: middle;
	line-height: 10px;
	border-radius: 50%;
	padding: 0 2px;
}
</style>
<style lang="styl" scoped>
.main
	.detailTip
		font-size 14px
		color #999
		line-height 20px
	.captialInfo
		height 72px
		border 1px solid #d9d9d9
		line-height 72px
		border-radius 4px
		margin-top 30px
		margin-bottom 25px
		.infoItem
			margin-left 10px
			margin-right -3px
		.money
			margin-right -7px
		.infoContent
			font-size 14px
		.blank
			visibility hidden
		.tips
			color #a7a7a7
		.extract
			float right
			margin-right 40px
			margin-top 18px
	.exportIncome
		float right
		a
			color #268fff
	.bill
		margin-top 0px
		.title
			line-height 30px
			text-align center
			border-bottom 1px dashed #999
			margin-top 65px
		.list1
			border 1px solid #d9d9d9
			line-height 55px
			.list-header
				background #f5f5f5
				height 55px
			.list-content
				height 55px
			.list-content.el-row
				border-top 1px solid #d9d9d9
			.list-content.el-row:hover
				background #eef1f6
				cursor pointer
			.nodata
				text-align center
				height 55px
				color #999
			.pagination
				text-align center
				margin-top 30px
	.exportBill
		float right
	a
		color #268fff
	.list2
		margin-top 80px
		line-height 55px
		.list-header
			background #f5f5f5
			height 55px
		.list-content
			height 55px
	.pagination
		text-align center
		margin-top 30px
	.detail
		line-height 30px
		font-size 16px
		margin-bottom 100px
		.explain
			background #fff4ee
			color #ff6600
			padding 15px

	.info
		margin-top 30px
		border 1px solid #d9d9d9
		border-radius 4px
		width 1000px
		.title
			background #F5F5F5
			border-bottom 1px solid #d9d9d9
			height 55px
			line-height 55px
			padding-left 30px
			font-size 18px
		.info-left
			width 600px
			display inline-block
			.item-right
				p
					padding 0 10px
					color #999
					span
						color #333
						text-align right
						display inline-block
						width 80px
						padding-right 20px
		.button-right
			padding 30px
			width 390px
			height 164px
			display inline-block
			vertical-align top
			text-align center
			.btns-pre
				line-height 40px
				width 100%
				font-size 16px
				margin-bottom -10px
			.red
				color #ff1818
			.green
				color #5bd584
		.center
			text-align center
			width 1000px !important
	.tips
		color #999
		margin-left 10px
</style>
