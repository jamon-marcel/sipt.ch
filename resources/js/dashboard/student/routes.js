import ErrorForbidden from '@/global/views/ErrorForbidden.vue';
import ErrorNotFound from '@/global/views/ErrorNotFound.vue';

import Profile from '@/student/views/Profile.vue';
import ProfileEdit from '@/student/views/ProfileEdit.vue';

const routes = [
  {
    name: 'profile',
    path: '/student/:id',
    component: Profile,
  },
  {
    name: 'profile-edit',
    path: '/student/profile/edit/:id',
    component: ProfileEdit,
  },
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