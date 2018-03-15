<template>
    <div>
  ·      <div class="share-container">
            <div class="flex-1">
                <div class="icon-wrapper">
                    <span class="icon icon-sina"></span>
                </div>
                <div>
                    分享到微博
                </div>
            </div>
            <div class="flex-1">
                <div class="icon-wrapper">
                    <span class="icon icon-qzone"></span>
                </div>
                <div>
                    分享到空间
                </div>
            </div>

            <span class="icon icon-close" ></span>
        </div>
        <!--<div class="jiathis_style_m"></div>-->



        <!--<a class="bds_mshare" data-cmd="mshare"></a>-->
        <!--<a class="bds_qzone" data-cmd="qzone" href="#"></a>-->
        <!--<a class="bds_tsina" data-cmd="tsina"></a>-->
        <!--<a class="bds_baidu" data-cmd="baidu"></a>-->
        <!--<a class="bds_renren" data-cmd="renren"></a>-->
        <!--<a class="bds_tqq" data-cmd="tqq"></a>-->
        <!--<a class="bds_more" data-cmd="more">更多</a>-->
        <!--<a class="bds_count" data-cmd="count"></a>-->
    </div>


</template>


<style lang="stylus">
    .share-container
        font-size 28px
        color #333
        text-align center

        .flex-1
            float left
            width 50%

        .icon-wrapper
            display inline-block
            width 120px
            height 120px
            border-radius 60px
            border 1px solid #ccc
            margin-top 56px

</style>


<script>
    window._bd_share_config = {
        common : {
            bdText : '自定义分享内容',
            bdDesc : '自定义分享摘要',
            bdUrl : '自定义分享url地址',
            bdPic : '自定义分享图片'
        },
        share : [{
            "bdSize" : 16,
            viewList : ['qzone','tsina','huaban','tqq','renren']
        }],
        slide : [{
            bdImg : 0,
            bdPos : "right",
            bdTop : 100
        }],
        image : [{
            viewType : 'list',
            viewPos : 'top',
            viewColor : 'black',
            viewSize : '16',
            viewList : ['qzone','tsina','huaban','tqq','renren']
        }],
        selectShare : [{
            "bdselectMiniList" : ['qzone','tqq','kaixin001','bdxc','tqf']
        }]
    };

    var jiathis_config={
        sm:"tsina,qzone",
        summary:"",
        shortUrl:false,
        hideMore:true
    }

    var jsSDKSrc = 'http://v3.jiathis.com/code_mini/jia.js';
    (document.getElementsByTagName('head')[0] || body).appendChild(document.createElement('script')).src = jsSDKSrc + '?cdnversion=' + ~(-new Date() / 36e5)


    export default {
        name: 'bd-share'
    }
</script>
