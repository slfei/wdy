/**
 * Created by huangzhongjian on 17/5/12.
 */

import Vue from 'vue';
import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
import Index from '../page/Index.vue';
import VueCookie from 'vue-cookie';
import utils from '../js/utils';
import '@/js/base';



Vue.use(Mint);
Vue.use(VueCookie);

let vue = new Vue({
    el: '#main',
    render: h => h(Index),

});



/**
 * 只提示一次
 */
function once(key, fn) {
    var isCalled = vue.$cookie.get(key);
    if(!isCalled){
        fn && fn();
        vue.$cookie.set(key, 'true', {expires: '2Y'});
    }
}

export default vue;
