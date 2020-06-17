import ErrorForbidden from '@/errors/Forbidden.vue';
import ErrorNotFound from '@/errors/NotFound.vue';

import Home from '@/student/views/home/Index.vue';

import ProfileIndex from '@/student/views/profile/Index.vue';
import ProfileEdit from '@/student/views/profile/Form.vue';
import ProfileChangeEmail from '@/student/views/profile/ChangeEmail.vue';

import CourseEventsIndex from '@/student/views/course_events/Index.vue';
import CourseEventsShow from '@/student/views/course_events/Show.vue';

import SupportIndex from '@/student/views/support/Index.vue';


const routes = [

  // Home
  {
    name: 'home',
    path: '/student',
    component: Home,
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

  // Profile - Edit
  {
    name: 'profile-change-email',
    path: '/student/profile/change/email/:id',
    component: ProfileChangeEmail,
  },

  // Courses
  {
    name: 'course-show',
    path: '/student/course/show/:id',
    component: CourseEventsShow,
  },

  // Courses - Show
  {
    name: 'courses',
    path: '/student/courses',
    component: CourseEventsIndex,
  },


  // Courses - Show
  {
    name: 'support',
    path: '/student/support',
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