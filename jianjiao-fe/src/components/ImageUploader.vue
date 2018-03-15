<template>
    <div class="comment-imagewrapper">

    <vue-clip ref="vc" :options="options" :on-added-file="addedFile" :on-sending="sending" :on-complete="complete" :on-max-files="maxFilesReached">

        <template slot="clip-uploader-body">
            <div class="comment-imageitem" :class="{'waiting' : file.customAttributes.status == 'waiting', 'sending' : file.customAttributes.status == 'sending','failed' : file.customAttributes.status == 'failed','finished' : file.customAttributes.status == 'finished'}" v-if="file.customAttributes.status != 'removed'" v-for="(file,k) in images">
                <img v-bind:src="file.dataUrl" />
                <div class="removeButton" v-on:click="removeImage(file,true)">✕</div>
            </div>
        </template>

        <template slot="clip-uploader-action">
            <div class="comment-imageitem dz-message">
                <i class="icon ion-plus-round"></i>
                <div class="comment-imagecount">{{ images.length }}/3</div>
            </div>
        </template>

    </vue-clip>

    </div>
</template>


<style lang="stylus">
    .comment-imagewrapper
         background-color #f0f0f0
         overflow auto
         padding 16px 0
         margin-top -32px
         .comment-imageitem.waiting:after
             content '等待上传'
         .comment-imageitem.sending:after
             content '上传中'
         .comment-imageitem.failed:after
             content '上传错误'
         .comment-imageitem.waiting
             background #000
             img
                 opacity .5
         .comment-imageitem.sending
             background #000
             img
                 opacity .5
         .comment-imageitem.failed
             background #000
             img
                 opacity .5
         .comment-imageitem:after
             position absolute
             display block
             pointer-events none
             content ''
             top 0
             left 0
             width 100%
             text-align center
             font-size 28px
             color #FFF
             font-weight bold
             line-height 160px
             line-height calc(33vw - 42px)
         .comment-imageitem
             float left
             position relative
             width 160px
             // width calc(33vw - 42px)
             height 160px
             // height calc(33vw - 42px)
             margin 16px 26px 16px 0
             background-color #FFF
             text-align center
             .removeButton
                 position absolute
                 width 64px
                 height 64px
                 top 0
                 right 0
                 line-height 64px
                 font-size 48px
                 text-align center
                 font-weight bold
                 color #FFF
                 background rgba(0,0,0,.8)
             .icon
                 color #999
                 font-size 64px
                 line-height 160px
                 pointer-events none
             img
                 width 100%
                 height 100%
                 object-fit cover
             .comment-imagecount
                 position absolute
                 right 16px
                 bottom 8px
                 color #999
                 font-size 24px
                 line-height 30px
                 pointer-events none

     .comment-controls
         background-color #FFF
         height 100vh
         transition transform .5s ease-in

         .comment-ratetitle
             margin 0
             padding 0 32px
             font-size 28px
             font-weight normal
             line-height 84px
             border-bottom solid 1px #F0F0F0

         .comment-ratelist
             padding-top 16px
             li.comment-rateitem
                 padding 0 32px
                 font-size 28px
                 line-height 60px
                 .comment-rate
                     color #999
                     margin-right 6px
                 .comment-ratestars
                     color #999
                     margin-right 6px
                     .icon
                         font-size 32px
                         margin 8px
                         transform scale(1.5)
         .comment-submit
             padding 32px

         .comment-button
             display block
             position relative
             border none
             outline-width 0
             width 100%
             height 88px
             font-size 28px
             line-height 88px
             background-color #e9314a
             border-radius 44px
             color #FFF

         .comment-button.disabled
             opacity .6
             pointer-events none

         .comment-button.disabled.hide
             opacity 0

         .comment-finish
             text-align center
             opacity 0
             transition opacity .5s ease-in
             .comment-thanks
                 font-size 28px
                 line-height 48px
                 padding-bottom 24px
                 .icon
                     margin-right 12px
                     transform scale(1.5)
             .comment-button
                 display inline-block
                 font-size 24px
                 line-height 56px
                 height 56px
                 border-radius 28px
                 width 160px
             .comment-sepline
                 margin-top 36px
                 height 10px
                 background-color #F0F0F0
             .comment-recommendtitle
                 position relative
                 margin 0
                 padding 0 32px
                 font-size 28px
                 font-weight normal
                 line-height 84px
                 color #999
                 span
                     position relative
                     padding 0 16px
                     background-color #FFF
             .comment-recommendtitle:before
                 content ''
                 position absolute
                 left 32px
                 right 32px
                 top 41px
                 width auto
                 border-bottom solid 1px #999
