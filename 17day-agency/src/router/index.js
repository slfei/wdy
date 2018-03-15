import Vue from 'vue'
import Router from 'vue-router'
// import Index from '@/page/index/Index'
import dataMangement from '@/page/dataMangement'
import videoMangement from '@/page/videoMangement'
import financeManagement from '@/page/financeManagement'
import evaluationManagement from '@/page/evaluationManagement'

import Finance from '@/page/finance/finance'
//import about from '@/page/about'

import NotFound from '@/page/NotFound'
import marketing from '@/page/marketing'
import createCourse from '@/page/createCourse'
import Course from '@/page/course/course'
import courseManagement from '@/page/courseManagement'
// import test from '@/page/test';
import modifyCourse from '@/page/modifyCourse'
import notification from '@/page/notification'
import account from '@/page/account'
import personalAccount from '@/page/personalAccount'
import instituteAccount from '@/page/instituteAccount'
import api from '@/js/api/account'

import PermissionDenied from '@/page/PermissionDenied'

//周直播列表
import liveList from '@/page/liveList'

Vue.use(Router);
var routes = [
  ...marketing,
  ...createCourse,
  ...notification,
  ...modifyCourse,
  ...account,
  ...instituteAccount,
  ...personalAccount,

  {
      path: '/course',
      component: Course,
      children: [
          ...courseManagement,
          ...dataMangement,
          ...videoMangement,
          ...evaluationManagement,
          ...liveList,
          {
              path: '*',
              redirect: 'list'
          }
      ]
  },
  {
      path: '/finance',
      component: Finance,
      children: [
          ...financeManagement,
          {
              path: '*',
              redirect: 'orderQuery'
          }
      ]
  },
  {
      path: '*',
      redirect: '/course/'
  }
];
/**
 * 遍历routes, 给带有 meta.privilege的route对像同级上添加
{ path: route.path + '/permissionDenied', compnent: PermissionDenied}的路由
 */
function addPermissionToRoute(routes, key = 'privilege') {
    var ret = [];
    walkRoute(routes, function(route, routes) {
        if (route.meta && route.meta[key]) {
            ret.push({
                path: route.path,
                routes: routes,
            });
        }
    });
    ret.forEach(({path, routes}) => routes.unshift({
        path: path + '/permissionDenied',
        component: PermissionDenied
    }));
    function walkRoute(routes, each) {
        routes.forEach(function(item) {
          each(item, routes);
            if (item.children) {
                walkRoute(item.children, each);
            }
        });
    }
}
addPermissionToRoute(routes);

var router = new Router({
    routes: routes
});
router.beforeEach(function(to, from, next) {
    var privilege = to.meta.privilege;

    if (!privilege) {
        return next();
    }

    api.getPrivilege().then(data => {
        var privilegeSetting = data.access_ids;
        handle(privilegeSetting);
    });

    function handle(privilegeSetting) {
        //console.warn(privilegeSetting, privilege, to);
        if (privilegeSetting.indexOf(privilege) < 0) {
            //没有访问权限时跳到无权限访问页
            next({
                path: to.fullPath + '/permissionDenied'
            });
        } else {

            next();
        }
    }

});
export default router;
