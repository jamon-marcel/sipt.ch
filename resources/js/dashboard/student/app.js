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
Vue.axios.defaults.baseURL = 'http://sipt.ch.local/';

// Vue-Notifications
import Notifications from 'vue-notification';
Vue.use(Notifications);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Routes
import routes from '@/student/routes';
const router = new VueRouter({ mode: 'history', routes: routes});

// Load AppComponent
import AppComponent from '@/student/App.vue';

const app = new Vue({
  components: { AppComponent },
  router
}).$mount('#app-students');
