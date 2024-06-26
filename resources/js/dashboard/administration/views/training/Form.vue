<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{title}}</h1>
      </header>
      <tabs :tabs="tabs" :errors="errors"></tabs>
      <div v-show="tabs.data.active">
        <div class="grid-main-sidebar">
          <div>
            <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
              <label>Titel *</label>
              <input type="text" v-model="training.title">
              <label-required/>
            </div>
            <div :class="[this.errors.description_short ? 'has-error' : '', 'form-row']">
              <label>Kurzbeschreibung *</label>
              <tinymce-editor
                :init="tinyConfig"
                v-model="training.description_short"
              ></tinymce-editor>
              <label-required/>
            </div>
            <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
              <label>Beschreibung *</label>
              <tinymce-editor
                :init="tinyConfig"
                v-model="training.description"
              ></tinymce-editor>
              <label-required/>
            </div>
            <div class="form-row">
              <label>Aufbau der Fortbildung</label>
              <tinymce-editor :api-key="tinyApiKey" :init="tinyConfig" v-model="training.structure"></tinymce-editor>
            </div>
            <div class="form-row">
              <label>Supervision</label>
              <tinymce-editor
                :init="tinyConfigSmall"
                v-model="training.supervision"
              ></tinymce-editor>
            </div>
            <div class="form-row">
              <label>Abschlussarbeit</label>
              <tinymce-editor
                :init="tinyConfigSmall"
                v-model="training.thesis"
              ></tinymce-editor>
            </div>
            <div class="form-row">
              <label>Zertifizierung</label>
              <tinymce-editor
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
              <tinymce-editor
                :init="tinyConfigSmall"
                v-model="training.time"
                :initial-value="'Freitag: 18.00 bis 21.15 Uhr (4 Unterrichts-Einheiten)<br>Samstag: 09.00 bis 16.30 Uhr (8 Unterrichts-Einheiten)'"
              ></tinymce-editor>
            </div>
            <template v-if="isFetched">
              <div :class="this.errors.location_id ? 'has-error' : ''">
                <location-selector
                  v-bind:location_id.sync="training.location_id"
                  :label="'Kursort'"
                  :model="training.location_id"
                  :name="'location_id'"
                  :required="true"
                ></location-selector>
              </div>
              <div :class="this.errors.category_id ? 'has-error' : ''">
                <training-category-selector
                  v-bind:category_id.sync="training.category_id"
                  :label="'Kategorie'"
                  :model="training.category_id"
                  :name="'category_id'"
                  :required="true"
                  :cssClass="'is-sm'"
                ></training-category-selector>
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
              <course-selector
                v-bind:courses.sync="training.courses"
                :label="'Modul hinzufügen'"
                :labelSelected="'Module'"
                :data="training.courses"
              ></course-selector>
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
  </div>
</template>
<script>
// Icons
import { ArrowLeftIcon } from "vue-feather-icons";

// Error Handling
import ErrorHandling from "@/global/mixins/ErrorHandling";

// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import tinyConfigSmall from "@/global/config/tiny-small.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import LocationSelector from "@/administration/components/LocationSelector.vue";
import CourseSelector from "@/administration/components/CourseSelector.vue";
import TrainingCategorySelector from "@/administration/components/TrainingCategorySelector.vue";
import Tabs from "@/global/components/ui/Tabs.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

// Tabs config
import tabsConfig from "@/administration/views/training/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    LocationSelector,
    TrainingCategorySelector,
    CourseSelector,
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
        location_id: "76ab6fee-bb20-4d36-b456-a1d606e45c78",
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

      // Loading state
      isLoading: false,
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
      let uri = `/api/training/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.training = response.data;
        this.training.courses = this.training.courses.map(x => ({
          title: x.title,
          id: x.id
        }));
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
      let uri = "/api/training";
      this.isLoading = true;
      this.axios.post(uri, this.training).then(response => {
        this.$router.push({ name: "trainings" });
        this.$notify({ type: "success", text: "Fortbildung erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/training/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.training).then(response => {
        this.$router.push({ name: "trainings" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
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