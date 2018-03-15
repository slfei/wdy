import Vue from 'vue'
import Router from 'vue-router'

import applySettle from '@/page/applySettle/applySettle.vue'

Vue.use(Router)

var routes = [{
  path: '/apply',
  name: 'apply',
  component: applySettle
}];

export default new Router({
  routes: routes
})
