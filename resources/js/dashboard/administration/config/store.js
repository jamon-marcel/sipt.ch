import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: false,
    keyword: ''
  },
  mutations: {
    user(state, user) {
      state.user = user;
    },
    keyword(state, values) {
      state.keyword = values;
    },
  }
});