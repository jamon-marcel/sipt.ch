<template>
<div :class="isFetched ? 'is-loaded' : 'is-loading'">
  <form @submit.prevent="submit">
    <div class="grid-main-sidebar profile">
      <div>
        <header class="content-header">
          <h1>Profil</h1>
        </header>
        <profile :student="student"></profile>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'students' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</div>
</template>
<script>

// Views
import Profile from "@/global/components/StudentProfile.vue";

export default {
  components: {
    Profile,
  },

  data() {
    return {
      student: {},
      isFetched: true,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isFetched = false;
      this.axios.get(`/api/student/profile/${this.$route.params.id}`).then(response => {
        this.student = response.data;
        this.isFetched = true;
      });
    }
  }
};
</script>