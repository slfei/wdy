import Vue from 'vue'
import Router from 'vue-router'
import application from '@/page/application'

Vue.use(Router)

export default new Router({
  routes: [
    ...application,
    {
      path: '*',
      redirect: '/application/institute'
    }
  ]
})
