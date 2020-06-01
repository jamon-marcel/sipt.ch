<template>
<div :class="isLoaded ? 'is-loaded' : 'hide-before-load'">
  <div class="mb-4">
    <h4>Meine Daten</h4>
    <div>
      {{student.firstname}} {{student.name}}<br>
      {{student.phone}}<br>
      {{student.user.email}}<br>
      <router-link :to="{name: 'profile-edit', params: {id: student.id}}">Bearbeiten</router-link>
    </div>
  </div>
  <div class="mb-4">
    <h4>Nächste Module</h4>
  </div>
  <div class="mb-4">
    <h4>Besuchte Module</h4>
    <div class="mt-4">
      <button type="button" class="btn btn-primary">Ausbildungsblatt herunterladen</button>
    </div>
  </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      isLoaded: false,
      student: {
        id: null,
        firstname: null,
        name: null,
        phone: null,
        user: {
          email: null,
        },
      },
    };
  },
  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/student/${this.$route.params.id}`).then(response => {
        this.student = response.data;
        this.isLoaded = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/student/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },

  }
}
</script>
<style>
.is-loaded {
  opacity: 1;
  transition: opacity .12s ease-out;
}

.hide-before-load {
  opacity: 0;
  transition: opacity .12s ease-out;
}

</style>
