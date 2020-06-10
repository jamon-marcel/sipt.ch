<template>
  <form @submit.prevent="submit" :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
          <label>Titel *</label>
          <input type="text" v-model="course.title">
          <label-required />
        </div>
        <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
          <label>Beschreibung *</label>
          <tinymce-editor
            :api-key="tinyApiKey"
            :init="tinyConfig"
            v-model="course.description"
          ></tinymce-editor>
        </div>
        <div :class="[this.errors.credits ? 'has-error' : '', 'form-row']">
          <label>Credits *</label>
          <input type="text" v-model="course.credits">
          <label-required />
        </div>
        <div :class="[this.errors.durability ? 'has-error' : '', 'form-row']">
          <label>Kursdauer (Stunden) *</label>
          <input type="text" v-model="course.durability">
          <label-required />
        </div>
        <div :class="[this.errors.cost ? 'has-error' : '', 'form-row']">
          <label>Kosten *</label>
          <input type="text" v-model="course.cost">
          <label-required />
        </div>
      </div>
      <div class="grid-column-sidebar">
        <div>
          <template v-if="isFetched">
            <div class="form-row is-sm">
              <radio-button 
                :label="'Archivieren?'"
                v-bind:is_archived.sync="course.is_archived"
                :model="course.is_archived"
                :name="'is_archived'">
              </radio-button>
            </div>
            <div class="form-row is-sm is-last">
              <radio-button 
                :label="'Publizieren?'"
                v-bind:is_published.sync="course.is_published"
                :model="course.is_published"
                :name="'is_published'">
              </radio-button>
            </div>
          </template>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'courses' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</template>
<script>

// Icons
import { ArrowLeftIcon } from 'vue-feather-icons';

// Error Handling (mixin)
// import ErrorHandling from "@/global/mixins/ErrorHandling";

// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired
  },

  // mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      course: {
        title: null,
        description: null,
        credits: null,
        durability: null,
        cost: null,
        is_archived: 0,
        is_published: 0,
      },

      // Validation
      errors: {
        title: false,
        description: false,
      },

      // Lazy loading
      isFetched: true,

      // TinyMCE
      tinyConfig: tinyConfig,
      tinyApiKey: 'vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro',
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      this.axios.get(`/api/course/edit/${this.$route.params.id}`).then(response => {
        this.course = response.data;
        this.isFetched = true;
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
      let uri = "/api/course/create";
      this.axios.post(uri, this.course).then(response => {
        this.$router.push({ name: "courses" });
        this.$notify({ type: "success", text: "Fortbildung erfasst!" });
      });
    },

    update() {
      let uri = `/api/course/update/${this.$route.params.id}`;
      this.axios.post(uri, this.course).then(response => {
        this.$router.push({ name: "courses" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Modul bearbeiten" 
        : "Modul hinzufügen";
    }
  }
};
</script>
