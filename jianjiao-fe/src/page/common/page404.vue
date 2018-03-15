<template>
    <div class="page404">
        <div class="server-error-image">
        </div>
        <div class="intro">
            <p>你迷路了</p>
        </div>
        <div class="back_index">
            <a href="/" class="btn btn-primary btn-middle" @click="goHome($event)">返回首页</a>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">

    export default {
        methods: {
            goHome (e) {
                if (window.isReactNative) {
                    window.postMessage(JSON.stringify({
                        action: 'MainNav',
                        data: {}
                    }));
                    e.preventDefault();
                }
            }
        }
    }

</script>

<style lang="stylus">
    .intro p
        text-align center
        color #999
        font-size 32px
        
    .back_index
        width 240px
        margin 30px auto
        
    .page404
        background #fff
        padding:80px 0 600px
</style>
