import ErrorForbidden from '@/errors/Forbidden.vue';
import ErrorNotFound from '@/errors/NotFound.vue';

import Home from '@/tutor/views/home/Index.vue';

import ProfileIndex from '@/tutor/views/profile/Index.vue';
import ProfileEdit from '@/tutor/views/profile/Form.vue';
import ProfileChangeEmail from '@/global/components/UserChangeEmailForm.vue';

import CourseEventsIndex from '@/tutor/views/course_events/Index.vue';
import CourseEventsShow from '@/tutor/views/course_events/Show.vue';

import SupportIndex from '@/tutor/views/support/Index.vue';


const routes = [

  // Home
  {
    name: 'home',
    path: '/tutor',
    component: Home,
  },

  // Profile
  {
    name: 'profile',
    path: '/tutor/profile',
    component: ProfileIndex,
  },

  // Profile - Edit
  {
    name: 'profile-edit',
    path: '/tutor/profile/edit/:id',
    component: ProfileEdit,
  },

  // Profile - Edit
  {
    name: 'profile-change-email',
    path: '/tutor/profile/change/email/:id',
    component: ProfileChangeEmail,
  },

  // Courses
  {
    name: 'courses',
    path: '/tutor/course/events',
    component: CourseEventsIndex,
  },

  // Course - show
  {
    name: 'course-show',
    path: '/tutor/course/event/:id',
    component: CourseEventsShow,
  },


  // Help & Support
  {
    name: 'support',
    path: '/tutor/support',
    component: SupportIndex,
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