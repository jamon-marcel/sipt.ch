<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Willkommen <strong>{{admin.firstname}} {{admin.name}}</strong></h1>
    </header>
    <div class="content">
      <p>Unser neues Portal ermöglicht es Ihnen, ihre Daten selbständig zu aktualisieren, <router-link :to="{name: 'trainings'}"><span>Fortbildungen</span></router-link> und <router-link :to="{name: 'courses'}"><span>Module</span></router-link> zu Erstellen und Bearbeiten.</p>
    </div>
  </div>
</template>
<script>

// Mixins
import Helpers from "@/global/mixins/Helpers";

export default {

  mixins: [Helpers],

  data() {
    return {
      isFetched: false,
      admin: {},
    };
  },

  created() {
    this.fetchStudent();
  },

  methods: {
    fetchStudent() {
      this.axios.get(`/api/administrator`).then(response => {
        this.admin = response.data;
        this.isFetched = true;
      });
    }
  }
}
</script>