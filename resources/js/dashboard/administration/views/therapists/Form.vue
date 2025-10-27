<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{ title }}</h1>
      </header>
      <div>

        <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
          <label>Titel</label>
          <input type="text" v-model="therapist.title">
        </div>

        <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
          <label>Vorname</label>
          <input type="text" v-model="therapist.firstname">
          <label-required/>
        </div>

        <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
          <label>Nachname</label>
          <input type="text" v-model="therapist.name">
          <label-required/>
        </div>

        <div :class="[this.errors.country ? 'has-error' : '', 'form-row']">
          <label>Land</label>
          <div class="select-wrapper is-wide">
            <select v-model="therapist.country">
              <option value="">Bitte auswählen...</option>
              <option value="Germany">Deutschland</option>
              <option value="Switzerland">Schweiz</option>
            </select>
          </div>
          <label-required/>
        </div>

        <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
          <label>Beschreibung</label>
          <tinymce-editor
            :init="tinyConfig"
            v-model="therapist.description">
          </tinymce-editor>
        </div>

      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'therapists' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</template>

<script>

// Error Handling
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import TinymceEditor from "@tinymce/tinymce-vue";
import tinyConfig from "@/global/config/tiny.js";

export default {
  components: {
    LabelRequired,
    TinymceEditor,
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      therapist: {
        title: '',
        firstname: '',
        name: '',
        country: '',
        description: '',
        is_published: 1,
      },

      // Validation
      errors: {
        title: false,
        firstname: false,
        name: false,
        country: false,
        description: false,
      },

      // Loading state
      isLoading: false,
      isFetched: true,

      // TinyMCE config
      tinyConfig,
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/therapist/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.therapist = {
          title: response.data.title,
          firstname: response.data.firstname,
          name: response.data.name,
          country: response.data.country,
          description: response.data.description,
          is_published: response.data.is_published,
        };

        this.isFetched = true;
      });
    }
  },

  methods: {

    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      let uri = "/api/therapist";
      this.isLoading = true;

      this.axios.post(uri, this.therapist).then(response => {
        this.$router.push({ name: "therapists" });
        this.$notify({ type: "success", text: "Psychotherapeut erfasst!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/therapist/${this.$route.params.id}`;
      this.isLoading = true;

      this.axios.put(uri, this.therapist).then(response => {
        this.$router.push({ name: "therapists" });
        this.$notify({ type: "success", text: "Psychotherapeut gespeichert!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Therapeut:in bearbeiten" : "Therapeut:in hinzufügen";
    },
  }
};
</script>
