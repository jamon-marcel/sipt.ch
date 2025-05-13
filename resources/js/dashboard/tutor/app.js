require('../bootstrap');

// Vue - import the full build with the compiler
import Vue from 'vue';
window.Vue = Vue;

// Require vue-axios-interceptors after Vue
require('vue-axios-interceptors');

// Axios, Vue-Axios
import VueAxios from 'vue-axios';
import axios from 'axios';
window.axios = require('axios');
Vue.use(VueAxios, axios);

// Filters
require('../filters');

// Vue-Axios defaults
Vue.axios.defaults.withCredentials = true;

// Vue-Notifications
import Notifications from 'vue-notification';
Vue.use(Notifications);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Loading indicator
import LoadingIndicator from "@/global/components/ui/LoadingIndicator";
Vue.component('LoadingIndicator', LoadingIndicator);

import Separator from "@/global/components/ui/Separator";
Vue.component('Separator', Separator);

// Vue-Moment
Vue.use(require('vue-moment'));

// Vue-cleave
import Cleave from 'cleave.js';
Vue.directive('cleave', {
  inserted: (el, binding) => {
    el.cleave = new Cleave(el, binding.value || {});
  },
  update: (el) => {
    const event = new Event('input', {bubbles: true});
    setTimeout(function () {
      el.value = el.cleave.properties.result;
      el.dispatchEvent(event);
    }, 100);
  }
});

// Store
import store from '@/tutor/config/store';

// Routes
import routes from '@/tutor/config/routes';
const router = new VueRouter({ mode: 'history', routes: routes});

// App component
import AppComponent from '@/tutor/App.vue';

// Mount App
const app = new Vue({
  components: { AppComponent },
  router,
  store
}).$mount('#app-tutor');
