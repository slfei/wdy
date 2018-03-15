import Vue from 'vue';
import Page from '../page/topic315/exposureEdit.vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import '@/js/base';



Vue.use(Mint);
new Vue({
    el: '#main',
    render: h => h(Page)
});
