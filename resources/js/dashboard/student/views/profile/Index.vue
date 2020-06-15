<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <div class="grid grid-1-1">
      <div>
        <header class="content-header">
          <h1>Profil</h1>
        </header>
        <profile :student="student" :hasEdit="true"></profile>
      </div>
      <div>
        <header class="content-header">
          <h1>Zugangsdaten</h1>
        </header>
        <div class="profile">
          <div class="profile__item">
            <label>E-Mail</label>
            {{ student.user.email }}
          </div>
          <router-link :to="{name: 'profile-change-email', params: { id: student.id }}" class="btn-primary is-sm">
            Bearbeiten
          </router-link>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'home' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </div>
</template>
<script>

// Views
import Profile from "@/student/views/partials/Profile.vue";

export default {
  components: {
    Profile
  },

  data() {
    return {
      isFetched: false,
      student: {
        user: {
          email: null,
        }
      },
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/student/profile`).then(response => {
        this.student = response.data;
        this.isFetched = true;
      });
    },
  }
}
</script>