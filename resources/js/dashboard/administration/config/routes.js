import ErrorForbidden from '@/errors/Forbidden.vue';
import ErrorNotFound from '@/errors/NotFound.vue';

import Home from '@/administration/views/home/Index.vue';

import TrainingIndex from '@/administration/views/training/Index.vue';
import TrainingCreate from '@/administration/views/training/Create.vue';
import TrainingEdit from '@/administration/views/training/Edit.vue';

import CourseIndex from '@/administration/views/course/Index.vue';
import CourseCreate from '@/administration/views/course/Create.vue';
import CourseEdit from '@/administration/views/course/Edit.vue';

import CourseEventsIndex from '@/administration/views/course_events/Index.vue';
import CourseEventsCreate from '@/administration/views/course_events/Create.vue';
import CourseEventsEdit from '@/administration/views/course_events/Edit.vue';

import TutorsIndex from '@/tutor/views/tutor/Index.vue';
import TutorsCreate from '@/tutor/views/tutor/Create.vue';
import TutorsEdit from '@/tutor/views/tutor/Edit.vue';

import StudentsIndex from '@/administration/views/student/Index.vue';
import StudentShow from '@/administration/views/student/Show.vue';

const routes = [

  // Home
  {
    name: 'home',
    path: '/administration',
    component: Home,
  },

  // Trainings
  {
    name: 'trainings',
    path: '/administration/trainings',
    component: TrainingIndex,
  },
  {
    name: 'training-create',
    path: '/administration/training/create',
    component: TrainingCreate,
  },
  {
    name: 'training-edit',
    path: '/administration/training/edit/:id',
    component: TrainingEdit,
  },

  // Courses
  {
    name: 'courses',
    path: '/administration/courses',
    component: CourseIndex,
  },
  {
    name: 'course-create',
    path: '/administration/course/create',
    component: CourseCreate,
  },
  {
    name: 'course-edit',
    path: '/administration/course/edit/:id',
    component: CourseEdit,
  },
  {
    name: 'course-events',
    path: '/administration/course/events/:id',
    component: CourseEventsIndex,
  },
  {
    name: 'course-event-create',
    path: '/administration/course/event/create/:id',
    component: CourseEventsCreate,
  },
  {
    name: 'course-event-edit',
    path: '/administration/course/event/edit/:id',
    component: CourseEventsEdit,
  },

  // Tutors
  {
    name: 'tutors',
    path: '/administration/tutors',
    component: TutorsIndex,
  },
  {
    name: 'tutor-create',
    path: '/administration/tutor/create',
    component: TutorsCreate,
  },
  {
    name: 'tutor-edit',
    path: '/administration/tutor/edit/:id',
    component: TutorsEdit,
  },

  // Students
  {
    name: 'students',
    path: '/administration/students',
    component: StudentsIndex,
  },
  {
    name: 'student-show',
    path: '/administration/student/show/:id',
    component: StudentShow,
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