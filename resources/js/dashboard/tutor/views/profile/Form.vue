<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div v-if="isFetched">
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>Profil bearbeiten</h1>
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
            <div class="form-row">
              <label>Titel</label>
              <input type="text" v-model="tutor.title">
            </div>
            <div class="form-row">
              <div class="grid grid-3-1">
                <div :class="[this.errors.street ? 'has-error' : '', 'form-row-grid']">
                  <label>Strasse</label>
                  <input type="text" v-model="tutor.street">
                </div>
                <div :class="[this.errors.street_no ? 'has-error' : '', 'form-row-grid']">
                  <label>Nr.</label>
                  <input type="text" v-model="tutor.street_no">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="grid grid-1-1-1">
                <div :class="[this.errors.zip ? 'has-error' : '', 'form-row-grid']">
                  <label>PLZ</label>
                  <input type="text" v-model="tutor.zip">
                </div>
                <div :class="[this.errors.city ? 'has-error' : '', 'form-row-grid']">
                  <label>Ort</label>
                  <input type="text" v-model="tutor.city">
                </div>
                <div class="form-row-grid">
                  <label>Land</label>
                  <input type="text" v-model="tutor.country">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="grid grid-1-1">
                <div :class="[this.errors.phone ? 'has-error' : '', 'form-row-grid']">
                  <label>Telefon</label>
                  <input type="text" v-model="tutor.phone">
                  <label-required />
                </div>
                <div class="form-row-grid">
                  <label>Mobile</label>
                  <input type="text" v-model="tutor.mobile">
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
                :init="tinyConfig"
                v-model="tutor.emphasis"
              ></tinymce-editor>
            </div>
            <div class="form-row">
              <label>Veröffentlichungen</label>
              <tinymce-editor
                :init="tinyConfig"
                v-model="tutor.publications"
              ></tinymce-editor>
            </div>
            <div class="form-row">
              <label>Medien (Youtube, Podcast etc.)</label>
              <textarea v-model="tutor.media"></textarea>
            </div>

            <mailinglists :email="tutor.user.email" />

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
          <router-link :to="{ name: 'profile' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</div>

</template>
<script>

// Icons
import { ToggleLeftIcon, ToggleRightIcon } from 'vue-feather-icons';

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
import tabsConfig from "@/tutor/views/profile/config/tabs.js";

import Mailinglists from "@/global/components/Mailinglists.vue";


export default {
  components: {
    ToggleLeftIcon,
    ToggleRightIcon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    ImageUpload,
    ImageEdit,
    Tabs,
    Mailinglists
  },

  mixins: [ErrorHandling],

  data() {
    return {
      tutor: {
        user: {
          email: null,
          is_newsletter_subscriber: 0,
        },
        images: [],
      },

      errors: {
        firstname: false,
        name: false,
        street: false,
        street_no: false,
        zip: false,
        city: false,
        country: false,
        phone: false,
      },

      // Loading state
      isFetched: true,
      isLoading: false,

      // Tabs
      tabs: tabsConfig,

      // TinyMCE
      tinyConfig: tinyConfig,

    };
  },

  created() {
    this.isFetched = false;
    let uri = `/api/tutor/${this.$route.params.id}`;
    this.axios.get(uri).then(response => {
      this.tutor = response.data;
      this.isFetched = true;
    });
  },

  methods: {

    submit() {
      let uri = `/api/tutor/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.tutor).then(response => {
        this.$router.push({ name: "profile" });
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
};
</script>