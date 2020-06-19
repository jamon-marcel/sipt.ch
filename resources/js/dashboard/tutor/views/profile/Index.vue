<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <div class="grid grid-1-1">
      <div>
        <header class="content-header">
          <h1>Profil</h1>
        </header>
        <profile :tutor="tutor" :hasEdit="true"></profile>
      </div>
      <div>
        <header class="content-header">
          <h1>Zugangsdaten</h1>
        </header>
        <div class="profile">
          <div class="profile__item">
            <label>E-Mail</label>
            {{ tutor.user.email }}
          </div>
          <router-link :to="{name: 'profile-change-email', params: { id: tutor.id }}" class="btn-primary is-sm">
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
import Profile from "@/global/components/TutorProfile.vue";

export default {
  components: {
    Profile
  },

  data() {
    return {
      isFetched: false,
      tutor: {
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
      this.axios.get(`/api/tutor/profile`).then(response => {
        this.tutor = response.data;
        this.isFetched = true;
      });
    },
  }
}
</script>