import ErrorForbidden from '@/global/views/ErrorForbidden.vue';
import ErrorNotFound from '@/global/views/ErrorNotFound.vue';

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
import StudentEdit from '@/administration/views/student/Edit.vue';

const routes = [

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
    name: 'student-edit-courses',
    path: '/administration/student/courses/:id',
    component: StudentEdit,
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