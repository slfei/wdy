import Vue from 'vue'
import Router from 'vue-router'
import Homepage from '@/page/homepage/Homepage'
import Teacher from '@/page/teacher/index'
import store from '@/page/store/index'
import course from '@/page/course/index'
Vue.use(Router)
export default new Router({
  routes: [
    ...course,
    ...Teacher,
    ...store,
    {
      path: '/',
      name: 'Homepage',
      component: Homepage
    },
    {
      path: '*',
      redirect: '/'
    },

  ]
})
