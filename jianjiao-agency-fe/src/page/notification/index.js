import List from "./list.vue"
import Detail from './detail.vue'
import LiveNotification from './livelist'

export default [
    {
        path: '/notification',
        name: 'notice',
        component: List,
    },
    {
        path: '/notification/:id',
        name: 'noticeDetail',
        component: Detail
    },
    {
        path: '/liveNotification',
        name: 'liveNotice',
        component: LiveNotification,
    },
]
