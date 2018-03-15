/**
 * Created by huangzhongjian on 17/5/12.
 */

import Vue from 'vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import Page from '../page/psychTest/psych_subject.vue';
import '@/js/base';

Vue.use(Mint);
new Vue({
    el: '#main',
    render: h => h(Page)
});
