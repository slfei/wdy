// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router/index'
import ElementUI from 'element-ui'
import i18n from './i18n'
import axios from 'axios'
// import Qs from 'qs'
import '../theme/index.css'
import 'normalize.css'
import api from '@/js/api/account'


Vue.config.productionTip = false;
Vue.use(ElementUI)

axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.transformRequest = [function(data) {
    return typeof data == 'object' ? JSON.stringify(data) : data;
}];

api.getPrivilege().then(data => {
    function buildMap(array) {
        var ret = {};
        array.forEach(id => {
            ret[id] = 'lock';
        });
        return ret;
    }
    var map = buildMap(data.access_ids);

    Vue.filter('permissionCtrl', function(id) {
        return map[id];
    });
    new Vue({
        el: '#app',
        router,
        template: '<App/>',
        components: {
            App
        },
        i18n: i18n
    });
});
