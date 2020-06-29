<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
          <label>Vorname *</label>
          <input type="text" v-model="tutor.firstname">
          <label-required />
        </div>
        <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
          <label>Name *</label>
          <input type="text" v-model="tutor.name">
          <label-required />
        </div>
        <div :class="[this.errors.email ? 'has-error' : '', 'form-row']">
          <label>E-Mail *</label>
          <input type="text" v-model="tutor.user.email" :disabled="this.$props.type == 'edit' ? true : false">
          <label-required />
        </div>
        <div class="form-row">
          <label>Titel</label>
          <input type="text" v-model="tutor.title">
        </div>
        <div class="form-row">
          <label>Telefon</label>
          <input type="text" v-model="tutor.phone">
        </div>
        <div class="form-row">
          <label>Mobile</label>
          <input type="text" v-model="tutor.mobile">
        </div>
        <div class="form-row">
          <div class="grid grid-3-1">
            <div>
              <label>Strasse</label>
              <input type="text" v-model="tutor.street">
            </div>
            <div>
              <label>Nr.</label>
              <input type="text" v-model="tutor.street_no">
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="grid grid-1-3">
            <div>
              <label>PLZ</label>
              <input type="text" v-model="tutor.zip">
            </div>
            <div>
              <label>Ort</label>
              <input type="text" v-model="tutor.city">
            </div>
          </div>
        </div>
        <div class="form-row">
          <label>Beschreibung</label>
          <textarea name="description" v-model="tutor.description"></textarea>
        </div>
        <div class="form-row">
          <label>Themenschwerpunkte</label>
          <tinymce-editor
            :api-key="tinyApiKey"
            :init="tinyConfig"
            v-model="tutor.emphasis"
          ></tinymce-editor>
        </div>
        <div class="form-row">
          <label>Veröffentlichungen</label>
          <tinymce-editor
            :api-key="tinyApiKey"
            :init="tinyConfig"
            v-model="tutor.publications"
          ></tinymce-editor>
        </div>
      </div>
      <div class="grid-column-sidebar">
        <div>
          <template v-if="isFetched">
            <div class="form-row is-sm is-last">
              <radio-button 
                :label="'Publizieren?'"
                v-bind:is_published.sync="tutor.is_published"
                :model="tutor.is_published"
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
        <router-link :to="{ name: 'tutors' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</div>
</template>
<script>

// Icons
import { ArrowLeftIcon } from 'vue-feather-icons';

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

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

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      tutor: {
        firstname: null,
        name: null,
        title: null,
        street: null,
        street_no: null,
        zip: null,
        city: null,
        phone: null,
        mobile: null,
        description: null,
        emphasis: null,
        publications: null,
        is_published: 0,
        user_id: null,
        user: {
          email: null,
        },
      },

      // Validation
      errors: {
        firstname: false,
        name: false,
        email: false,
      },

      // Loading states
      isFetched: true,
      isLoading: false,

      // TinyMCE
      tinyConfig: tinyConfig,
      tinyApiKey: 'vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro',
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/tutor/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.tutor = response.data;
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
      if (this.tutor.user_id != null) {
        this.isLoading = true;
        this.axios.post('/api/tutor', this.tutor).then(response => {
          this.$router.push({ name: "tutors" });
          this.$notify({ type: "success", text: "Dozent erfasst!" });
          this.isLoading = false;
        });
      }
      else {
        this.isLoading = true;
        this.axios.post('/api/user/tutor/register', this.tutor.user).then(response => {
          this.tutor.user_id = response.data.userId;
          this.axios.post('/api/tutor', this.tutor).then(response => {
            this.$router.push({ name: "tutors" });
            this.$notify({ type: "success", text: "Dozent erfasst!" });
            this.isLoading = false;
          });
        })
      }
    },

    update() {
      let uri = `/api/tutor/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.tutor).then(response => {
        this.$router.push({ name: "tutors" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Dozent bearbeiten" 
        : "Dozent hinzufügen";
    }
  }
};
</script>
