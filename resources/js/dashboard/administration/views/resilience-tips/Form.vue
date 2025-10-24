<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{ title }}</h1>
      </header>
      <div>

        <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
          <label>Titel</label>
          <input type="text" v-model="resilienceTip.title">
          <label-required/>
        </div>

        <div :class="[this.errors.subtitle ? 'has-error' : '', 'form-row']">
          <label>Untertitel</label>
          <input type="text" v-model="resilienceTip.subtitle">
        </div>

        <div :class="[this.errors.description ? 'has-error' : '', 'form-row']">
          <label>Beschreibung</label>
          <textarea v-model="resilienceTip.description" rows="4"></textarea>
        </div>

        <div :class="[this.errors.file ? 'has-error' : '', 'form-row']">
          <label>Datei</label>

          <!-- Show file listing when there's a file (original or newly uploaded) -->
          <div v-if="hasFile" class="upload-wrapper">
            <file-listing :files="fileList"></file-listing>
          </div>

          <!-- Show upload component when no file exists -->
          <div v-else class="upload-wrapper">
            <file-upload
              :restrictions="'PDF, ZIP, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT | max. 50 MB'"
              :maxFiles="1"
              :maxFilesize="50"
              :acceptedFiles="'.pdf,.zip,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt'"
            ></file-upload>
          </div>
        </div>

      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'resilience-tips' }" class="btn-secondary">
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
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import LabelInfo from "@/global/components/ui/LabelInfo.vue";
import FileUpload from "@/global/components/files/Upload.vue";
import FileListing from "@/global/components/files/Edit.vue";

export default {
  components: {
    LabelRequired,
    LabelInfo,
    FileUpload,
    FileListing,
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      resilienceTip: {
        title: '',
        subtitle: '',
        description: '',
        is_published: 1,
        file: null
      },

      // Original file (for edit mode)
      originalFile: null,

      // Validation
      errors: {
        title: false,
        subtitle: false,
        description: false,
        file: false,
      },

      // Loading state
      isLoading: false,
      isFetched: true,
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/resilience-tip/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.resilienceTip = {
          title: response.data.title,
          subtitle: response.data.subtitle,
          description: response.data.description,
          is_published: response.data.is_published,
          file: null
        };

        // Store original file info
        if (response.data.file) {
          this.originalFile = response.data.file;
        }

        this.isFetched = true;
      });
    }
  },

  methods: {

    storeFile(upload) {
      this.resilienceTip.file = upload.name;
    },

    destroy(file) {
      if (!confirm("Datei wirklich löschen?")) {
        return;
      }

      if (this.$props.type == "edit" && this.originalFile) {
        // Delete file immediately in edit mode
        let uri = `/api/resilience-tip/file/${this.$route.params.id}`;
        this.isLoading = true;

        this.axios.delete(uri).then(response => {
          this.originalFile = null;
          this.resilienceTip.file = null;
          this.$notify({ type: "success", text: "Datei gelöscht!" });
          this.isLoading = false;
        }).catch(error => {
          this.isLoading = false;
        });
      } else if (this.$props.type == "create" && this.resilienceTip.file) {
        // In create mode, delete the uploaded file from storage
        let uri = `/api/resilience-tip/file/temp`;
        this.isLoading = true;

        this.axios.delete(uri, {
          data: { filename: this.resilienceTip.file }
        }).then(response => {
          this.resilienceTip.file = null;
          this.$notify({ type: "success", text: "Datei gelöscht!" });
          this.isLoading = false;
        }).catch(error => {
          this.isLoading = false;
        });
      }
    },

    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      let uri = "/api/resilience-tip";
      this.isLoading = true;

      this.axios.post(uri, this.resilienceTip).then(response => {
        this.$router.push({ name: "resilience-tips" });
        this.$notify({ type: "success", text: "Aufbau-Tipp erfasst!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/resilience-tip/${this.$route.params.id}`;
      this.isLoading = true;

      this.axios.put(uri, this.resilienceTip).then(response => {
        this.$router.push({ name: "resilience-tips" });
        this.$notify({ type: "success", text: "Aufbau-Tipp gespeichert!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Aufbau-Tipp bearbeiten" : "Aufbau-Tipp hinzufügen";
    },

    hasFile: function() {
      return this.resilienceTip.file !== null || this.originalFile !== null;
    },

    fileList: function() {
      // Show newly uploaded file if exists
      if (this.resilienceTip.file) {
        return [{name: this.resilienceTip.file}];
      }
      // Show original file in edit mode
      if (this.originalFile) {
        return [{name: this.originalFile}];
      }
      return [];
    }
  }
};
</script>

<style scoped>
.current-file-info {
  margin-top: 10px;
  padding: 10px;
  background: #f5f5f5;
  border-radius: 4px;
}
</style>
