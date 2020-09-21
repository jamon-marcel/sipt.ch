<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>

    <div v-if="hasMessageFormOverlay">
      <create-message-form :courseEvent="course_event.id"></create-message-form>
    </div>

    <div v-if="hasMessageOverlay">
      <show-message :messageId="messageId"></show-message>
    </div>

    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <div class="content">
        <template v-if="isFetched">
          <h1>Modul: <strong>{{ course_event.course.title }}</strong></h1>
          <h2 class="is-narrow">Beschreibung</h2>
          <p v-html="course_event.course.description">{{ course_event.course.description }}</p>
          <hr>
          <h2 class="is-narrow">Ort</h2>
          <p>{{ course_event.location.name }}, {{ course_event.location.city }} – <a :href="course_event.location.maps_uri" target="_blank" class="anchor">Googlemaps</a></p>
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
                <separator />
                {{date.timeStart}} – {{date.timeEnd}} Uhr
                <separator />
                {{date.tutor.title}} {{date.tutor.firstname}} {{date.tutor.name}}
              </div>
            </div>
          </div>
          <div class="flex-sb sb-md">
            <h2 class="is-narrow">
              Angemeldete Teilnehmer
              <em v-if="course_event.students.length">({{course_event.students.length}})</em>
            </h2>
            <a :href="'/download/anwesenheitsliste/' + course_event.id" target="_blank" class="feather-icon feather-icon--prepend">
              <download-cloud-icon size="16"></download-cloud-icon>
              <span>Anwesenheitsliste</span>
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
                  {{student.number}}
                  <separator />
                  {{student.firstname}} {{student.name}}
                  <separator />
                  {{student.city}}
                  <span v-if="student.qualifications">
                    <separator />
                    {{student.qualifications}}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="no-records">Es haben sich noch keine Teilnehmer für dieses Modul angemeldet...</p>
          </div>
          <div class="sb-md">
            <div class="flex-sb">
              <h2 class="is-narrow">Kursunterlagen</h2>
              <a href @click.prevent="toggleUpload()" class="feather-icon feather-icon--prepend">
                <upload-cloud-icon size="16"></upload-cloud-icon>
                <span>Upload</span>
              </a>
            </div>
            <div class="sa-xs">Erlaubt sind die folgenden Formate: PDF, PowerPoint, Word, ZIP</div>
            <div class="upload-wrapper" v-if="hasUpload">
              <div class="sa-sm">
                <div class="form-row">
                  <file-upload
                    :restrictions="'pdf, ppt, pptx, doc, docx, zip | max. 16 MB'"
                    :maxFiles="99"
                    :maxFilesize="8"
                    :acceptedFiles="'.pdf,.ppt,.pptx,.doc,.docx,.zip'"
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
                    <separator />
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
            <hr>
            <div class="sb-md">
              <div class="flex-sb">
                <h2 class="is-narrow">Nachrichten</h2>
                <a href @click.prevent="showMessageForm()" class="feather-icon feather-icon--prepend">
                  <message-square-icon size="16"></message-square-icon>
                  <span>Neue Nachricht</span>
                </a>
              </div>
              <template v-if="isFetchedMessages">
                <div v-if="messages.length">
                  <div class="sb-xs listing">
                    <div
                      class="listing__item"
                      v-for="message in messages"
                      :key="message.id"
                    >
                      <div class="listing__item-body">
                        {{message.date}}
                        <separator />
                        {{message.senderName}}
                        <separator />
                        {{message.subject}}
                      </div>
                      <div class="listing__item-action">
                        <div>
                          <a
                            href="javascript:;"
                            @click.prevent="showMessage(message.id)"
                            class="feather-icon"
                          >
                            <arrow-up-right-icon size="18"></arrow-up-right-icon>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <p class="no-records">Es haben sich noch keine Nachrichten vorhanden...</p>
                </div>
              </template>
            </div>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <a :href="'/download/anwesenheitsliste/' + course_event.id" class="btn-primary has-icon" target="_blank">
            <download-cloud-icon size="16"></download-cloud-icon>
            <span>Anwesenheitsliste</span>
          </a>
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
  DownloadCloudIcon,
  DownloadIcon,
  MessageSquareIcon,
  ArrowUpRightIcon
} from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import FileUpload from "@/global/components/files/Upload.vue";
import FileListing from "@/global/components/files/Edit.vue";
import ListActions from "@/global/components/ui/ListActions.vue";
import CreateMessageForm from "@/administration/views/course_events/CreateMessageForm.vue";
import ShowMessage from "@/global/components/ShowMessage.vue";

export default {
  components: {
    UsersIcon,
    UploadCloudIcon,
    Trash2Icon,
    DownloadCloudIcon,
    DownloadIcon,
    MessageSquareIcon,
    ArrowUpRightIcon,
    FileUpload,
    FileListing,
    ListActions,
    CreateMessageForm,
    ShowMessage
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
      messages: [],
      messageId: null,
      files: [],
      hasUpload: false,
      isLoading: false,
      isFetched: false,
      isFetchedMessages: false,
      hasMessageFormOverlay: false,
      hasMessageOverlay: false,
    };
  },

  mounted() {
    this.fetch();
    this.fetchMessages();
  },

  methods: {
    fetch() {
      if (this.$props.isTutor) {
        let uri = `/api/tutor/course/event/${this.$props.id}`;
        this.isLoading = true;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data.course_event;
          this.isFetched = true;
          this.isLoading = false;
        });
      }

      if (this.$props.isAdmin) {
        let uri = `/api/course/event/${this.$props.id}`;
        this.isLoading = true;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data;
          this.isFetched = true;
          this.isLoading = false;
        });
      }
    },

    fetchMessages() {
      let uri = `/api/messages/${this.$props.id}`;
      this.axios.get(`${uri}`).then(response => {
        this.messages = response.data;
        this.isFetchedMessages = true;
      });
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
    },

    showMessageForm(invoice) {
      this.hasMessageFormOverlay = true;
    },

    hideMessageForm() {
      this.hasMessageFormOverlay = false;
    },

    storeMessage(message) {
      let uri = "/api/message";
      let data = {
        'course_event_id': this.$props.id,
        'subject': message.subject,
        'message': message.message
      };

      this.axios.post(uri, data).then(response => {
        this.$notify({ type: "success", text: "Nachricht wird versendet." });
        this.hideMessageForm();
        this.fetchMessages();
      });
    },

    showMessage(id) {
      this.messageId = id;
      this.hasMessageOverlay = true;
    },

    hideMessage() {
      this.hasMessageOverlay = false;
    },

  }
};
</script>
