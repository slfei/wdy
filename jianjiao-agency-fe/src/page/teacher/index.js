import Teacher from './list'
import AddTeacher from './add.vue'
export default [
    {
        path: '/teacher',
        component: Teacher
    },
    {
      path: '/teacher/add',
      component: AddTeacher
    },
    {
      path: '/teacher/edit/:id',
      component: AddTeacher
    }
]
