import ErrorForbidden from '@/errors/Forbidden.vue';
import ErrorNotFound from '@/errors/NotFound.vue';

import Dashboard from '@/student/views/dashboard/Index.vue';

import ProfileIndex from '@/student/views/profile/Index.vue';
import ProfileEdit from '@/student/views/profile/Form.vue';

const routes = [

  // Dashboard
  {
    name: 'dashboard',
    path: '/student',
    component: Dashboard,
  },

  // Profile
  {
    name: 'profile',
    path: '/student/profile',
    component: ProfileIndex,
  },

  // Profile - Edit
  {
    name: 'profile-edit',
    path: '/student/profile/edit/:id',
    component: ProfileEdit,
  },

  // Authorization
  {
    name: 'forbidden',
    path: '/forbidden',
    component: ErrorForbidden,
  },
  {
    name: 'not-found',
    path: '/not-found',
    component: ErrorNotFound,
  }
];

export default routes