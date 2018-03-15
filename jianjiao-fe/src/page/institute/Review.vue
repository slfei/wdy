<template>
	<div class="page-institute-review">

        <jui-header type="back">
            机构评价
        </jui-header>

		<div class="content has-header">
			<div class="section institute-reviews">
				<div class="section-hd">
					<a href="#all" class="button" :class="{'active' : !this.onlyHasImages}" v-on:click="toggleIfHasImages($event,1)">全部({{ all_comment_num }})</a>
					<a href="#withimage" class="button" :class="{'active' : this.onlyHasImages}" v-on:click="toggleIfHasImages($event,0)">带图({{ img_comment_num }})</a>
				</div>
				<div v-infinite-scroll="loadMore" infinite-scroll-disabled="loading" infinite-scroll-distance="10">
					<div v-if="comment_count == -1" class="loading">加载中...</div>
					<CommentList v-else type="institute" v-on:showLightbox="showLightbox" :id="tplData.institute_id" :list="comment_list"></CommentList>
				</div>
			</div>
		</div>

		<div id="lightbox" :class="{'show' : this.lightboxShow}" v-on:click="hideLightbox($event)">
			<mt-swipe @change="lightboxChange" :auto="0" :show-indicators="false" :continuous="false" id="lightbox-container">
				<mt-swipe-item v-for="item in lightboxImages">
					<img v-if="typeof item == 'string'" class="lightbox-img" :src=item >
					<img v-else class="lightbox-img" :src="item.img || item.img_url" >
				</mt-swipe-item>
			</mt-swipe>
			<div class="lightbox-index">{{lightboxIndex + 1}}/{{lightboxImages.length}}</div>
		</div>

	</div>
</template>

<style lang="stylus">
	.page-institute-review
		color #333333

	.institute-reviews
		.section-hd
			padding 24px
			.button
				display inline-block
				margin-right 24px
				font-size 24px
				line-height 48px
				padding 0 24px
				border-radius 24px
				background-color #FFF
			.button.active
				color #FFF
				background-color #e9314a

	.loading
		font-size 28px
		line-height 2
		text-align center

	#lightbox
		display none
		position fixed
		left 0
		top 0
		width 100%
		height 100%
		z-index 100000
		background-color rgba(0,0,0,0)
		pointer-events none
		transition background-color .5s

		.lightbox-index
			position absolute
			left 0
			bottom 0
			width 100%
			text-align center
			font-size 32px
			line-height 64px
			z-index 233
			color #FFF
			background-color rgba(0,0,0,.8)
			opacity 0
			transition opacity .3s

		.mint-swipe
			position absolute
			left 0
			top 0
			width 100%
			height 100%
			opacity 0
			transition all .3s

			.mint-swipe-items-wrap
				position relative
				overflow hidden
				height 100%

				.mint-swipe-item
					position absolute
					transform translateX(-100%)
					width 100%
					height 100%
					display none

					.lightbox-img
						width 100%
						height 100%
						object-fit contain

				.mint-swipe-item.is-active
					display block
					transform none

	#lightbox.show
		pointer-events all
		background-color rgba(0,0,0,.8)
		.lightbox-index
			opacity 1
		.mint-swipe
			opacity 1
			width 100% !important
			height 100% !important
			left 0 !important
			top 0 !important
</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';
    import CommentList from '../../components/CommentList.vue';
    import { InfiniteScroll, Swipe, SwipeItem, Toast } from 'mint-ui';
    import api from '../../js/api';

	Vue.use(InfiniteScroll);
    Vue.component(Toast.name, Toast);
    Vue.component(Swipe.name, Swipe);
    Vue.component(SwipeItem.name, SwipeItem);

    export default {
        components: {
            JuiHeader,
            CommentList
        },
        data(){
            return {
                tplData: $tplData,
				lightboxImages: [],
				lightboxShow: false,
				lightboxIndex: 0,
            	onlyHasImages: false,
            	loading: false,
            	all_comment_num: 0,
            	img_comment_num: 0,
            	comment_list: [],
            	comment_count: -1
            }
        },
        created () {
        },
        methods: {
	        toggleIfHasImages: function(event, all) {
				if (event) {
					event.preventDefault();
				}
	        	this.onlyHasImages = all?false:true;
	        	this.comment_list = [];
	        	this.comment_count = -1;
	        	this.loadMore();
	            return false;
	        },
	        loadMore() {
				this.loading = true;
				if(!this.onlyHasImages && this.comment_count >= this.all_comment_num) {
					return;
				} else if(this.onlyHasImages && this.comment_count >= this.img_comment_num) {
					return;
				}
				let self = this;
                api.getCommentList('institute', this.tplData.institute_id, this.onlyHasImages, this.comment_count)
	                .then(function (data) {
	                	self.loading = false;
	                	data.comment_list.forEach(function(item){
	                		self.comment_list.push(item);
	                	}); 
	                	self.all_comment_num = data.all_comment_num;
	                	self.img_comment_num = data.img_comment_num;
						self.comment_count = self.comment_list.length;
	                }, function (err) {
	                    Toast(err);
	                });
			},
	        showLightbox: function(images, event) {
	        	if(document.getElementById("lightbox").style.display == "block") {
	        		return;
	        	}
	        	let size = event.target.getBoundingClientRect();
	        	let ele = document.getElementById("lightbox-container");
	        	ele.style.width = size.width + 'px';
	        	ele.style.height = size.height + 'px';
	        	ele.style.top = size.top + 'px';
	        	ele.style.left = size.left + 'px';
	        	document.getElementById("lightbox").style.display = "block";
	        	this.lightboxImages = images;
				this.lightboxIndex = 0;
	        	let self = this;
	        	document.body.classList.add('scroll-disabled');
	        	requestAnimationFrame(function(){
	        		self.lightboxShow = true;
	        	});
	        },
			lightboxChange(index) {
				this.lightboxIndex = index;
			},
	        hideLightbox: function(event) {
	        	this.lightboxShow = false;
	        	setTimeout(function(){
	        		document.body.classList.remove('scroll-disabled');
	        		document.getElementById("lightbox").style.display = "none";
	        	},500);
	        }
        }
    }
</script>
