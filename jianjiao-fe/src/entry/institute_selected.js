/**
 * Created by zxx on 18/1/15.
 */

import Vue from 'vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import Page from '../page/institute/selected.vue';
import '@/js/base';

Vue.use(Mint);
new Vue({
    el: '#main',
    render: h => h(Page)
});
