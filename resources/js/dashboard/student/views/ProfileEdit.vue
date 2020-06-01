<template>
  <div class="">
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="submit">
          <h4>Profil bearbeiten</h4>
          <div class="form-group">
            <label>Vorname</label>
            <input class="form-control" type="text" v-model="student.firstname">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" v-model="student.name">
          </div>
          <div class="form-group">
            <label>Telefon</label>
            <input class="form-control" type="text" v-model="student.phone">
          </div>
          <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>

// Error Handling (mixin)
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  mixins: [ErrorHandling],


  data() {
    return {
      student: {
        firstname: null,
        name: null,
        phone: null,
      }
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/student/edit/${this.$route.params.id}`).then(response => {
        this.student = response.data;
      });
    },

    submit() {
      let uri = `/api/student/update/${this.$route.params.id}`;
      this.axios.post(uri, this.student).then(response => {
        this.$router.push({ name: 'profile' });
        this.$notify({ type: "success", text: `Profil erfolgreich angepasst!`});
      });
    },
  }

}
</script>