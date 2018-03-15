//why
import personSetting from './PersonSetting.vue'
import teacherIndex from './TeacherIndex.vue'
import consultation from './TheConsultation.vue'
import discount from './Discount.vue'
import aboutus from './TheAboutUs.vue'
import studentQuery from './TheStudentQuery.vue'
import Index from './index.vue'
import indexpage from './IndexPage.vue'
import ActivityApply from './ActivityApply.vue'

import * as api from '@/js/api'
export default [
    {
        path: '/marketing',
        component: Index,
        children: [
            {
                path: 'indexpage',
                name: 'indexpage',
                component: indexpage,
                meta: { privilege:18}
            },
            {
                path: 'teacherindex',
                name: 'teacherIndex',
                component: teacherIndex,
                meta: { privilege:18}
            },
            {
                path: 'consultation',
                name: 'consultation',
                component: consultation,
                meta: { privilege:108}

            },
            {
                path: 'discount',
                name: 'discount',
                component: discount,
                meta: { privilege:20}
            },
            {
                path: 'about',
                name: 'about',
                component: aboutus,
                meta: { privilege:19}

            },
            {
                path: 'student',
                name: 'studentQuery',
                component: studentQuery,
                meta: { privilege:21}
            },
            // {
            //     path: 'ActivityApply',
            //     name: 'ActivityApply',
            //     component: ActivityApply,
            // },
            {
                path: '*',
                redirect: 'indexpage'
            }
        ]
    }

]
