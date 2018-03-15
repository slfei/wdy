<template>
    <div class="loading-wrap" v-show="isShow">
        <img :src="loadingImg" alt=""/>
    </div>
</template>
<script>
    export default {
        name: 'loading',
        props:{
            isShow:{
                type:Boolean,
                defaule:false
            }
        },
        data(){
            return {
                loadingImg:require('@/assets/loading.gif')
            }
        }
    }
</script>
<style>
    .loading-wrap{
        position: fixed;
        top:0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color:rgba(255,255,255,.3) ;
        z-index: 9999;

    }
    .loading-wrap img{
        position: absolute;
        left: 50%;
        margin-left: -50px;
        top: 50%;
        margin-top: -50px;

    }
</style>
