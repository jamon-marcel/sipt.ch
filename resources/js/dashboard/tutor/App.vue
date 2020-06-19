<template>
<div>
  <notifications classes="notification" />
  <page-header :user="$store.state.user"></page-header>
  <main class="site">
    <router-view></router-view>
  </main>
</div>
</template>
<script>
import PageHeader from '@/tutor/layout/PageHeader.vue';
export default {
  components: {
    PageHeader
  },

  mounted() {
    this.fetchUser();
  },

  methods: {
    fetchUser() {
      if (!this.$store.state.user) {
        this.axios.get(`/api/user/tutor`).then(response => {
          this.$store.commit('user', `${response.data.firstname} ${response.data.name}`);
        });
      }
    },
  }
}
</script>