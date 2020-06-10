<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <div class="grid grid-1-1">
      <div>
        <header class="content-header">
          <h1>Profil</h1>
        </header>
        <student-profile :student="student" :hasEdit="true"></student-profile>
      </div>
      <div>
        <header class="content-header">
          <h1>Login</h1>
        </header>
        <div class="profile">
          <div class="profile__item">
            <label>Benutzer</label>
            {{ student.user.email }}
          </div>
          <router-link :to="{name: 'profile-edit', params: { id: student.id }}" class="btn-primary is-sm">
            Bearbeiten
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

// Views
import StudentProfile from "@/student/views/partials/StudentProfile.vue";

export default {
  components: {
    StudentProfile
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