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
          <input type="text" v-model="download.title">
          <label-required/>
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
          <router-link :to="{ name: 'downloads' }" class="btn-secondary">
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
      download: {
        title: '',
        is_published: 1,
        file: null
      },

      // Original file (for edit mode)
      originalFile: null,

      // Validation
      errors: {
        title: false,
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
      let uri = `/api/download/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.download = {
          title: response.data.title,
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
      this.download.file = upload.name;
    },

    destroy(file) {
      if (!confirm("Datei wirklich löschen?")) {
        return;
      }

      if (this.$props.type == "edit" && this.originalFile) {
        // Delete file immediately in edit mode
        let uri = `/api/download/file/${this.$route.params.id}`;
        this.isLoading = true;

        this.axios.delete(uri).then(response => {
          this.originalFile = null;
          this.download.file = null;
          this.$notify({ type: "success", text: "Datei gelöscht!" });
          this.isLoading = false;
        }).catch(error => {
          this.isLoading = false;
        });
      } else if (this.$props.type == "create" && this.download.file) {
        // In create mode, delete the uploaded file from storage
        let uri = `/api/download/file/temp`;
        this.isLoading = true;

        this.axios.delete(uri, {
          data: { filename: this.download.file }
        }).then(response => {
          this.download.file = null;
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
      let uri = "/api/download";
      this.isLoading = true;

      this.axios.post(uri, this.download).then(response => {
        this.$router.push({ name: "downloads" });
        this.$notify({ type: "success", text: "Download erfasst!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/download/${this.$route.params.id}`;
      this.isLoading = true;

      this.axios.put(uri, this.download).then(response => {
        this.$router.push({ name: "downloads" });
        this.$notify({ type: "success", text: "Download gespeichert!" });
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Download bearbeiten" : "Download hinzufügen";
    },

    hasFile: function() {
      return this.download.file !== null || this.originalFile !== null;
    },

    fileList: function() {
      // Show newly uploaded file if exists
      if (this.download.file) {
        return [{name: this.download.file}];
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
