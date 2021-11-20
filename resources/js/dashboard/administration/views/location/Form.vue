<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{title}}</h1>
      </header>
      <tabs :tabs="tabs" :errors="errors"></tabs>
      <div v-show="tabs.data.active">
        <div>
          <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
            <label>Name *</label>
            <input type="text" v-model="location.name">
            <label-required/>
          </div>
          <div :class="[this.errors.name_short ? 'has-error' : '', 'form-row']">
            <label>Name (kurz) *</label>
            <input type="text" v-model="location.name_short">
            <label-required/>
          </div>
          <div :class="[this.errors.street ? 'has-error' : '', 'form-row']">
            <label>Strasse *</label>
            <input type="text" v-model="location.street">
            <label-required/>
          </div>
          <div class="form-row">
            <label>Nr.</label>
            <input type="text" v-model="location.street_no">
          </div>
          <div :class="[this.errors.zip ? 'has-error' : '', 'form-row']">
            <label>PLZ</label>
            <input type="text" v-model="location.zip">
            <label-required/>
          </div>
          <div :class="[this.errors.city ? 'has-error' : '', 'form-row']">
            <label>Ort</label>
            <input type="text" v-model="location.city">
            <label-required/>
          </div>
          <div class="form-row">
            <label>Google Maps Link</label>
            <input type="text" v-model="location.maps_uri">
          </div>
        </div>
      </div>
      <div v-show="tabs.upload.active">
        <template v-if="isFetched">
          <div class="upload-wrapper">
            <div class="sa-sm">
              <div class="form-row">
                <file-upload
                  :restrictions="'pdf, ppt, pptx, doc, docx | max. 16 MB'"
                  :maxFiles="1"
                  :maxFilesize="8"
                  :acceptedFiles="'.pdf,.ppt,.pptx,.doc,.docx'"
                ></file-upload>
              </div>
            </div>
            <div>
              <div class="form-row">
                <file-listing :files="location.maps_file"></file-listing>
              </div>
            </div>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'locations' }" class="btn-secondary">
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
import Tabs from "@/global/components/ui/Tabs.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import FileUpload from "@/global/components/files/Upload.vue";
import FileListing from "@/global/components/files/Edit.vue";

// Tabs config
import tabsConfig from "@/administration/views/location/config/tabs.js";

export default {
  components: {
    LabelRequired,
    Tabs,
    FileUpload,
    FileListing
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      location: {
        name: null,
        name_short: null,
        street: null,
        street_no: null,
        zip: null,
        city: null,
        maps_uri: null,
        maps_file: [],
        file: [],
      },

      // Validation
      errors: {
        name: false,
        name_short: false,
        street: false,
        zip: false,
        city: false
      },

      // Loading state
      isLoading: false,
      isFetched: true,

      // Tabs
      tabs: tabsConfig,
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/location/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.location = response.data;
        if (response.data.maps_file) {
          this.location.maps_file = [{
            'name': response.data.maps_file,
          }];
        }
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
      let uri = "/api/location";
      this.isLoading = true;
      this.axios.post(uri, this.location).then(response => {
        this.$router.push({ name: "locations" });
        this.$notify({ type: "success", text: "Ort erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/location/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.location).then(response => {
        this.$router.push({ name: "locations" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },

    storeFile(upload) {
      this.location.maps_file = [];
      this.location.maps_file.push({name: upload.name});
    },

    destroy(file) {
      this.location.maps_file = [];
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit"
        ? "Veranstaltungsort bearbeiten"
        : "Veranstaltungsort hinzufügen";
    }
  }
};
</script>