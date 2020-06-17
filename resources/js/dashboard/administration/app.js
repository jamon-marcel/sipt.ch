require('../bootstrap');

// Vue
window.Vue = require('vue');

// Axios Interceptors
require('vue-axios-interceptors');

// Axios, Vue-Axios
import VueAxios from 'vue-axios';
import axios from 'axios';
window.axios = require('axios');
Vue.use(VueAxios, axios);

// Vue-Axios defaults
Vue.axios.defaults.withCredentials = true;
//Vue.axios.defaults.baseURL = 'http://sipt.ch.local/';

// Vue-Notifications
import Notifications from 'vue-notification';
Vue.use(Notifications);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Vue-Moment
Vue.use(require('vue-moment'));

// Loading indicator
import LoadingIndicator from "@/global/components/ui/LoadingIndicator";
Vue.component('LoadingIndicator', LoadingIndicator);

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

// Global mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Store
import store from '@/administration/config/store';

// Routes
import routes from '@/administration/config/routes';
const router = new VueRouter({ mode: 'history', routes: routes});

// App component
import AppComponent from '@/administration/App.vue';

// Mount App
const app = new Vue({
  mixins: [ErrorHandling],
  components: { 
    AppComponent
  },
  router,
  store
}).$mount('#app-administration');