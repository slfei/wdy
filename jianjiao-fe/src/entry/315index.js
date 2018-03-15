import Vue from 'vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';

import '@/js/topicLogin';
import '@/js/shareWeibo';
import '@/js/base';


import Topic315Login from '@/components/Topic315Login.vue';


Vue.use(Mint);

var app = window.app = new Vue({
    components: {
        Topic315Login
    },
    data: function() {
        return {
            showLogin: false,
        }
    },
    el: '#main',
    methods: {
        login: function () {
            this.showLogin = true;
        },
        toast: function () {
            Mint.Toast('复制成功');
        }
    },
    mounted: function() {
        console.log('mounted',this.$el);
    }
});
