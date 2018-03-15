import Vue from 'vue';
import Page from '../page/topic315/prizeList.vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import '@/js/base';

import '@/js/topicLogin';


Vue.use(Mint);

new Vue({
    el: '#main',
    render: h => h(Page)
});
