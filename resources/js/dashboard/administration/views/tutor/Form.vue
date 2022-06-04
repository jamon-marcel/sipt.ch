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
            <input type="text" v-model="tutor.email" :disabled="this.$props.type == 'edit' ? true : false">
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
            <div class="grid grid-1-1-1">
              <div>
                <label>PLZ</label>
                <input type="text" v-model="tutor.zip">
              </div>
              <div>
                <label>Ort</label>
                <input type="text" v-model="tutor.city">
              </div>
              <div>
                <label>Land</label>
                <input type="text" v-model="tutor.country">
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
            <label>Veröffentlichungen</label>
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
              <div class="form-row is-sm">
                <radio-button 
                  :label="'Aktiv?'"
                  v-bind:is_published.sync="tutor.is_published"
                  :model="tutor.is_published"
                  :name="'is_published'">
                </radio-button>
              </div>
              <div class="form-row is-sm is-last">
                <radio-button 
                  :label="'Sichtbar?'"
                  v-bind:is_visible.sync="tutor.is_visible"
                  :model="tutor.is_visible"
                  :name="'is_visible'">
                </radio-button>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div v-show="tabs.image.active">
      <div class="grid-main-sidebar">
        <div>
          <div class="form-row" v-if="tutor.images.length == 0">
            <image-upload
              :restrictions="'jpg, png | max. 8 MB'"
              :maxFiles="99"
              :maxFilesize="8"
              :acceptedFiles="'.png,.jpg'"
            ></image-upload>
          </div>
          <div class="form-row">
            <image-edit 
              :images="tutor.images"
              :imagePreviewRoute="'portrait'"
              :aspectRatioW="4"
              :aspectRatioH="3"
            ></image-edit>
          </div>
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
import Tabs from "@/global/components/ui/Tabs.vue";

// Upload
import ImageUpload from "@/global/components/images/Upload.vue";
import ImageEdit from "@/global/components/images/Edit.vue";

// Tabs config
import tabsConfig from "@/administration/views/tutor/config/tabs.js";

export default {
  components: {
    ArrowLeftIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    ImageUpload,
    ImageEdit,
    Tabs
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
        country: null,
        phone: null,
        mobile: null,
        description: null,
        emphasis: null,
        publications: null,
        is_published: 0,
        is_visible: 0,
        user_id: null,
        email: null,
        images: [],
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

      // Tabs
      tabs: tabsConfig,

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
        this.tutor.email = response.data.user.email;
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
        this.axios.post('/api/tutor', this.tutor).then(response => {
          this.$router.push({ name: "tutors" });
          this.$notify({ type: "success", text: "Dozent erfasst!" });
          this.isLoading = false;
        });
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

    // Store uploaded image
    storeImage(upload) {
      let image = {
        id: null,
        name: upload.name,
        caption: null,
        coords_w: 0,
        coords_h: 0,
        coords_x: 0,
        coords_y: 0,
        orientation: upload.orientation,
        publish: 1,
      }
      this.tutor.images.push(image);
    },

    // Delete by name
    destroyImage(image, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/tutor/image/${image}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const index = this.tutor.images.findIndex(x => x.name === image);
          this.tutor.images.splice(index, 1);
          this.isLoading = false;
        });
      }
    },

    // Toggle image status
    toggleImage(image, event) {
      if (image.id === null) {
        const index = this.tutor.images.findIndex(x => x.name === image.name);
        this.tutor.images[index].publish = image.publish == 1 ? 0 : 1;
      } else {
        let uri = `/api/tutor/image/state/${image.id}`;
        this.isLoading = true;
        this.axios.get(uri).then(response => {
          const index = this.tutor.images.findIndex(x => x.id === image.id);
          this.tutor.images[index].publish = response.data;
          this.isLoading = false;
        });
      }
    },

    // Save coords
    saveImageCoords(image) {
      if (image.id === null) {
        const index = this.tutor.images.findIndex(x => x.name === image.name);
        this.tutor.images[index].coords = image.coords;
      } 
      else {
        let uri = `/api/tutor/image/${image.id}`;
        this.isLoading = true;
        this.axios.put(uri, image).then(response => {
          this.$notify({ type: "success", text: "Änderungen gespeichert!" });
          this.isLoading = false;
        });
      }
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
