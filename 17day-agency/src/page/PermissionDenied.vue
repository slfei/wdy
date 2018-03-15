<template>
	<div id="permissionDenied" >
		
			<div class="center">
				 <img src="../assets/images/nopermission.png"/>
			     <p>您没有权限查看该页面</p>
			</div>
           
		
	</div>
</template>

<script>
	export default{
		name:"permission",
		data(){
			return {
				
			}
		}
	}
</script>

<style lang="scss" scoped>
#permissionDenied{
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	div.center{
		margin-top: 80px;
		text-align: center;
		display: flex;
		flex-direction: column;
		justify-content: center;
		color: #999;
		font-size: 18px;
		img{
			width:134px;
			height: 139px;
		}
		p{
		 margin:22px 0 0 -30px;
		 font-size: 18px;
		}
	}
	
}
</style>