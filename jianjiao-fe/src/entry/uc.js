/**
 * Created by huangzhongjian on 17/5/12.
 */

import Vue from 'vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import Page from '../page/uc/Index.vue';
import '@/js/base';

Vue.use(Mint);
new Vue({
    el: '#main',
    render: h => h(Page)
});
