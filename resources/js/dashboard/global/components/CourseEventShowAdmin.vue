<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <div class="content">
        <template v-if="isFetched">
          <h1>
            Modul:
            <strong>{{ course_event.course.title }}</strong>
          </h1>
          <h2 class="is-narrow">Beschreibung</h2>
          <p v-html="course_event.course.description">{{ course_event.course.description }}</p>
          <hr>
          <h2 class="is-narrow">Ort</h2>
          <p>{{ course_event.location.name }}, {{ course_event.location.city }}</p>
          <hr>
          <div v-if="$props.isAdmin">
            <h2 class="is-narrow">Max. Teilnehmer</h2>
            <p>{{ course_event.max_participants }}</p>
            <hr>
          </div>
          <h2 class="is-narrow">Daten</h2>
          <div class="listing">
            <div class="listing__item" v-for="date in course_event.dates" :key="date.id">
              <div class="listing__item-body">
                {{date.date}}
                <span class="separator">&bull;</span>
                {{date.timeStart}} – {{date.timeEnd}} Uhr
                <span class="separator">&bull;</span>
                {{date.tutor.title}} {{date.tutor.firstname}} {{date.tutor.name}}
              </div>
            </div>
          </div>

          <div class="flex-sb sb-md">
            <h2 class="is-narrow">
              Angemeldete Teilnehmer
              <em v-if="course_event.students.length">({{course_event.students.length}})</em>
            </h2>
            <a href class="feather-icon feather-icon--prepend">
              <users-icon size="16"></users-icon>
              <span>Teilnehmerliste</span>
            </a>
          </div>
          <div v-if="course_event.students.length">
            <div class="listing">
              <div
                class="listing__item"
                v-for="student in course_event.students"
                :key="student.id"
              >
                <div class="listing__item-body">
                  {{student.firstname}} {{student.name}}
                  <span class="separator">&bull;</span>
                  {{student.title}}
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p
              class="no-records"
            >Es haben sich noch keine Teilnehmer für dieses Modul angemeldet...</p>
          </div>
          <div class="sb-md">
            <div class="flex-sb">
              <h2 class="is-narrow">Kursunterlagen</h2>
              <a href @click.prevent="toggleUpload()" class="feather-icon feather-icon--prepend">
                <upload-cloud-icon size="16"></upload-cloud-icon>
                <span>Upload</span>
              </a>
            </div>
            <div class="upload-wrapper" v-if="hasUpload">
              <div class="sa-sm">
                <div class="form-row">
                  <file-upload
                    :restrictions="'pdf | max. 8 MB'"
                    :maxFiles="99"
                    :maxFilesize="8"
                    :acceptedFiles="'.pdf'"
                  ></file-upload>
                </div>
              </div>
              <div>
                <div class="form-row">
                  <file-listing :files="files"></file-listing>
                </div>
                <div class="form-row" v-if="files.length">
                  <button type="submit" class="btn-primary" @click.prevent="submit()">Speichern</button>
                </div>
              </div>
            </div>
            <div v-if="course_event.documents.length">
              <div class="listing">
                <div class="listing__item" v-for="d in course_event.documents" :key="d.id">
                  <div class="listing__item-body">
                    <a :href="'/storage/uploads/'+ d.name" target="_blank">
                      <em v-if="d.caption != d.name">{{ d.caption | truncate(30, '...') }}</em>
                      <em v-else>{{ d.name | truncate(30, '...') }}</em>
                    </a>
                    <span class="separator">&bull;</span>
                    <span class="item-info">{{d.type.toUpperCase()}}, {{d.size}}</span>
                  </div>
                  <div class="listing__item-action">
                    <div>
                      <a :href="'/storage/uploads/'+ d.name" target="_blank" class="feather-icon">
                        <download-cloud-icon size="18"></download-cloud-icon>
                      </a>
                    </div>
                    <div>
                      <a href="javascript:;" class="feather-icon" @click.prevent="destroyExisting(d.name)">
                        <trash2-icon size="18"></trash2-icon>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <a href="javascript:history.go(-1)" class="btn-secondary">
            <span>Zurück</span>
          </a>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
// Icons
import {
  UsersIcon,
  UploadCloudIcon,
  Trash2Icon,
  DownloadCloudIcon
} from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import FileUpload from "@/global/components/files/Upload.vue";
import FileListing from "@/global/components/files/Edit.vue";
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    UsersIcon,
    UploadCloudIcon,
    Trash2Icon,
    DownloadCloudIcon,
    FileUpload,
    FileListing,
    ListActions
  },

  props: {
    isAdmin: {
      type: Boolean,
      default: false
    },

    isTutor: {
      type: Boolean,
      default: false
    },

    id: {
      type: String,
      default: null
    }
  },

  mixins: [Helpers],

  data() {
    return {
      course_event: {},
      files: [],

      hasUpload: false,
      isLoading: false,
      isFetched: false
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      if (this.$props.isTutor) {
        let uri = `/api/tutor/course/event/${this.$props.id}`;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data.course_event;
          this.isFetched = true;
        });
      }

      if (this.$props.isAdmin) {
        let uri = `/api/course/event/${this.$props.id}`;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data;
          this.isFetched = true;
        });
      }
    },

    storeFile(upload) {
      let file = {
        name: upload.name,
        caption: null,
        size: upload.size,
        type: upload.type,
        tutor_id: "",
        course_event_id: this.$props.id
      };

      this.files.push(file);
    },

    submit() {
      let uri = "/api/course/event/files";
      this.isLoading = true;
      this.toggleUpload();
      this.axios.post(uri, { documents: this.files }).then(response => {
        this.$notify({ type: "success", text: "Daten gespeichert!" });
        this.files = [];
        this.fetch();
        this.isLoading = false;
      });
    },

    destroy(file) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/event/file/${file}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const idx = this.files.findIndex(x => x.name === file);
          this.files.splice(idx, 1);
          this.isLoading = false;
        });
      }
    },

    destroyExisting(file) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/event/file/${file}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          const idx = this.course_event.documents.findIndex(x => x.name === file);
          this.course_event.documents.splice(idx, 1);
          this.isLoading = false;
        });
      }
    },

    toggleUpload() {
      this.hasUpload = this.hasUpload ? false : true;
    }
  }
};
</script>
