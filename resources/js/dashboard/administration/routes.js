import ErrorForbidden from '@/global/views/ErrorForbidden.vue';
import ErrorNotFound from '@/global/views/ErrorNotFound.vue';

import TrainingIndex from '@/administration/views/training/Index.vue';
import TrainingCreate from '@/administration/views/training/Create.vue';
import TrainingEdit from '@/administration/views/training/Edit.vue';

const routes = [
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