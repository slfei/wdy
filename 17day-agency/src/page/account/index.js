//slf
import Profile from './Profile.vue'
import Members from './members.vue'
import PrivilegSet from './privilegSet.vue'
import PersonalInfo from './personalInfo.vue'
import ManageMember from './manageMember.vue'
import ChangePermission from './changePermission.vue' 
import AddNewRole from './addNewRole.vue' 
import Index from './index.vue'
export default [
		    {
	         path: '/account', //账户管理
	         component: Index,
		     children: [
		            {
		      path: 'profile',
		      name: 'profile',
		      component: Profile,
		      meta: { privilege:22}
		
		    },
		    {
		      path: 'members',
		      name: 'members',
		      component: Members,
		      meta: { privilege:23}
		    },
		    {
		      path: 'personalinfo',
		      name: 'personalInfo',
		      component: PersonalInfo,
//		      meta: { privilege:25}
		    },
		     {
		      path: 'privilege',
		      name: 'privilege',
		      component: PrivilegSet,
		      meta: { privilege:24}
		    },
		     {
			    path: 'privilege/addnewrole',
			    name: 'addNewRole',
			    component: AddNewRole
			  },
		     {
		      path: 'privilege/manage/:role_id/:is_admin',
		      name: 'manageMember',
		      component: ManageMember
		    },
		    {
		      path: 'privilege/change/:role_id',
		      name: 'changePermission',
		      component: ChangePermission
		    },
            {
                path: '*',
                redirect: 'profile'
            },
        ]
    }

]
