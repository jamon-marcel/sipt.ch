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
import CourseEventsShow from '@/administration/views/course_events/Show.vue';

import TutorsIndex from '@/administration/views/tutor/Index.vue';
import TutorsCreate from '@/administration/views/tutor/Create.vue';
import TutorsEdit from '@/administration/views/tutor/Edit.vue';

import StudentsIndex from '@/administration/views/student/Index.vue';
import StudentCourseEvents from '@/administration/views/student/course_events/Index.vue';
import StudentProfile from '@/administration/views/student/profile/Index.vue';
import StudentProfileEdit from '@/administration/views/student/profile/Form.vue';

import BackofficeIndex from '@/administration/views/backoffice/Index.vue';
import BackofficeCourseEventsShow from '@/administration/views/backoffice/Show.vue';


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
  {
    name: 'course-event-show',
    path: '/administration/course/event/show/:id',
    component: CourseEventsShow,
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
    name: 'student-profile',
    path: '/administration/student/profile/:id',
    component: StudentProfile,
  },
  {
    name: 'student-profile-edit',
    path: '/administration/student/profile/edit/:id',
    component: StudentProfileEdit,
  },

  {
    name: 'student-courses',
    path: '/administration/student/courses/:id',
    component: StudentCourseEvents,
  },

  // Backoffice
  {
    name: 'backoffice',
    path: '/administration/backoffice',
    component: BackofficeIndex,
  },
  {
    name: 'backoffice-course-event-show',
    path: '/administration/backoffice/course/event/show/:id',
    component: BackofficeCourseEventsShow,
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