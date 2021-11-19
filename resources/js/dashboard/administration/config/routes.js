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
import StudentCreate from '@/administration/views/student/Create.vue';

import BackofficeModules from '@/administration/views/backoffice/Modules.vue';
import BackofficeCourseEvent from '@/administration/views/backoffice/CourseEvent.vue';
import BackofficeInvoices from '@/administration/views/backoffice/Invoices.vue';
import BackofficeInvoicesPaid from '@/administration/views/backoffice/InvoicesPaid.vue';
import BackofficeInvoicesCancelled from '@/administration/views/backoffice/InvoicesCancelled.vue';
import BackofficeCreateInvoice from '@/administration/views/backoffice/CreateInvoice.vue';
import BackofficeCreateManualInvoice from '@/administration/views/backoffice/CreateManualInvoice.vue';
import BackofficeEditInvoice from '@/administration/views/backoffice/EditInvoice.vue';
import BackofficeImport from '@/administration/views/backoffice/Import.vue';

import Symposium from '@/administration/views/symposium/Index.vue';
import SymposiumSubscriberCreate from '@/administration/views/symposium/Form.vue';

import VipAddressesIndex from '@/administration/views/vip/Index.vue';
import VipAddressesCreate from '@/administration/views/vip/Create.vue';
import VipAddressesEdit from '@/administration/views/vip/Edit.vue';

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
    name: 'courses-chronological',
    path: '/administration/courses/chronological',
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
  {
    name: 'student-create',
    path: '/administration/student/create',
    component: StudentCreate,
  },
  // Backoffice
  {
    name: 'backoffice-modules',
    path: '/administration/backoffice/modules',
    component: BackofficeModules,
  },
  {
    name: 'backoffice-course-event',
    path: '/administration/backoffice/course/:id',
    component: BackofficeCourseEvent,
  },
  {
    name: 'backoffice-invoices',
    path: '/administration/backoffice/invoices',
    component: BackofficeInvoices,
  },
  {
    name: 'backoffice-invoices-paid',
    path: '/administration/backoffice/invoices/paid',
    component: BackofficeInvoicesPaid,
  },
  {
    name: 'backoffice-invoices-cancelled',
    path: '/administration/backoffice/invoices/cancelled',
    component: BackofficeInvoicesCancelled,
  },
  {
    name: 'backoffice-create-invoice',
    path: '/administration/backoffice/invoice/create',
    component: BackofficeCreateInvoice,
  },
  {
    name: 'backoffice-create-manual-invoice',
    path: '/administration/backoffice/invoice/manual/create',
    component: BackofficeCreateManualInvoice,
  },
  {
    name: 'backoffice-edit-invoice',
    path: '/administration/backoffice/invoice/edit',
    component: BackofficeEditInvoice,
  },
  {
    name: 'backoffice-import',
    path: '/administration/backoffice/import',
    component: BackofficeImport,
  },

  // Symposium
  {
    name: 'symposium',
    path: '/administration/symposium',
    component: Symposium,
  },
  {
    name: 'symposium-subscriber-create',
    path: '/administration/symposium/create',
    component: SymposiumSubscriberCreate,
  },

  // VIP Addresses
  {
    name: 'vip-addresses',
    path: '/administration/vip-addresses',
    component: VipAddressesIndex,
  },
  {
    name: 'vip-address-create',
    path: '/administration/vip-address/create',
    component: VipAddressesCreate,
  },
  {
    name: 'vip-address-edit',
    path: '/administration/vip-address/edit/:id',
    component: VipAddressesEdit,
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