import Vue from 'vue'
import App from './apply.vue'
import router from './router/apply'
import ElementUI from 'element-ui'
import axios from 'axios'

import 'element-ui/lib/theme-chalk/index.css'
import './style/global.styl'

import VDistpicker from 'v-distpicker'

Vue.component('v-distpicker', VDistpicker);

Vue.config.productionTip = false

Vue.use(ElementUI)


axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.transformRequest = [function(data) {
  return typeof data == 'object' ? JSON.stringify(data) : data;
}];

window.bus = new Vue();
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: {
    App
  },
  template: '<App/>'
})
