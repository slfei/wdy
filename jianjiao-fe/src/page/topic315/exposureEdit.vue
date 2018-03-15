
<template>
    <div>
        <div class="exposure_main clearfix">
            <div class="form-group title clearfix">
                    <input type="text" name="" maxlength="20" placeholder="请输入曝光标题" v-model="title">
            </div>
            <div class="form-group">
                    <textarea placeholder="请输入曝光内容" rows="6" v-model="content"></textarea>
            </div>
            <div class="uploadImg">
                <image-uploader
                  :maxCount="3"
                  :files="images" @ievent= 'ievent'
                ></image-uploader>
            </div>
            <div class="form-group">
                    <button class="save_btn"  v-on:click="save()">提交</button>

            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import utils from '@/js/utils';
    import { Toast } from 'mint-ui';
    import ImageUploader from '../../components/ImageUploader.vue';
    import api from '@/js/api';

    export default {
        components: {
            api,
            ImageUploader
        },
        data: function () {
            return {
                 tplData: $tplData,
                 content:$tplData.info.text,
                 title:$tplData.info.title,
                 images: $tplData.info.imgs,
                 imgData:$tplData.info.imgs
            }
        },
        methods: {
            ievent:function(...data){
                console.log("alldata",data)
                this.imgData = Array.from(...data)

            },
            save:function(){
                var result = [];
                var obj = {
                    title:this.title,
                    text: this.content,
                    imgs:this.imgData
                }
                console.log(this.imgData)
                if (!this.title|| !this.content) {
                    Toast('标题/内容不能为空');
                }else{
                    if (this.content.length<200) {
                        Toast('内容不少于200字');
                    }
                    else{
                        if (this.imgData.length==0) {
                            Toast('至少上传一张图片');
                        }
                        else{
                            api.exposure(obj).then(function(suc){
                                Toast("提交成功");
                                location.href='/activity/exposurelist'
                            },function(err){
                                Toast(err);
                            })
                        }
                    }
                }

            }
        },
        created(){

        }
    }
</script>


<style lang="stylus" type="text/stylus">
    textarea
        word-break: break-all;
    #app
        min-height initial
        
        .exposure_main
            margin 40px
            input
                width 100%
                line-height 40px
                padding 16px 20px
                box-sizing border-box
                outline-width 0
                font-size 28px
                border none
            textarea
                border none
                font-size 28px
                line-height 40px
                height 272px
                width 100%
                padding 16px 20px
                resize none
                box-sizing border-box
                outline-width 0
            .form-group
                margin-bottom 30px
                .save_btn
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

</style>

