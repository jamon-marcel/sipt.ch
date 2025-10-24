<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>Introtext «SIPT zertifizierte TherapeutInnen» bearbeiten</h1>
      </header>
      <div>

        <div :class="[this.errors.content ? 'has-error' : '', 'form-row']">
          <tinymce-editor
            :init="tinyConfig"
            v-model="intro.content">
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
import TinymceEditor from "@tinymce/tinymce-vue";
import tinyConfig from "@/global/config/tiny.js";

export default {
  components: {
    TinymceEditor,
  },

  mixins: [ErrorHandling],

  data() {
    return {
      // Model
      intro: {
        content: '',
      },

      // Validation
      errors: {
        content: false,
      },

      // Loading state
      isLoading: false,
      isFetched: false,

      // TinyMCE config
      tinyConfig,
    };
  },

  created() {
    this.fetchIntro();
  },

  methods: {

    fetchIntro() {
      let uri = `/api/therapist-intro`;
      this.axios.get(uri).then(response => {
        if (response.data) {
          this.intro = {
            id: response.data.id,
            content: response.data.content || '',
          };
        }
        this.isFetched = true;
      }).catch(error => {
        this.isFetched = true;
      });
    },

    submit() {
      this.update();
    },

    update() {
      let uri = `/api/therapist-intro`;
      this.isLoading = true;

      this.axios.put(uri, this.intro).then(response => {
        this.$router.push({ name: "therapists" });
        this.$notify({ type: "success", text: "Einführungstext gespeichert!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },
  },
};
</script>
