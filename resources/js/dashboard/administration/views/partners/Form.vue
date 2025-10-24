<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{ title }}</h1>
      </header>

      <div>
        <!-- Name Field -->
        <div :class="[errors.name ? 'has-error' : '', 'form-row']">
          <label>Name</label>
          <input type="text" v-model="institution.name">
          <label-required/>
          <label-info v-if="errors.name" :message="errors.name"></label-info>
        </div>

        <!-- Description Field with TinyMCE -->
        <div :class="[errors.description ? 'has-error' : '', 'form-row']">
          <label>Beschreibung</label>
          <tinymce-editor
            :init="tinyConfig"
            v-model="institution.description">
          </tinymce-editor>
          <label-info v-if="errors.description" :message="errors.description"></label-info>
        </div>
      </div>

      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary" :disabled="isLoading">
            Speichern
          </button>
          <router-link :to="{ name: 'partners' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</template>

<script>
import ErrorHandling from "@/global/mixins/ErrorHandling";
import tinyConfig from "@/global/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import LabelInfo from "@/global/components/ui/LabelInfo.vue";

export default {
  components: {
    TinymceEditor,
    LabelRequired,
    LabelInfo
  },
  mixins: [ErrorHandling],
  props: {
    type: String
  },
  data() {
    return {
      institution: {
        name: '',
        description: '',
        is_published: 1
      },
      errors: {
        name: false,
        description: false
      },
      tinyConfig: tinyConfig,
      isLoading: false,
      isFetched: true,
    };
  },
  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      this.isLoading = true;
      this.axios.get(`/api/partner-institution/${this.$route.params.id}`)
        .then(response => {
          this.institution = response.data;
          this.isFetched = true;
          this.isLoading = false;
        })
        .catch(() => {
          this.isLoading = false;
        });
    }
  },
  methods: {
    submit() {
      this.$props.type == "edit" ? this.update() : this.store();
    },
    store() {
      this.isLoading = true;
      this.axios.post("/api/partner-institution", this.institution)
        .then(() => {
          this.$router.push({ name: "partners" });
          this.$notify({ type: "success", text: "Erfolgreich erstellt!" });
        })
        .catch(() => {
          this.isLoading = false;
        });
    },
    update() {
      this.isLoading = true;
      this.axios.put(`/api/partner-institution/${this.$route.params.id}`, this.institution)
        .then(() => {
          this.$router.push({ name: "partners" });
          this.$notify({ type: "success", text: "Erfolgreich aktualisiert!" });
        })
        .catch(() => {
          this.isLoading = false;
        });
    }
  },
  computed: {
    title() {
      return this.$props.type == "edit" ? "Bearbeiten" : "Hinzufügen";
    }
  }
};
</script>
