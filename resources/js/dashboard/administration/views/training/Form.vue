<template>
  <form @submit.prevent="submit">
    <header class="module-header">
      <h1>Fortbildung erfassen</h1>
      <router-link :to="{ name: 'trainings' }" class="btn-back">
        <span>Zurück</span>
      </router-link>
    </header>
    <div class="grid-main-sidebar">
      <div class="column-main">
        <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
          <label>Titel *</label>
          <input class="form-control" type="text" v-model="training.title">
          <div class="is-required">Pflichtfeld</div>
        </div>
        <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
          <label>Beschreibung</label>
          <textarea class="form-control" v-model="training.description"></textarea>
        </div>
      </div>
      <div class="column-sidebar">
        <div>
          <div class="form-row is-sm is-last">
            <label class="is-sm">Publizieren?</label>
            <div class="form-radio">
              <input
                v-model="training.is_published"
                type="radio"
                name="publish_1"
                id="publish_1"
                value="1"
                class="visually-hidden"
              >
              <label for="publish_1" class="form-control">Ja</label>
              <input
                v-model="training.is_published"
                type="radio"
                name="publish_0"
                id="publish_0"
                value="0"
                class="visually-hidden"
              >
              <label for="publish_0" class="form-control">Nein</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Speichern</button>
  </form>
</template>
<script>

// Error Handling (mixin)
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {
  components: { },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      training: {
        title: null,
        description: null,
        is_published: 0,
      },
      errors: {
        title: false,
        description: false,
      },
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/training/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.training = response.data;
      });
    }
  },

  methods: {

    // Submit form
    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      let uri = "/api/training/create";
      this.axios.post(uri, this.training).then(response => {
        this.$router.push({ name: "trainings" });
        this.$notify({ type: "success", text: "Fortbildung erfasst!" });
      });
    },

    update() {
      let uri = `/api/training/update/${this.$route.params.id}`;
      this.axios.post(uri, this.training).then(response => {
        this.$router.push({ name: "trainings" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Fortbildung bearbeiten" 
        : "Fortbildung hinzufügen";
    }
  }
};
</script>
<style>
.has-error label {
  color: red;
}
</style>
