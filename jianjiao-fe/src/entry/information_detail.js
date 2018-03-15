import Vue from 'vue';
import Page from '../page/news/detail.vue';
import 'mint-ui/lib/style.css';
import '@/js/base';

new Vue({
    el: '#main',
    render: h => h(Page)
});