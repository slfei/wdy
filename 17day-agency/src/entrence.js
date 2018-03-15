// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './Entrence.vue'
import router from './router/entrence'
import ElementUI from 'element-ui'
import i18n from './i18n'
import axios from 'axios'
import 'normalize.css'
import '../theme/index.css'

Vue.config.productionTip = false;

Vue.use(ElementUI);

axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.transformRequest = [function(data) {
   return typeof data == 'object' ?  JSON.stringify(data) : data;
}];
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App },
  i18n: i18n
});
