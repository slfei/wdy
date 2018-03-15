<template>
	<div class="page-institute-address">

        <jui-header type="back">
        	机构位置
        </jui-header>

		<div class="content has-header">
			<div class="section institute-map">
				<div id="map-container"></div>
				<div id="path-container"></div>
			</div>
		</div>

	</div>
</template>

<style lang="stylus">

	.content
		box-sizing border-box
		height 100vh

		.institute-map
			position relative
			height 100%
			#map-container
				position relative
				height 100%
			#path-container
				position absolute
				top 0
				height 100%

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

	.marker
		width 64px
		height 64px
		transform translate(-32px,-32px)
		object-fit cover
		border-radius 50%
		border 6px solid #FFF
		background-color #FFF
		box-shadow 0 0 16px rgba(0,0,0,.5)

	.infoWindow
		position relative
		width 380px
		height 80px
		border-radius 4px
		box-shadow 0 0 16px rgba(0,0,0,.5)
		background-color #FFF
		.info
			padding 12px
			.title
				font-size 24px
				line-height 32px
			.address
				font-size 16px
				line-height 24px
				color #999
		.direct
			.icon
				margin-right 6px
			display block
			float right
			width 120px
			height 80px
			font-size 24px
			line-height 80px
			background-color #e9314a
			border-radius 0 4px 4px 0
			color #FFF
			text-align center

	.infoWindow:after
		content '▼'
		position absolute
		bottom -24px
		left 174px
		font-size 32px
		line-height 32px
		color #FFF
		text-shadow 0 8px 8px rgba(0,0,0,.3)

	[data-dpr="2"] .amap-toolbar
	[data-dpr="3"] .amap-toolbar
		transform: scale(2) translateY(10px)
		transform-origin right top

	.amap-scalecontrol
		transform scale(1.5)
		transform-origin left top

</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';
    import utils from '@/js/utils';

	let map;

	const lat = $tplData.lat;
	const lon = $tplData.lon;

    export default {
        components: {
            JuiHeader
        },
        data(){
            return {
				entering: false
			}
        },
        mounted () {
        	map = new window.AMap.Map('map-container', {
		  		zoom: 16,
		  		center: [lon, lat]
			});

			window.AMap.plugin(['AMap.ToolBar','AMap.Scale'],
			    function(){
        			map.addControl(new window.AMap.ToolBar({position:'RT',isOpen:true,locate:true,noIpLocate:true}));
			        map.addControl(new window.AMap.Scale({position:'LT',isOpen:true}));
				}
			);

			/*
			var marker=new window.AMap.Marker({
		        position:[lon, lat],
			    content: '<img class="marker" src="http://www.edana.org/images/default-source/newsroom-images-library01/img-training-courses.jpg?sfvrsn=0">',
		        map:map
		    });
		    */

			var infoWindow = new window.AMap.InfoWindow({
			    isCustom: true,
			    content: `<div class="infoWindow">
						    <a href="http://maps.apple.com/?sll=${lon},${lat}" class="direct"><i class="icon ion-android-navigate"></i>导航</a>
						    <div class="info"><div class="title no-wrap">${$tplData.name}</div>
						    <div class="address no-wrap">${$tplData.address}</div></div></div>`,
			    offset: new AMap.Pixel(0, -100)
			});
			infoWindow.open(map, [lon, lat]);

		},
        created () {
        },
        methods: {
	        getWalking: function() {
				window.AMap.service('AMap.Walking',function() {
					var trans;
					var transOptions = {
					    map: map,
					    panel: "result1",
					    policy: window.AMap.TransferPolicy.LEAST_TIME
					};
					trans = new window.AMap.Transfer(transOptions);
					trans.search([116.39, 39.9], [116.391, 39.91]);
				})
	        },
	        getTransfer: function() {
				window.AMap.service('AMap.Transfer',function() {
					let trans;
					let transOptions = {
					    map: map,
					    panel: 'path-container',
					    city: '北京市',
					    policy: window.AMap.TransferPolicy.LEAST_TIME
					};
					trans = new window.AMap.Transfer(transOptions);
					trans.search([116.39, 39.9], [116.391, 39.91]);
				})
	        },
	        getDriving: function() {

	        }
        }
    }
</script>
