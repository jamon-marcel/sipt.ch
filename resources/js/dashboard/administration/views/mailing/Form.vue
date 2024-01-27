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

          <div :class="[this.errors.salutation ? 'has-error' : '', 'form-row']">
            <label>Anrede *</label>
            <textarea v-model="mailing.salutation" class="small"></textarea>
            <label-required/>
          </div>
          <div :class="[this.errors.subject ? 'has-error' : '', 'form-row']">
            <label>Betreff *</label>
            <input type="text" v-model="mailing.subject">
            <label-required/>
          </div>
          <div :class="[this.errors.body ? 'has-error' : '', 'form-row']">
            <label>Inhalt *</label>
            <tinymce-editor
              :api-key="tinyApiKey"
              :init="tinyConfig"
              v-model="mailing.body"
            ></tinymce-editor>
          </div>
          <div :class="[this.errors.greetings ? 'has-error' : '', 'form-row']">
            <label>Grusszeile *</label>
            <textarea v-model="mailing.greetings" class="small"></textarea>
            <label-required/>
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
                <file-listing :files="mailing.attachments"></file-listing>
              </div>
            </div>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'mailings' }" class="btn-secondary">
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

// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Tabs config
import tabsConfig from "@/administration/views/mailing/config/tabs.js";

export default {
  components: {
    LabelRequired,
    Tabs,
    TinymceEditor,
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
      mailing: {
        salutation: 'Liebe Kolleginnen und Kollegen',
        subject: null,
        body: null,
        greetings: 'Beste Grüsse\nRosmarie Barwinski',
        attachments: []
      },

      // Validation
      errors: {
        salutation: false,
        subject: false,
        body: false,
        greetings: false,
      },

      // Loading state
      isLoading: false,
      isFetched: true,

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
      let uri = `/api/mailing/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.mailing = response.data;
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
      let uri = "/api/mailing";
      this.isLoading = true;
      this.axios.post(uri, this.mailing).then(response => {
        this.$router.push({ name: "mailings" });
        this.$notify({ type: "success", text: "Mailing erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/mailing/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.mailing).then(response => {
        this.$router.push({ name: "mailings" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },

    storeFile(upload) {
      this.mailing.attachments.push({name: upload.name});
    },

    destroy(file) {
      this.mailing.attachments.splice(
        this.mailing.attachments.indexOf(file),
        1
      );
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Mailing bearbeiten" : "Mailing hinzufügen";
    }
  }
};
</script>