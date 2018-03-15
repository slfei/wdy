import course from './course'
import courseInfo from './courseInfo'

export default [
    {
        path: '/course',
        name: 'course',
        component: course
    },
    {
        path: '/courseInfo/:id',
        name: 'courseInfo',
        component: courseInfo
    }
]