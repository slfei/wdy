<template>
    <footer>
        <div class="footer-tab">
            <a class="footer-tab-item" href="/" :class="{active : activeIndex == 0}">
                <i class="icon icon-homepage"></i>
                首页
            </a>
            <a class="footer-tab-item" href="/institute/selected" :class="{active : activeIndex == 1}">
                <i class="icon icon-category"></i>
                机构
            </a>
            <a class="footer-tab-item" href="/news/recommend" :class="{active : activeIndex == 2}">
                <i class="icon icon-discovery"></i>
                发现
            </a>
            <a class="footer-tab-item" href="/account/center" :class="{active : activeIndex == 3}">
                <i class="icon icon-user"></i>
                我的
            </a>
        </div>
    </footer>
</template>
<style>
    
</style>
<script>
    var path = location.pathname;

    export default {
        name: 'jui-footer',
        props: {
            index: {
                required: false,
                type: Number
            }
        },
        data(){
            return {
                path: path
            }
        },

        computed: {
            activeIndex () {
                if (typeof this.index === 'number') return this.index;
                if (path.indexOf('/institute') === 0) {
                    return 1
                } else if(path.indexOf('/news') === 0) {
                    return 2
                } else if (path.indexOf('/account')  == 0) {
                    return 3;
                }
                else if (path.indexOf('/circle')  == 0) {
                    return 2;
                }
                else if (path.indexOf('/quiz/list')  == 0) {
                    return 2;
                }
                return 0;
            }
        }

    }
</script>
