<template>
    <Topic315-login v-show="loginVisible"></Topic315-login>
</template>


<script type="text/ecmascript-6">
    import Topic315Login from '../../components/Topic315Login.vue';
    export default {
        components: {
            Topic315Login
        },
        data: function () {
            return {
                loginVisible: false,
            }
        },
        methods: {
            show: function() {
                console.log(this.loginVisible)
            }
        },
        created() {
        }
    }

</script>

<!--<style lang="stylus">-->
<style lang="stylus" type="text/stylus">

</style>