</style>



<script type="text/ecmascript-6">
import Vue from 'vue'
import VueClip from 'vue-clip'
import { Toast } from 'mint-ui';
Vue.use(VueClip)

export default {
  name: 'ImageUploader',
  props: {
    maxCount: {
      type: Number,
      default: 3
    },
    files:{
        default: Array
    },
    default: 3
  },

  data() {
    return {
      type: 1,
      text: '',
      images: [],
      imageCount: 0,
      options: {
        url: '/api/universal/uploadimage',
        paramName: 'image',
        maxFilesize: {
          limit: 3,
          message: '图片大小不能大于{{ maxFilesize }}MB！'
        },
        maxFiles: {
          limit: 3,
          message: '您最多只能上传3张图片'
        },
        acceptedFiles: {
          extensions: ['image/*'],
          message: '只允许上传图片！'
        },
        parallelUploads: 3
      }
    }
  },
  created() {
    console.log('files',this.files)
    // console.log(this.value);
    function transform(value) {
      var images = [];
      if (value && !Array.isArray(value)) {
      images = [{
        customAttributes: {
          status: 'finished',
          url: value
        },
        dataUrl: value
      }];
    } else {
      for (var i = 0, l = value.length; i < l; i++) {
        images.push({
          customAttributes: {
            status: 'finished',
            url: value[i]
          },
          dataUrl: value[i]
        })
      }
    }
      return images;
    }

    this.images = transform(this.files);
    this.$watch('files', function(value) { this.images = transform(value)})
  },
  methods: {
    addedFile (file) {
        file.addAttribute('status', 'waiting');
        file.addAttribute('url', '');
        console.log('imageCount',this.images)
        if(this.images.length >= 3) {
            return;
        } else if (!file.type.startsWith('image')) {
            file.addAttribute('status', 'failed');
            Toast('只允许上传图片！');
        } else if (file.size > 4096000) {
            Toast('图片大小不能大于4MB！');
        } else {
            this.images.push(file);
        }
    },
    sending(file, xhr, formData) {
      file.customAttributes.status = 'sending';
    },
    complete(file, status, xhr) {
      if (xhr && xhr.response) {
        let res = JSON.parse(xhr.response);
        if (res.status != 200) {
          // Toast('网络错误！');
          file.customAttributes.status = 'failed';
        } else {
          file.customAttributes.status = 'finished';
          file.customAttributes.url = res.data.url || '';
        }
      } else {
        // Toast('网络错误！');
        file.customAttributes.status = 'failed';
      }
      this.onChange();
      this.$forceUpdate();
    },
    maxFilesReached(file) {
      // this.removeImage(file);
      Toast('您最多只能上传' + this.maxCount + '张图片！');
    },
    removeImage(file, forceUpdate) {
      // 真实的图片， 删除
      if (file.type) {
        this.$refs.vc.removeFile(file);
      }

      var index = this.images.indexOf(file);
      this.images.splice(index, 1);

      file.customAttributes.status = 'removed';
      if(forceUpdate){
        this.onChange();
      }
    },
    onChange() {
      var result = [];

      for (let i = 0; i < this.images.length; i += 1) {
        if (this.images[i].customAttributes.status == 'sending') {
          // this.$vux.toast.show({
          //   text: '您有图片正在上传，请等待上传结束'
          //   });
          // Toast('您有图片正在上传，请等待上传结束！');
          return;
        } else if (this.images[i].customAttributes.status == 'failed') {
          this.removeImage(this.images[i]);
        } else if (this.images[i].customAttributes.status == 'finished') {
          result.push(this.images[i].customAttributes.url);
          console.log('Array URL',this.images[i].customAttributes.url)
        }
      }
      // this.files = result;
      // console.log(this.files);
      this.$emit('ievent',result);
      // this.$emit("input", this.maxCount === 1 ? (result[0] || '') : result);
    }
  }
}
</script>
