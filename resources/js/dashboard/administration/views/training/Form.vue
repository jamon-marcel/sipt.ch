<template>
  <form @submit.prevent="submit">
    <header class="module-header">
      <h1>{{title}}</h1>
    </header>
    <tabs :tabs="tabs" :errors="errors"></tabs>
    <div v-show="tabs.data.active">
      <div class="grid-main-sidebar">
        <div>
          <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
            <label>Titel *</label>
            <input type="text" v-model="training.title">
            <div class="is-required">Pflichtfeld</div>
          </div>
          <div :class="[this.errors.description_short ? 'has-error' : '', 'form-row']">
            <label>Kurzbeschreibung *</label>
            <tinymce-editor
              :api-key="tinyApiKey"
              :init="tinyConfigSmall"
              v-model="training.description_short"
            ></tinymce-editor>
            <div class="is-required">Pflichtfeld</div>
          </div>
          <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
            <label>Beschreibung *</label>
            <tinymce-editor :api-key="tinyApiKey" :init="tinyConfig" v-model="training.description"></tinymce-editor>
            <div class="is-required">Pflichtfeld</div>
          </div>
          <div class="form-row">
            <label>Aufbau der Fortbildung</label>
            <tinymce-editor :api-key="tinyApiKey" :init="tinyConfig" v-model="training.structure"></tinymce-editor>
          </div>
          <div class="form-row">
            <label>Supervision</label>
            <tinymce-editor
              :api-key="tinyApiKey"
              :init="tinyConfigSmall"
              v-model="training.supervision"
            ></tinymce-editor>
          </div>
          <div class="form-row">
            <label>Abschlussarbeit</label>
            <tinymce-editor :api-key="tinyApiKey" :init="tinyConfigSmall" v-model="training.thesis"></tinymce-editor>
          </div>
          <div class="form-row">
            <label>Zertifizierung</label>
            <tinymce-editor
              :api-key="tinyApiKey"
              :init="tinyConfig"
              v-model="training.certification"
            ></tinymce-editor>
          </div>
          <div class="form-row">
            <label>Kosten</label>
            <tinymce-editor :api-key="tinyApiKey" :init="tinyConfigSmall" v-model="training.cost"></tinymce-editor>
          </div>
          <div class="form-row">
            <label>Unterrichtszeiten</label>
            <tinymce-editor :api-key="tinyApiKey" :init="tinyConfigSmall" v-model="training.time"></tinymce-editor>
          </div>
          <template v-if="isFetched">
            <div :class="this.errors.location_id ? 'has-error' : ''">
              <locations
                v-bind:location_id.sync="training.location_id"
                :label="'Kursort'"
                :model="training.location_id"
                :name="'location_id'"
                :required="true"
              ></locations>
            </div>
            <div :class="this.errors.category_id ? 'has-error' : ''">
              <categories
                v-bind:category_id.sync="training.category_id"
                :label="'Kategorie'"
                :model="training.category_id"
                :name="'category_id'"
                :required="true"
                :cssClass="'is-sm'"
              ></categories>
            </div>
          </template>
        </div>
        <div class="grid-column-sidebar">
          <div>
            <template v-if="isFetched">
              <div class="form-row is-sm">
                <radio-button
                  :label="'CAS?'"
                  v-bind:is_cas.sync="training.is_cas"
                  :model="training.is_cas"
                  :name="'is_cas'"
                ></radio-button>
              </div>
              <div class="form-row is-sm is-last">
                <radio-button
                  :label="'Publizieren?'"
                  v-bind:is_published.sync="training.is_published"
                  :model="training.is_published"
                  :name="'is_published'"
                ></radio-button>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div v-show="tabs.modules.active">
      <div class="grid-main-sidebar">
        <div>
          <template v-if="isFetched">
            <courses
              v-bind:courses.sync="training.courses"
              :label="'Modul hinzufügen'"
              :labelSelected="'Module'"
              :data="training.courses"
            ></courses>
          </template>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'trainings' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</template>
<script>
// Icons
import { ArrowLeftIcon } from "vue-feather-icons";

// Error Handling (mixin)
import ErrorHandling from "@/global/mixins/ErrorHandling";

// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import tinyConfigSmall from "@/global/config/tiny-small.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import Locations from "@/administration/components/Locations.vue";
import Courses from "@/administration/components/Courses.vue";
import Categories from "@/administration/components/TrainingCategories.vue";
import Tabs from "@/global/components/ui/Tabs.vue";

// Config
import tabsConfig from "@/administration/views/training/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    Locations,
    Categories,
    Courses,
    Tabs
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      training: {
        title: null,
        description: null,
        description_short: null,
        structure: null,
        supervision: null,
        thesis: null,
        certification: null,
        cost: null,
        time: null,
        location_id: null,
        category_id: null,
        courses: [],
        is_published: 0,
        is_cas: 0
      },

      // Validation
      errors: {
        title: false,
        description: false,
        description_short: false,
        location_id: false,
        category_id: false
      },

      // Lazy loading
      isFetched: true,

      // Tabs
      tabs: tabsConfig,

      // TinyMCE
      tinyConfig: tinyConfig,
      tinyConfigSmall: tinyConfigSmall,
      tinyApiKey: "vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro"
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/training/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.training = response.data;
        this.training.courses = 
          this.training.courses.map(x => ({
            title: x.title,
            id: x.id
          }))
        ;
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

    addCourse(course) {
      this.training.courses.push(course);
    },

    removeCourse(id) {
      const idx = this.training.courses.findIndex(x => x.id === id);
      this.training.courses.splice(idx, 1);
    }
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